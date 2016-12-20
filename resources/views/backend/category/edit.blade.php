@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;">Utilizza il form per modificare una categoria</div>
                <div class="panel-body">

                    @if( count($errors->all()) > 0 )

                    <div class="alert alert-danger" role="alert">
                        <p><b>Attenzione ! </b></p>
                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach
                            
                        </ul>
                    </div>

                    @endif
                    
                    <form action="" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <p>
                            <label for="name">Nome: </label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $category->name }}" />
                        </p>

                        <p>
                            <label for="description">Descrizione: </label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Indica una breve descrizione della categoria...">{{ $category->description }}</textarea>
                        </p>

                        <hr>

                        <button class="btn btn-success form-control">Salva categoria</button>

                    </form>

                </div>
           	</div>
       	</div>
   	</div>
</div>

@endsection