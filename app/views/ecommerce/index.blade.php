@extends('layout')

@section('page_title')
@stop

@section('section_header')
@stop

@section('section_label')
@stop

@section('content')
<p>
	@if (!empty($release->release_id))
	<a href="{{ route('ecommerce.create', array( 'release' => $release->release_id ) ) }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add ecommerce link</a>
	@elseif (!empty($track->track_id))
	<a href="{{ route('ecommerce.create', array( 'track' => $track->track_id ) ) }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add ecommerce link</a>
	@else
	<a href="{{ route('ecommerce.create') }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add ecommerce link</a>
	@endif
</p>

<ul class="two-column-bubble-list">
	@foreach ($ecommerce as $ecommerce_link)
	<li>
		<div>
			<a href="{{ route( 'ecommerce.edit', array( 'id' => $ecommerce_link->ecommerce_id ) ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route( 'ecommerce.delete', array( 'id' => $ecommerce_link->ecommerce_id ) ) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<a href="{{ route( 'ecommerce.show', array( 'id' => $ecommerce_link->ecommerce_id ) ) }}">{{ $ecommerce_link->ecommerce_label }}</a>
			@if (!empty($ecommerce_link->release->album->album_title))
			({{ $ecommerce_link->release->album->album_title }})
			@elseif (!empty($ecommerce_link->track->song->song_title))
			({{ $ecommerce_link->track->song->song_title }})
			@endif
		</div>
	</li>
	@endforeach
</ul>

@stop
