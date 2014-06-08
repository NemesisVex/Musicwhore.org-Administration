@extends('layout')

@section('page_title')
 &raquo; Artists &raquo; Browse
@stop

@section('section_header')
<h2>Artists</h2>
@stop

@section('section_label')
<h3>Browse</h3>
@stop

@section('content')
<div class="col-md-12">
	<p>
		<a href="{{ route('artist.create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add an artist</a>
	</p>

	<ul class="list-inline">
		<li>Browse:</li>
		@foreach ($artist_list as $artist_letter)
		<li><a href="{{ route( 'artist.index', array( 'browse' => strtolower($artist_letter->nav) ) ) }}">{{ $artist_letter->nav }}</a></li>
		@endforeach
	</ul>

	@if (!empty($artists))

	<ul class="list-unstyled">
		@foreach ($artists as $artist)
		<li>
			<div>
				<ul class="list-inline">
					<li><a href="{{ route('artist.edit', array('id' => $artist->artist_id) ) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> <span class="sr-only">Edit</span></a></li>
					<li><a href="{{ route('artist.delete', array('id' => $artist->artist_id) ) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span> <span class="sr-only">Delete</span></a></li>
					<li><a href="{{ route('artist.show', array('id' => $artist->artist_id) ) }}" title="[View {{ $artist->artist_display_name }}]">{{ $artist->artist_display_name }}</a></li>
				</ul>
			</div>
		</li>
		@endforeach
	</ul>

	@else

	<p>
		No artists found.
	</p>

	@endif
</div>

@stop
