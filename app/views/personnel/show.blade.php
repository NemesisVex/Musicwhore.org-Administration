@extends('layout')

@section('page_title')
 &raquo; {{ $member->band->artist_display_name }}
 &raquo; {{ $member->member_display_name }}
@stop

@section('section_header')
<h2>{{ $member->band->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>
	Personnel
	<small>{{ $member->member_display_name }}</small>
</h3>
@stop

@section('content')
<div class="col-md-12">
	<ul class="list-inline">
		<li><a href="{{ route('personnel.edit', array('id' => $member->member_id)) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
		<li><a href="{{ route('personnel.delete', array('id' => $member->member_id)) }}" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
	</ul>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Last name:</label>
			<div class="col-md-9">
				{{ $member->member_last_name }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">First name:</label>
			<div class="col-md-9">
				{{ $member->member_first_name }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Display name:</label>
			<div class="col-md-9">
				{{ $member->member_display_name }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Display order:</label>
			<div class="col-md-9">
				{{ $member->member_order }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Instruments:</label>
			<div class="col-md-9">
				{{ $member->member_instruments }}
			</div>
		</li>
	</ul>

</div>
@stop
