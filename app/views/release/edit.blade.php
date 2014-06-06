@extends('release._form')

@section('page_title')
 &raquo; {{ $release->album->artist->artist_display_name }}
 &raquo; {{ $release->album->album_title }}
 &raquo; {{ $release->release_catalog_num }}
 &raquo; Edit
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
	Edit release
	@if (!empty($release->release_catalog_num))
	<small>{{ $release->release_catalog_num }}</small>
	@endif
</h3>
@stop

@section('content')
{{ Form::model( $release, array( 'route' => array('release.update', $release->release_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
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