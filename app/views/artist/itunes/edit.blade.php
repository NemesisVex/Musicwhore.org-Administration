@extends('artist.itunes._form')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
 &raquo; iTunes Import
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>iTunes import</h3>
@stop

@section('content')
{{ Form::model( $artist, array( 'route' => array('artist-itunes.update', $artist->artist_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
{{ Form::close() }}
@stop
