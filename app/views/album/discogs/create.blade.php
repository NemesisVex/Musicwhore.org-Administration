@extends('album.discogs._form')

@section('page_title')
 &raquo; {{ $album->artist->artist_display_name }}
 &raquo; Albums &raquo; Discogs Import
@stop

@section('section_header')
<h2>{{ $album->artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Discogs import</h3>
@stop

@section('content')
{{ Form::model( $album, array( 'route' => 'album-discogs.store', 'class' => 'form-horizontal', 'role' => 'form' ) ) }}
@parent
{{ Form::close() }}
@stop
