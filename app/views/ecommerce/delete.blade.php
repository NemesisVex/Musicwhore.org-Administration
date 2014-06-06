@extends('layout')

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
	Delete
	<small>{{$ecommerce->ecommerce_label }}</small>
</h3>
@stop

@section('content')

<p>
	You are about to delete <strong>{{ $ecommerce->ecommerce_label }}</strong> from the database.
</p>

<p>
	Are you sure you want to do this?
</p>

{{ Form::model( $ecommerce, array( 'route' => array('ecommerce.destroy', $ecommerce->ecommerce_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) }}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '1') }} Yes, I want to delete {{ $ecommerce->ecommerce_label }}.
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '0') }} No, I don't want to delete {{ $ecommerce->ecommerce_label }}.
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-12">
		{{ Form::submit('Confirm', array( 'class' => 'button' )) }}
	</div>
</div>

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