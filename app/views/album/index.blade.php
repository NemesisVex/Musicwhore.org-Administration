@extends('layout')

@section('page_title')
 &raquo; Albums &raquo; Browse
@stop

@section('section_header')
<h2>Observant Records</h2>
@stop

@section('section_label')
<h3>
	Albums
	<small>Browse</small>
</h3>
@stop

@section('content')

<p>
	<a href="{{ route('album.create') }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add an album</a>
</p>

@if (count($albums) > 0)
<ol class="track-list">
	@foreach ($albums as $album)
	<li>
		<div>
			<a href="{{ route( 'album.edit', array( 'id' => $album->album_id ) ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route( 'album.delete', array( 'id' => $album->album_id ) ) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<a href="{{ route( 'album.show', array( 'id' => $album->album_id ) ) }}">{{ $album->album_title }} ({{ $album->artist->artist_display_name}})</a>
		</div>
	</li>
	@endforeach
</ol>
@endif

@stop
