@extends('layout')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Musicbrainz</h3>
@stop

@section('content')
<ul class="list-unstyled">
	<li class="row">
		<label class="col-md-3">Name:</label>
		<div class="col-md-9">
			{{ $brainz_artist->name }}
		</div>
	</li>
	<li class="row">
		<label class="col-md-3">Sort name:</label>
		<div class="col-md-9">
			{{ $brainz_artist->{'sort-name'} }}
		</div>
	</li>
	<li class="row">
		<label class="col-md-3">Country:</label>
		<div class="col-md-9">
			{{ $brainz_artist->country }}
		</div>
	</li>
</ul>
@stop