{{-- dump($categories) --}}


@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;">Aggiungi un nuovo articolo</div>
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
                    
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <p>
                        	<label for="title">Titolo:</label>
                        	<input type="text" class="form-control" name="title" id="title" />
                        </p>

                        <p>
                        	<label for="body">Testo:</label>
                        	<textarea class="form-control" name="body" id="body" cols="30" rows="10" ></textarea>
                        </p>

                        <p>
                        	<label for"categories">Categorie: </label>
                        	<select class="form-control" name="categories[]" id="categories" multiple>

                        		@foreach( $categories as $category )

                        			<option value="{{ $category->id }}">{{ $category->name }}</option>

                        		@endforeach

                        	</select>
                        </p>

                        <hr>

                        <div class="row">
                        	<div class="col-md-6">
                        		<p>
                        			<label for="is_published">Stato:</label>
                        			<select name="is_published" id="is_published" class="form-control" {!! $notice !!} {{ $disabled }}>
                        				<option value="0">Bozza</option>
                        				<option value="1">Pubblicato</option>
                        			</select>
                        		</p>
                        	</div>

                        	<div class="col-md-6">
                        		<p>
                        			<label for="published_at">Data di pubblicazione:</label>
                        			<input class="form-control" type="text" name="published_at" id="published_at" value="{{ date('d/m/Y H:i') }}" placeholder="gg/mm/aaaa hh:mm" />
                        		</p>
                        	</div>
                        </div>

                        <hr>

                        <div class="row">
                        	<div class="col-md-6">
                        		<p>
                        			<label for="metakeys">Meta Keywords:</label>
                        			<input type="text" name="metakeys" class="form-control" id="metakeys" />
                        		</p>
                        	</div>

                        	<div class="col-md-6">
                        		<p>
                        			<label for="metadescription">Meta Description:</label>
                        			<input type="text" class="form-control" name="metadescription" id="metadescription" />
                        		</p>
                        	</div>
                        </div>

                        <hr>

                        <div class="row">
                            @if (Auth::user()->isAdmin())
                                <div class="col-md-12">
                                    <p><button class="btn btn-success form-control" name="salva" value="save">{{ $button }}</button></p>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <p><button class="btn btn-success form-control" name="salva" value="save">Salva</button></p>
                                </div>
                                <div class="col-md-6">
                                    <p><button class="btn btn-success form-control" name="salva_e_invia" value="save_and_send">{{ $button }}</button></p>
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
                    	}); 

                    </script>

                </div>
           	</div>
       	</div>
   	</div>
</div>

@endsection