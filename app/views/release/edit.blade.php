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
<div class="col-md-12">
	{{ Form::model( $release, array( 'route' => array('release.update', $release->release_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
	@parent
	{{ Form::close() }}
</div>
@stop
