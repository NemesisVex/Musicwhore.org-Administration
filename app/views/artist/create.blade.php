@extends('artist._form')

@section('page_title')
 &raquo; Artists &raquo; Add a new artist
@stop

@section('section_header')
<h2>Artists</h2>
@stop

@section('section_label')
<h3>Add a new artist</h3>
@stop

@section('content')
{{ Form::model( $artist, array( 'route' => 'artist.store', 'class' => 'form-horizontal', 'role' => 'form' ) ) }}
@parent
{{ Form::close() }}
@stop
