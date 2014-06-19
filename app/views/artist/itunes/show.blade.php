@extends('layout')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>iTunes</h3>
@stop

@section('content')
<ul class="list-inline">
	<li><a href="{{ route( 'artist-itunes.edit', array( 'id' => $itunes_id, 'artist' => $artist->artist_id ) )  }}" class="btn btn-default"><span class="glyphicon glyphicon-import"></span> Update</a></li>
</ul>

<ul class="list-unstyled">
	@foreach ($itunes_artists->results as $itunes_artist)
	<li class="row">
		<label class="col-md-3">Name:</label>
		<div class="col-md-9">
			{{ $itunes_artist->artistName }}
		</div>
	</li>
	@endforeach
</ul>
@stop