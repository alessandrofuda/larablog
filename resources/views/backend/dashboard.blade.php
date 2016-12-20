@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div>{{ Auth::user()->first_name }}, sei loggato come <span style="color:red; font-style: italic;">{{ $rule }}</span> </div>

                    <hr>

                    <div><a href="{{ url('backend/myprofile') }}">Il mio profilo</a></div>

                    <hr>

                    <div><a href="{{ url('backend/users') }}">Elenco utenti</a></div>

                    @if (Auth::user()->isAdmin())
                    <div><a href="{{ url('backend/users/add') }}">Aggiungi un utente</a></div>
                    @endif
                    
                    <hr>

                    <div><a href="{{ url('backend/categories') }}">Elenco categorie</a></div>

                    @if (Auth::user()->isAdmin())
                    <div><a href="{{ url('backend/categories/add') }}">Aggiungi una categoria</a></div>
                    <hr>
                    @endif
                    

                    @if (Auth::user()->isAdmin())
                    <div><a href="{{ url('backend/articles') }}">Elenco di tutti gli articoli</a></div>
                    @endif

                    <hr>
                        
                    <div><a href="{{ url('backend/my-articles') }}">Elenco dei miei articoli</a></div>
                        

                    <hr>
                    
                    <div><a class="btn btn-primary" href="{{ url('backend/articles/add') }}">Aggiungi un articolo</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
