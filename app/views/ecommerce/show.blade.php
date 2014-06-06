@extends('layout')

@section('page_title')
@stop

@section('section_header')
@stop

@section('section_label')
@stop

@section('content')

<p>
	<a href="{{ route('ecommerce.edit', array('id' => $ecommerce->ecommerce_id)) }}" class="button"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
	<a href="{{ route('ecommerce.delete', array('id' => $ecommerce->ecommerce_id)) }}" class="button"><span class="glyphicon glyphicon-remove"></span> Delete</a>
</p>

<ul class="two-column-bubble-list">
	<li>
		<div>
			<label>Label</label> {{ $ecommerce->ecommerce_label }}
		</div>
	</li>
	<li>
		<div>
			<label>URL</label> <a href="{{ $ecommerce->ecommerce_url }}" title="[{{ $ecommerce->ecommerce_url }}]">{{ $ecommerce->ecommerce_url }}</a>
		</div>
	</li>
	<li>
		<div>
			<label>Order</label> {{ $ecommerce->ecommerce_list_order }}
		</div>
	</li>
</ul>

@stop

@section('sidebar')
<p>
	<img src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/artists/{{ $ecommerce->release->album->artist->artist_alias }}/albums/{{ $ecommerce->release->album->album_alias }}/{{ strtolower($ecommerce->release->release_catalog_num) }}/images/cover_front_medium.jpg" width="230" />
</p>

<ul>
	<li><a href="{{ route('release.show', array( 'id' => $ecommerce->ecommerce_release_id )) }}/">Back to <em>{{ $ecommerce->release->album->album_title }}</em> @if (!empty($ecommerce->release->release_catalog_num)) ({{ $ecommerce->release->release_catalog_num }}) @endif</a></li>
</ul>
@stop