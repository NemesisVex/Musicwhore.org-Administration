@extends('layout')

@section('page_title')
 &raquo; {{ $track->release->album->artist->artist_display_name }}
 &raquo; {{ $track->release->album->album_title }}
@if (!empty($release->release_catalog_num)) &raquo; {{ $release->release_catalog_num }} @endif
 &raquo; {{ $track->song->song_title }}
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
	<small>{{ $track->song->song_title }}</small>
</h3>
@stop

@section('content')

<p>
	<a href="{{ route( 'track.edit', array( 'id' => $track->track_id ) ) }}" class="button">Edit</a>
	<a href="{{ route( 'track.delete', array( 'id' => $track->track_id ) ) }}" class="button">Delete</a>
</p>

<ul class="two-column-bubble-list">
	<li>
		<div>
			<label>Title</label> {{ $track->song->song_title }}
		</div>
	</li>
	<li>
		<div>
			<label>Disc no.</label> {{ $track->track_disc_num }}
		</div>
	</li>
	<li>
		<div>
			<label>Track no.</label> {{ $track->track_track_num }}
		</div>
	</li>
	@if (!empty($track->track_alias))
	<li>
		<div>
			<label>Alias</label> {{ $track->track_alias }}
		</div>
	</li>
	@endif
	<li>
		<div>
			<label>Visible?</label> <input type="checkbox" disabled="disabled" value="1" @if ($track->track_is_visible == true) checked @endif />
		</div>
	</li>
	<li>
		<div>
			<label>Playable?</label> <input type="checkbox" disabled="disabled" value="1"@if ($track->track_audio_is_linked == true) checked @endif />
		</div>
	</li>
	<li>
		<div>
			<label>Downloadable?</label> <input type="checkbox" disabled="disabled" value="1"@if ($track->track_audio_is_downloadable == true) checked @endif />
		</div>
	</li>
	<li>
		<div>
			<label>Recording</label>
			@if (!empty($track->track_recording_id))
			<a href=" {{ route('recording.show', array( 'id' => $track->track_recording_id ) ) }}/">
				@if (empty($track->recording->recording_isrc_num))
				(No ISRC number set) {{ $track->song->song_title }}
				@else
				{{ $track->recording->recording_isrc_num }}
				@endif
			</a>
			@else
			Not set.
			@endif
		</div>
	</li>
	@if ($track->track_uplaya_score)
	<li>
		<div>
			<label>uPlaya score</label> {{ $track->track_uplaya_score }}
		</div>
	</li>
	@endif
</ul>
@stop

@section('sidebar')
<p>
	<img src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/artists/{{ $track->release->album->artist->artist_alias }}/albums/{{ $track->release->album->album_alias }}/{{ strtolower($track->release->release_catalog_num) }}/images/cover_front_medium.jpg" width="230" />
</p>

<ul>
	<li><a href="{{ route('release.show', array( 'id' => $track->track_release_id )) }}/">Back to <em>{{ $track->release->album->album_title }}</em> @if (!empty($track->release->release_catalog_num)) ({{ $track->release->release_catalog_num }}) @endif</a></li>
</ul>

@stop