@extends('layout')

@section('page_title')
 &raquo; Artists &raquo; Personnel &raquo; Browse
@stop

@section('section_header')
<h2>Artists</h2>
@stop

@section('section_label')
<h3>Browse
	<small>Personnel</small>
</h3>
@stop

@section('content')
<div class="col-md-12">
	<p>
		<a href="{{ route('personnel.create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add a member</a>
	</p>

	@if (!empty($members))

	<ul class="list-unstyled">
		@foreach ($members as $member)
		<li>
			<div>
				<ul class="list-inline">
					<li><a href="{{ route('personnel.edit', array('id' => $member->member_id) ) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> <span class="sr-only">Edit</span></a></li>
					<li><a href="{{ route('personnel.delete', array('id' => $member->member_id) ) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span> <span class="sr-only">Delete</span></a></li>
					<li><a href="{{ route('personnel.show', array('id' => $member->member_id) ) }}" title="[View {{ $member->member_display_name }}]">{{ $member->member_display_name }}</a></li>
				</ul>
			</div>
		</li>
		@endforeach
	</ul>

	@else

	<p>
		No personnel found.
	</p>

	@endif
</div>

@stop
