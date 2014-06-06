@extends('layout')

@section('page_title')
 &raquo; {{ $release->album->artist->artist_display_name }}
 &raquo; {{ $release->album->album_title }}
 @if (!empty($release->release_catalog_num)) &raquo; {{ $release->release_catalog_num }} @endif
 &raquo; Delete
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $release->album->artist->artist_display_name }}
		<small>{{ $release->album->album_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>
	Delete release
	@if (!empty($release->release_catalog_num))
	<small>{{ $release->release_catalog_num }}</small>
	@endif
</h3>
@stop

@section('content')

<p>
	You are about to delete a release @if (!empty($release->release_catalog_num)) <strong>{{ $release->release_catalog_num }}</strong> @endif from the album <em>{{ $release->album->album_title  }}</em>. Deleting a release will also remove all related tracks.
</p>

<p>
	Are you sure you want to do this?
</p>

{{ Form::model( $release, array( 'route' => array( 'release.destroy', $release->release_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) }}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '1') }} Yes, I want to delete this release.
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '0') }} No, I don't want to delete this release.
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

@section('sidebar')
<p>
	<img src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/artists/{{ $release->album->artist->artist_alias }}/albums/{{ $release->album->album_alias }}/{{ strtolower($release->release_catalog_num) }}/images/cover_front_medium.jpg" width="230" />
</p>

<ul>
	<li><a href="{{ route('release.show', array( 'id' => $release->release_id )) }}/">Back to <em>{{ $release->album->album_title }}</em> @if (!empty($release->release_catalog_num)) ({{ $release->release_catalog_num }}) @else (TBD) @endif </a></li>
</ul>

@stop