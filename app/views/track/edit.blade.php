@extends('track._form')

@section('page_title')
 &raquo; {{ $track->release->album->artist->artist_display_name }}
 &raquo; {{ $track->release->album->album_title }}
@if (!empty($release->release_catalog_num)) &raquo; {{ $release->release_catalog_num }} @endif
 &raquo; {{ $track->track_song_title }}
 &raquo; Edit
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
	Edit
	<small>{{ $track->track_song_title }}</small>
</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::model( $track, array( 'route' => array('track.update', $track->track_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
	@parent
	{{ Form::close() }}
</div>
@stop
