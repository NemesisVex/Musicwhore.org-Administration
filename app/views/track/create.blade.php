@extends('track._form')

@section('page_title')
@if (!empty($track->release))
 &raquo; {{ $track->release->album->artist->artist_display_name }}
 &raquo; {{ $track->release->album->album_title }}
@endif
@if (!empty($release->release_catalog_num))
 &raquo; {{ $release->release_catalog_num }}
@endif
 &raquo; Add a track
@stop

@section('section_header')
<hgroup>
	<h2>
		@if (!empty($track->release))
		{{ $track->release->album->artist->artist_display_name }}
		<small>{{ $track->release->album->album_title }}</small>
		@else
		Observant Records
		@endif
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Add a track</h3>
@stop

@section('content')
{{ Form::model( $track, array( 'route' => 'track.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post' ) ) }}
@parent
{{ Form::close() }}
@stop

@section('sidebar')
@if (!empty($track->release))
<p>
	<img src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/artists/{{ $track->release->album->artist->artist_alias }}/albums/{{ $track->release->album->album_alias }}/{{ strtolower($track->release->release_catalog_num) }}/images/cover_front_medium.jpg" width="230" />
</p>

<ul>
	<li><a href="{{ route('release.show', array( 'id' => $track->release->release_id )) }}/">Back to <em>{{ $track->release->album->album_title }}</em> @if (!empty($track->release->release_catalog_num)) ({{ $track->release->release_catalog_num }}) @else (TBD) @endif </a></li>
</ul>
@endif
@stop