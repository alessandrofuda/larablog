@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Il mio Profilo</div>
                <div class="panel-body">

                    <table class="table table-striped">
                    	<!--<thead></thead>-->

	                    <tr>
	                    	<td>Id:</td>
	                    	<td>{{ Auth::user()->id }}</td>
	                    </tr> 
	                    <tr>
	                    	<td>Nome:</td>
	                    	<td>{{ Auth::user()->first_name }}</td>
	                    </tr> 
	                    <tr>
	                    	<td>Cognome:</td>
	                    	<td>{{ Auth::user()->last_name }}</td>
	                    </tr> 
	                    <tr>
	                    	<td>Url:</td>
	                    	<td>{{ url(Auth::user()->slug) }}</td>
	                    </tr>
	                    <tr>
	                    	<td>Email:</td>
	                    	<td>{{ Auth::user()->email }}</td>
	                    </tr>
	                    <!--<tr>
	                    	<td>Password:</td>
	                    	<td>{{-- Auth::user()->pasXXsword --}}</td>
	                    </tr>-->
	                    <tr>
	                    	<td>Account creato il:</td>
	                    	<td>{{ date('d/m/Y  H:i', strtotime(Auth::user()->created_at)) }}</td>
	                    </tr>
	                    <tr>
	                    	<td></td>
	                    	<td></td>
	                    </tr>

                    </table>
                    <div class="text-center">
                    	<a href="{{ url('backend/myprofile/update') }}" class="btn btn-danger">Modifica il mio profilo</a>
                    	<form style="display: inline-block;" action="{{ url('backend/myprofile/delete') }}" method="post">
							{{ csrf_field() }}
							<input class="btn btn-danger" type="submit" name="delete" value="Cancella il mio profilo" onclick="return confirm('Sei sicuro di voler cancellare il tuo profilo?')" /> 
                		</form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection