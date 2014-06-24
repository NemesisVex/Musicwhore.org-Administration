@extends('layout')

@section('page_title')
 &raquo; {{ $album->artist->artist_display_name }}
 &raquo; {{ $album->album_title }}
 &raquo; Discogs Import
@stop

@section('section_header')
<h2>
	{{ $album->artist->artist_display_name }}
	<small>{{ $album->album_title }}</small>
</h2>
@stop

@section('section_label')
<h3>Musicbrainz</h3>
@stop

@section('content')
<pre>
	{{ print_r($discogs_master_release) }}
</pre>
@stop