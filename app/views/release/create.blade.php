@extends('release._form')

@section('page_title')
@if (!empty($release->album))
 &raquo; {{ $release->album->artist->artist_display_name }}
 &raquo; {{ $release->album->album_title }}
@endif
 &raquo; Add a release
@stop

@section('section_header')
<hgroup>
	<h2>
		@if (!empty($release->album))
		{{ $release->album->artist->artist_display_name }}
		<small>{{ $release->album->album_title }}</small>
		@else
		Observant Records
		@endif
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Add a release</h3>
@stop

@section('content')
{{ Form::model( $release, array( 'route' => 'release.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post' ) ) }}
@parent
{{ Form::close() }}
@stop


@section('sidebar')
@if (!empty($release->release_album_id))
<ul>
	<li><a href="{{ route('album.show', array( 'id' => $release->release_album_id )) }}/">Back to <em>{{ $release->album->album_title }}</em></a></li>
</ul>
@endif
@stop