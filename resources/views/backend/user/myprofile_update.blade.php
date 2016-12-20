@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Modifica qui il tuo Profilo</div>
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

                	<form class="" action="" method="post">
                		<input type="hidden" name="_token" value="{{ csrf_token() }}"/>

	                    <table class="table table-striped">
	                    	<!--<thead></thead>-->

		                    <tr>
		                    	<td>Id:</td>
		                    	<td>{{ Auth::user()->id }}</td>
		                    </tr> 
		                    <tr>
		                    	<td>
		                    		<label for="first_name">Nome:</label>
		                    	</td>
		                    	<td>
		                    		<input type="text" name="first_name" value="{{ Auth::user()->first_name }}" />
		                    	</td>
		                    </tr> 
		                    <tr>
		                    	<td>
		                    		<label for="last_name">Cognome:</label>
		                    	</td>
		                    	<td>
		                    		<input type="text" name="last_name" value="{{ Auth::user()->last_name }}" />
		                    	</td>
		                    </tr> 
		                    <tr>
		                    	<td>Url:</td>
		                    	<td>{{ url(Auth::user()->slug) }}</td>
		                    </tr>
		                    <tr>
		                    	<td>
		                    		<label for="email">Email:</label>
		                    	</td>
		                    	<td>
		                    		<input type="email" name="email" value="{{ Auth::user()->email }}" />
		                    	</td>
		                    </tr>
		                    <tr>
		                    	<td>
		                    		<label for="password">Nuova Password:</label>
		                    	</td>
		                    	<td>
		                    		<input type="password" name="password" />
		                    	</td>
		                    </tr>
		                    <tr>
		                    	<td>
		                    		<label for="password-confirm">Reimmetti la Password:</label>
		                    	</td>
		                    	<td>
		                    		<input type="password" name="password_confirmation" />
		                    	</td>
		                    </tr>

		                    <tr>
		                    	<td>Account creato il:</td>
		                    	<td>{{ date('d/m/Y  H:i', strtotime(Auth::user()->created_at)) }}</td>
		                    </tr>
		                    <tr>
		                    	<td></td>
		                    	<td><button class="btn btn-danger">Convalida le modifiche</button></td>
		                    </tr>

	                    </table>
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection