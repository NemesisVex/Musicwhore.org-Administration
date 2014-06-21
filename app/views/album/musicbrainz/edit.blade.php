@extends('album.musicbrainz._form')

@section('page_title')
 &raquo; {{ $album->artist->artist_display_name }}
 &raquo; {{ $album->album_title }}
 &raquo; Musicbrainz Import
@stop

@section('section_header')
<h2>
	{{ $album->artist->artist_display_name }}
	<small>{{ $album->album_title }}</small>
</h2>
@stop

@section('section_label')
<h3>Musicbrainz import</h3>
@stop

@section('content')
{{ Form::model( $album, array( 'route' => array('album-musicbrainz.update', $album->album_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
{{ Form::close() }}
@stop
