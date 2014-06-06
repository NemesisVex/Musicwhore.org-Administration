@extends('layout')

@section('page_title')
 &raquo; Releases &raquo; Browse
@stop

@section('section_header')
<h2>Observant Records</h2>
@stop

@section('section_label')
<h3>
	Release
	<small>Browse</small>
</h3>
@stop

@section('content')

<p>
	<a href="{{ route('release.create') }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add a release</a>
</p>

@if (count($releases) > 0)
<ol class="track-list">
	@foreach ($releases as $release)
	<li>
		<div>
			<a href="{{ route( 'release.edit', array( 'id' => $release->release_id ) ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route( 'release.delete', array( 'id' => $release->release_id ) ) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<a href="{{ route( 'release.show', array( 'id' => $release->release_id ) ) }}">{{ $release->release_catalog_num }} ({{ $release->album->album_title}})</a>
		</div>
	</li>
	@endforeach
</ol>
@endif

@stop
