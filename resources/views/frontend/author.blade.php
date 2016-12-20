@extends('frontend.master.layout') 

@section('title') 
Tutti gli articoli di {{ $author->first_name . ' ' . $author->last_name }} 
@endsection 



@section('subheading') 
Tutti gli articoli di {{ $author->first_name . ' ' . $author->last_name }} 
@endsection


@section('content') 

	@foreach($articles as $article) 

		@include('frontend.includes.articles_list_item', ['article' => $article]) 

	@endforeach 

	<div style="text-align: center;"> {!! $articles->render() !!} </div> {{-- pagination --}} 

@endsection