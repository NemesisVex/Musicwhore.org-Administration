@extends('layout')

@section('page_title')
 &raquo; Tracks &raquo; Browse
@stop

@section('section_header')
<h2>Observant Records</h2>
@stop

@section('section_label')
<h3>
	Tracks
	<small>Browse</small>
</h3>
@stop

@section('content')

<p>
	<a href="{{ route('track.create') }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add a release</a>
</p>

@if (count($tracks) > 0)
<ol class="track-list">
	@foreach ($tracks as $track)
	<li>
		<div>
			<a href="{{ route( 'track.edit', array( 'id' => $track->track_id ) ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route( 'track.delete', array( 'id' => $track->track_id ) ) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<a href="{{ route( 'track.show', array( 'id' => $track->track_id ) ) }}">{{ $track->song->song_title }}</a>
		</div>
	</li>
	@endforeach
</ol>
@endif

@stop
