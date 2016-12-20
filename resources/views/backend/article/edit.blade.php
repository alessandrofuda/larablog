@extends('layouts.app')


{{-- dump($categories) --}}
{{-- dump($article)    --}}


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;">Modifica l'articolo <b>{{ $article->id }}</b>:<br>"{{ $article->title }}"</div>
                <div class="panel-body">

                    @if(count($errors->all()) > 0) 

                        <div class="alert alert-danger" role="alert"> 

                            <p><b>Attenzione!</b></p> 

                            <ul> 

                                @foreach($errors->all() as $error) 

                                    <li>{{ $error }}</li> 

                                @endforeach 

                            </ul> 

                        </div> 

                    @endif

                    <form action="" method="post"> 

                    	<input type="hidden" name="_token" value="{{ csrf_token() }}"/> 
                        <p>
                            <label>Autore:</label> {{ $article->user->first_name . ' ' . $article->user->last_name }}
                        </p>

                    	<p> 
                    		<label for="title">Titolo:</label> 
                    		<input type="text" class="form-control" name="title" id="title" value="{{$article->title}}" /> 
                    	</p> 

                    	<p> 
                    		<label for="body">Testo dell'articolo:</label> 
                    		<textarea class="form-control" name="body" id="body" cols="30" rows="10">{{$article->body}}</textarea> 
                    	</p> 

                    	<p> 
                    		<label for="categories">Categorie:</label> 
                    		<select class="form-control" name="categories[]" id="categories" multiple> 

	                    		@foreach($categories as $category) 

	                    			<option id="category{{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option> 

	                    		@endforeach 

                    		</select> 

                    	</p> 

                    	<hr/> 

                    	<div class="row"> 

                    		<div class="col-md-6"> 
                    			<p> 
                    				<label for="is_published">Stato:</label> 
                    				<select name="is_published" id="is_published" class="form-control" title="{{ $notice }}" {{ $disabled }}> 
	                    				<option value="0">Bozza</option> 
	                    				<option value="1">Pubblicato</option> 
                    				</select> 
                    			</p> 
                    		</div> 

                    		<div class="col-md-6"> 
                    			<p> 
                    				<label for="published_at">Data ultimo salvataggio:</label> 
                    				<input class="form-control" type="text" name="published_at" id="published_at" value="{{ date('d/m/Y H:i', strtotime($article->updated_at)) }}" placeholder="gg/mm/aaaa oo:mm" /> 
                    			</p> 
                    		</div> 
                    	</div> 

                    	<hr/> 

                    	<div class="row"> 

                    		<div class="col-md-6"> 
                    			<p> 
                    				<label for="metakeys">Meta Keys:</label> 
                    				<input type="text" class="form-control" name="metakeys" id="metadkeys" value="{{ $article->meta_keys }}" /> 
                    			</p> 
                    		</div> 

                    		<div class="col-md-6"> 
                    			<p> 
                    				<label for="metadescription">Meta Description:</label> 
                    				<input type="text" class="form-control" name="metadescription" id="metadescription" value="{{ $article->meta_description }}" /> 
                    			</p> 
                    		</div> 
                    	</div> 

                    	<hr/> 

                        <div class="row">

                            @if (Auth::user()->isAdmin())

                                <div class="col-md-12">
                                    <p><button class="btn btn-success form-control" name="save" value="salva">Salva le Modifiche</button></p>
                                </div>

                            @else

                                <div class="col-md-6">
                                    <p><button class="btn btn-success form-control" name="save" value="salva">Salva Modifiche</button></p>
                                </div>

                                <div class="col-md-6">
                                    <p><button class="btn btn-success form-control" name="save_and_send" value="salva_e_invia">Salva e Invia per la Revisione</button></p>
                                </div>

                            @endif 

                        </div>

                    </form>

                    <!-- librerie css/js/jQuery tinymce e select2 (jQuery plugin) per text editor e categories multiple select-->
                    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
                    <link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
					<script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                    <script src="http://cdn.tinymce.com/4/tinymce.min.js"></script> 

                    <script> 
                    	// tinymce per user friendly text editor
                    	tinymce.init({ 	selector:'textarea#body', 
                    					plugins: [], 
                    					toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image" 
                    				}); 
                    
                    	// select2 per selez multipla categorie
                    	$(document).ready(function(){ 
                    		$("select#categories").select2({
                    			placeholder: "Clicca per selezionare una o più categorie",	
                    		}); 

                    		$('#is_published').val('{{ $article->is_published }}'); // precompila published status
                    		$("#categories").val({{ $article->categories->pluck('id') }}).trigger('change');  // insert categories Id from db  
                    			// Tramite il metodo pluck (usato sulla collection categories) estraggo gli id delle categorie. Che vengono automaticamente mandati in output come un array JSON, quindi compatibile con il metodo val().
                    	}); 

                    </script>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection