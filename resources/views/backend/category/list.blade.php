@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;">Elenco di tutte le Categorie</div>
                <div class="panel-body">
                	<table class="table table-striped">
                		<thead>
                			<td><b>Nome Categoria</b></td>
                			<td><b>Totale Articoli</b></td>
                			<td><b>Data di creazione</b></td>

                            @if(Auth::user()->isAdmin())
                			<td><b>Operazioni</b></td>
                            @endif

                		</thead>

                		@foreach ($categories as $category)
                		
                		<tr>
                			<td>{{ $category->name }}</td>
                			<td>{{ $category->articles->count() }}</td>
                			<td>{{ date('d/m/Y  - H:i', strtotime($category->created_at)) }}</td>

                            @if(Auth::user()->isAdmin())
                			<td>
                				<a class="btn btn-info" href="{{ url('backend/categories/edit/' . $category->id) }}">Modifica</a>
                				<!--<a class="btn btn-danger" href="{{ url('backend/categories/delete/' . $category->id) }}" onclick="return confirm('Sei sicuro di voler cancellare la categoria?')">Elimina</a>-->
                				<form style="display: inline-block;" action="{{ url('backend/categories/delete/' . $category->id) }}" method="post">
                					{{ csrf_field() }}
									<input class="btn btn-danger" type="submit" name="delete" value="Elimina">                					
                				</form>

                			</td>
                            @endif

                		</tr>

                		@endforeach

                	</table>

                    @if(Auth::user()->isAdmin())
                	<a class="btn btn-info" href="{{ url('backend/categories/add') }}">Aggiungi nuova categoria</a>
                    @endif

                    <a class="btn btn-default" href="{{ url('backend') }}">Torna</a>

                	{{ $categories->render() /*paginazione*/ }}

                </div>
               	</div>
           	</div>
       	</div>
   	</div>
</div>

@endsection