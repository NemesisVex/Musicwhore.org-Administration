@extends('layout')

@section('page_title')
 &raquo; {{ $album->artist->artist_display_name }}
@stop

@section('section_header')
<h2>{{ $album->artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Musicbrainz</h3>
@stop

@section('content')
<ul class="list-inline">
	<li><a href="{{ route( 'album-musicbrainz.edit', array( 'id' => $gid, 'album' => $album->album_id ) )  }}" class="btn btn-default"><span class="glyphicon glyphicon-import"></span> Update</a></li>
</ul>

<ul class="list-unstyled">
	<li class="row">
		<label class="col-md-3">Title:</label>
		<div class="col-md-9">
			{{ $brainz_album->title }}
		</div>
	</li>
	<li class="row">
		<label class="col-md-3">Release date:</label>
		<div class="col-md-9">
			{{ $brainz_album->{'first-release-date'} }}
		</div>
	</li>
</ul>
@stop