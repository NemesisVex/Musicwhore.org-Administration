@extends('track._form')

@section('page_title')
 &raquo; {{ $track->release->album->artist->artist_display_name }}
 &raquo; {{ $track->release->album->album_title }}
@if (!empty($release->release_catalog_num)) &raquo; {{ $release->release_catalog_num }} @endif
 &raquo; {{ $track->song->song_title }}
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
	<small>{{ $track->song->song_title }}</small>
</h3>
@stop

@section('content')
{{ Form::model( $track, array( 'route' => array('track.update', $track->track_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
{{ Form::close() }}
@stop

@section('sidebar')
@if (!empty($track->release))
<p>
	<img src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/artists/{{ $track->release->album->artist->artist_alias }}/albums/{{ $track->release->album->album_alias }}/{{ strtolower($track->release->release_catalog_num) }}/images/cover_front_medium.jpg" width="230" />
</p>

<ul>
	<li><a href="{{ route('track.show', array( 'id' => $track->track_id )) }}/">Back to <em>{{ $track->song->song_title }}</em></a></li>
	<li><a href="{{ route('release.show', array( 'id' => $track->release->release_id )) }}/">Back to <em>{{ $track->release->album->album_title }}</em> @if (!empty($track->release->release_catalog_num)) ({{ $track->release->release_catalog_num }}) @else (TBD) @endif</a></li>
</ul>
@endif
@stop