@extends('layout')

@section('page_title')
 &raquo; Administration
@stop

@section('section_head')
<h2>Home</h2>
@stop

@section('section_label')

@stop

@section('seciton_sublabel')
@stop

@section('content')

<div class="col-md-12">
	<ul>
		<li><a href="{{ route( 'artist.index', array('browse' => 'a') ) }}">Manage artist</a></li>
	</ul>
</div>

@stop
