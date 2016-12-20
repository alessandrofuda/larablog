@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;">Elenco degli Utenti Abilitati</div>
                <div class="panel-body">
                	<table class="table table-striped">
                		<thead>
                			<td><b>Nome</b></td>
                			<td><b>Cognome</b></td>
                			<td><b>Email</b></td>
                			<td><b>Data inserimento</b></td>
                            <td><b>Ruolo</b></td>

                            @if (Auth::user()->isAdmin())
                            <td><b>Operazioni</b></td>
                            @endif
                			
                		</thead>

                		@foreach ($users as $user)

                		<tr>
                			<td>{{ $user->first_name }}</td>
                			<td>{{ $user->last_name }}</td>
                			<td>{{ $user->email }}</td>
                			<td>{{ date('d/m/Y H:i', strtotime($user->created_at)) }}</td>
                            <td>{{ $user->admin === 1 ? 'Amministratore' : 'Autore' }}</td>

                            @if (Auth::user()->isAdmin())
                			<td>

                				<a class="btn btn-primary" href="{{ url('backend/users/edit/'.$user->id) }}">Modifica</a>
                                <a class="btn btn-danger" href="{{ url('backend/users/delete/'.$user->id) }}" onclick="return confirm('Sicuro di voler cancellare questo utente?')">Elimina utente</a>

                			</td>
                            @endif

                		</tr>

                		@endforeach

                	</table>

                    @if (Auth::user()->isAdmin())
                        <a class="btn btn-primary" href="{{ url('backend/users/add') }}">Aggiungi un nuovo utente</a>
                    @endif

                        <a class="btn btn-default" href="{{ url('backend') }}">Torna</a>

                	<!--pagination-->
                	<center>{{ $users->render() }}</center> 

                </div>
            </div>
        </div>
    </div>
</div>

@endsection