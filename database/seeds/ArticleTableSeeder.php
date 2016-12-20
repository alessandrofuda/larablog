<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Article;
use App\Category;
use App\User;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('it_IT');

        $categoriesIDs = $this->getCategoriesIdsArray(); // array formato dagli ID delle categorie

        for($c = 0; $c < 50; $c++){  //50: numero articoli da creare

        	$title= $faker->sentence();
        	$slug = Str::slug($title);

        	//creo l'articolo
        	$article = Article::create([
        		'title' => $title,
        		'slug' => $slug, 
        		'body' => '<p>'.$faker->paragraph(10).'</p>', 
        		'is_published' => $faker->boolean(80), 
        		'published_at' => $faker->dateTimeThisYear($max = 'now'), 
        		'meta_keys' => implode(',', $faker->words(5)), 
        		'meta_description' => $faker->sentence(), 

        		// associo casualmente un autore all'articolo 
        		'user_id' => User::inRandomOrder()->first()->id, // --> se non c'è già almeno un user in tabella, dà !!! ERRORE !!!
        	]);

        	// associo le categorie casualmente (una o due per articolo) 
        	$article->categories()->sync($faker->randomElements($categoriesIDs, mt_rand(1, 2)));

        }
    }






    private function getCategoriesIdsArray() {
    	$result = [];
    	$categories = Category::all();
    	foreach ($categories as $category) {
    		$result[] = $category->id;
    	}

    	return $result;
    }
}
