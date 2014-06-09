@extends('album.meta._form')

@section('page_title')
&raquo; {{ $album->artist->artist_display_name }}
&raquo; {{ $album->album_title }}
&raquo; Edit
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $album->artist->artist_display_name }}
		<small>{{ $album->album_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Edit album settings</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::model( $album, array( 'route' => array('album-setting.update', $album->album_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
	@parent
	{{ Form::close() }}
</div>
@stop
