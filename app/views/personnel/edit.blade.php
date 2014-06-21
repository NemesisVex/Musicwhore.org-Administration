@extends('personnel._form')

@section('page_title')
 &raquo; {{ $member->band->artist_display_name }}
 &raquo; {{ $member->member_display_name }}
 &raquo; Delete
@stop

@section('section_header')
<h2>{{ $member->band->member_display_name }}</h2>
@stop

@section('section_label')
<h3>
	Edit
	<small>{{ $member->member_display_name }}</small>
</h3>
@stop

@section('content')
{{ Form::model( $member, array( 'route' => array('personnel.update', $member->member_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
{{ Form::close() }}
@stop
