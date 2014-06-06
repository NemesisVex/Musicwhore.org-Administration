@extends('album._form')

@section('page_title')
@if (!empty($album->artist->artist_display_name))
 &raquo; {{ $album->artist->artist_display_name }}
@endif
 &raquo; Album
 &raquo; Add
@stop

@section('section_header')
<h2>
	@if (!empty($album->artist->artist_display_name))
	{{ $album->artist->artist_display_name }}
	@else
	Observant Records
	@endif
</h2>
@stop

@section('section_label')
<h3>Add a new album</h3>
@stop

@section('content')
{{ Form::model( $album, array( 'route' => 'album.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post' ) ) }}
@parent
{{ Form::close() }}
@stop
