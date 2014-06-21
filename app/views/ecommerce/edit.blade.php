@extends('ecommerce._form')

@section('page_title')
@if (!empty($ecommerce->release->album->artist->artist_display_name))
&raquo; {{ $ecommerce->release->album->artist->artist_display_name }}
&raquo; {{ $ecommerce->release->release_catalog_num }}
@endif
&raquo; {{ $ecommerce->ecommerce_label }}
&raquo; Delete
@stop

@section('section_header')
<h2>
	@if (!empty($ecommerce->release->album->artist->artist_display_name))
	{{ $ecommerce->release->album->artist->artist_display_name }}
	<small>
		{{ $ecommerce->release->release_catalog_num }}
	</small>
	@else
	Observant Records
	@endif
</h2>
@stop

@section('section_label')
<h3>
	Edit
	<small>{{$ecommerce->ecommerce_label }}</small>
</h3>
@stop

@section('content')
{{ Form::model( $ecommerce, array( 'route' => array('ecommerce.update', $ecommerce->ecommerce_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
{{ Form::close() }}
@stop

@section('sidebar')
<p>
	<img src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/artists/{{ $ecommerce->release->album->artist->artist_alias }}/albums/{{ $ecommerce->release->album->album_alias }}/{{ strtolower($ecommerce->release->release_catalog_num) }}/images/cover_front_medium.jpg" width="230" />
</p>

<ul>
	<li><a href="{{ route('release.show', array( 'id' => $ecommerce->ecommerce_release_id )) }}/">Back to <em>{{ $ecommerce->release->album->album_title }}</em> @if (!empty($ecommerce->release->release_catalog_num)) ({{ $ecommerce->release->release_catalog_num }}) @endif</a></li>
</ul>
@stop