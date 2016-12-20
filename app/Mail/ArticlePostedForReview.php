<?php

namespace App\Mail; 

use App\Article;   // per importare dati sull'articolo
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticlePostedForReview extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *  Istanza Article
     *
     * @var Article
     */
    protected $article;
    


    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(Article $article)   // Article $article
    {
        $this->article = $article;
        
    }



    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {

        $italian_date = explode(' ', $this->article->published_at);
        $ora = $italian_date[1];
        $italian_date = $italian_date[0]; 
        $italian_date = explode('-', $italian_date);
        $italian_date = implode('/', array_reverse($italian_date));

        return $this->from('admin@larablog.com', 'Larablog-Admin')         //per il TESTING --> settare il driver a 'log' in /config/mail.php
                    ->subject('Larablog: un autore ha inviato un articolo per la revisione')
                    ->view('emails.article_posted_for_review')      //, compact('article'));
                    ->with([
                        'articleTitle' => $this->article->title,
                        'articleId' => $this->article->id,
                        'articleDate' => $italian_date,
                        'articleHours' => $ora,
                        'userSenderId' => $this->article->user_id,
                        'userSenderFirstName' => $this->article->user()->first()->first_name,  // usare ->first()-> per estrarre valore (first_name) da related table
                        'userSenderLastName' => $this->article->user()->first()->last_name,
                        ]);                    

                    //->text('emails.article_posted_for_review_plaintext');
    }


}
