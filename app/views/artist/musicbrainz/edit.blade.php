@extends('artist.musicbrainz._form')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
 &raquo; Musicbrainz Import
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Musicbrainz import</h3>
@stop

@section('content')
{{ Form::model( $artist, array( 'route' => array('artist-musicbrainz.update', $artist->artist_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
{{ Form::close() }}
@stop
