@extends('layout')

@section('page_title')
 &raquo; {{ $track->release->album->artist->artist_display_name }}
 &raquo; {{ $track->release->album->album_title }}
@if (!empty($release->release_catalog_num)) &raquo; {{ $release->release_catalog_num }} @endif
 &raquo; {{ $track->track_song_title }}
 &raquo; Delete
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
	Delete
	<small>{{ $track->track_song_title }}</small>
</h3>
@stop

@section('content')

<p>
	You are about to delete <strong>{{ $track->track_song_title }}</strong> from the database.
</p>

<p>
	Are you sure you want to do this?
</p>

{{ Form::model( $track, array( 'route' => array( 'track.destroy', $track->track_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) }}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '1') }} Yes, I want to delete {{ $track->track_song_title }}.
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '0') }} No, I don't want to delete {{ $track->track_song_title }}.
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-12">
		{{ Form::submit('Confirm', array( 'class' => 'button' )) }}
	</div>
</div>

{{ Form::close() }}

@stop
