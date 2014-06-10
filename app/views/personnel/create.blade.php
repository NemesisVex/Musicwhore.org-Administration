@extends('personnel._form')

@section('page_title')
 &raquo; Artists &raquo; Add a new member
@stop

@section('section_header')
<h2>Artists</h2>
@stop

@section('section_label')
<h3>Add a new member</h3>
@stop

@section('content')
{{ Form::model( $member, array( 'route' => 'personnel.store', 'class' => 'form-horizontal', 'role' => 'form' ) ) }}
@parent
{{ Form::close() }}
@stop
