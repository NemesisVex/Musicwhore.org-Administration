@extends('layout')

@section('page_title')
 &raquo; Administration
@stop

@section('section_header')
<h2>Home</h2>
@stop

@section('section_label')

@stop

@section('seciton_sublabel')
@stop

@section('content')

<div class="col-md-12">
	<ul>
		<li><a href="{{ route( 'artist.index', array('browse' => 'a') ) }}">Manage artists</a></li>
		<li><a href="{{ route( 'amazon.index' ) }}">Amazon search</a></li>
	</ul>
</div>

@stop
