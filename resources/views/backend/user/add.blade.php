@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Compila e invia per aggiungere un nuovo utente</div>
                <div class="panel-body">

                	{{-- errori di validazione form --}}
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
                			<label for="first_name">Nome:</label> 
                			<input type="text" class="form-control" name="first_name" id="first_name" /> 
                		</p>

                		<p>
                			<label for="last_name">Cognome:</label> 
                			<input type="text" class="form-control" name="last_name" id="last_name" />
                		</p>

                		<p> 
                			<label for="email">Indirizzo Email:</label> 
                			<input type="text" class="form-control" name="email" id="email" /> 
                		</p>

                		<p> 
                			<label for="password">Password:</label> 
                			<input type="password" class="form-control" name="password" id="password" /> 
                		</p>

                		<p> 
                			<label for="password-confirm">Reimmetti password:</label> 
                			<input type="password" class="form-control" name="password_confirmation" id="password-confirm" /> 
                		</p>

                		<hr/>

                		<p>
                			<button class="btn btn-success form-control">Aggiungi Utente</button>
                		</p>

                	</form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection