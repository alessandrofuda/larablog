@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;">Elenco di tutti gli articoli presenti in db</div>
                <div class="panel-body">

                		<div class="text-center">
                			{!! $articles->render()  /* paginazione */ !!}
                		</div>

                	<table class="table table-striped">
                		<thead>
                			<td><b>Titolo</b></td>
                			<td><b>Autore</b></td>
                			<td><b>Categorie</b></td>
                			<td><b>Data di pubblicazione</b></td>
                			<td><b>Stato</b></td>
                			<td><b>Operazioni</b></td>
                		</thead>

                		@foreach ($articles as $article)
                		
                		<tr>
                			<td>{{ $article->title }}</td>
                			<td>{{ $article->user->first_name . ' ' . $article->user->last_name }}</td> {{--  questa info è presa dalla tabella users correlata alla tabella articles (via Model e Eager Loading --}}
                			<td>{{ $article->categories()->get()->implode('name', ', ') }}</td>
                			<td>{{ date('d/m/Y - H:i' , strtotime($article->published_at)) }}</td>
                			<td>
                				@if ($article->is_published)
                					<span style="color: green;">Pubblicato</span>
                				@else 
                					<span style="color: red;">Non pubblicato</span>
                				@endif
                			</td>
                			<td>

                                @if ($article->is_published && ! Auth::user()->isAdmin())

                                    <div class="btn btn-default" style="white-space: normal;">Solo l'Admin può editare articoli pubblicati</div>

                                @else

                				    {{-- @if (Auth::user()->isAdmin()) --}}
                                        <a class="btn btn-info" href="{{ url('backend/articles/edit/' . $article->id) }}">Modifica</a>
                                    {{-- @else
                                        <a class="btn btn-info" href="{{ url('backend/my-articles/edit/' . $article->id) }}">Modifica il mio articolo</a>
                                    @endif --}}

                    				<form style="display: inline-block;" action="{{ url('backend/articles/delete/' . $article->id) }}" method="post">
    									{{ csrf_field() }}
    									<input class="btn btn-danger" type="submit" name="delete" value="Cancella" onclick="return confirm('Confermare la cancellazione dell\'articolo?')" /> 
                    				</form>

                                @endif

                			</td>
                		</tr>

                		@endforeach

                	</table>

                	<a class="btn btn-info" href="{{ url('backend/articles/add') }}">Aggiungi un nuovo articolo</a>

                	<div class="text-center">
                		{{ $articles->render() /* paginazione */ }}
                	</div>

                </div>
               	</div>
           	</div>
       	</div>
   	</div>
</div>

@endsection