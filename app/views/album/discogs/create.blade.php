@extends('album.musicbrainz._form')

@section('page_title')
 &raquo; {{ $album->artist->artist_display_name }}
 &raquo; Albums &raquo; Musicbrainz Import
@stop

@section('section_header')
<h2>{{ $album->artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Musicbrainz import</h3>
@stop

@section('content')
{{ Form::model( $album, array( 'route' => 'album-musicbrainz.store', 'class' => 'form-horizontal', 'role' => 'form' ) ) }}
@parent
{{ Form::close() }}
@stop
