@extends('layout')

@section('page_title')
 &raquo; {{ $track->release->album->artist->artist_display_name }}
 &raquo; {{ $track->release->album->album_title }}
@if (!empty($release->release_catalog_num)) &raquo; {{ $release->release_catalog_num }} @endif
 &raquo; {{ $track->track_song_title }}
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $track->release->album->artist->artist_display_name }}
		<small>{{ $track->release->album->album_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>
	Track info
	<small>{{ $track->track_song_title }}</small>
</h3>
@stop

@section('content')
<div class="col-md-12">
	<ul class="list-inline">
		<li><a href="{{ route( 'track.edit', array( 'id' => $track->track_id ) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
		<li><a href="{{ route( 'track.delete', array( 'id' => $track->track_id ) ) }}" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
	</ul>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Disc no.</label>
			<div class="col-md-9">
				{{ $track->track_disc_num }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Track no.</label>
			<div class="col-md-9">
				{{ $track->track_track_num }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Title</label>
			<div class="col-md-9">
				{{ $track->track_song_title }}
			</div>
		</li>
		@if (!empty($track->track_alt_title))
		<li class="row">
			<label class="col-md-3">Alternate title</label>
			<div class="col-md-9">
				{{ $track->track_alt_title }}
			</div>
		</li>
		@endif
		@if (!empty($track->track_sort_title))
		<li class="row">
			<label class="col-md-3">Sort title</label>
			<div class="col-md-9">
				{{ $track->track_sort_title }}
			</div>
		</li>
		@endif
		@if (!empty($track->track_va_artist_id))
		<li class="row">
			<label class="col-md-3">Track artist</label>
			<div class="col-md-9">
				{{ Artist::find($track->track_va_artist_id)->first()->artist_display_name }}
			</div>
		</li>
		@endif
	</ul>

	<h3>Settings</h3>

	<ul class="list-inline">
		<li><a href="{{ route( 'track-setting.edit', array( 'id' => $track->track_id ) ) }}" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
	</ul>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">iTunes ID</label>
			<div class="col-md-9">
				{{ $track->meta->itunes_id }}
			</div>
		</li>
	</ul>
</div>
@stop
