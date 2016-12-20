@extends('frontend.master.layout') 

@section('title') Tutti gli articoli nella Categoria: {{ $currentCategory->name }} @endsection 

@section('subheading') Tutti gli articoli nella Categoria: {{ $currentCategory->name }} @endsection 


@section('content') 

	@foreach($articles as $article) 

		@include('frontend.includes.articles_list_item', ['article' => $article]) 

	@endforeach 

	<div style="text-align: center;"> {!! $articles->render() !!} </div> 

@endsection