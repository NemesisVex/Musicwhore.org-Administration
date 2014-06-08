@extends('artist.meta._form')

@section('page_title')
&raquo; {{ $artist->artist_display_name }}
&raquo; Edit Settings
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Edit Settings</h3>
@stop

@section('content')
{{ Form::model( $artist, array( 'route' => array('artist-setting.update', $artist->artist_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
{{ Form::close() }}
@stop
