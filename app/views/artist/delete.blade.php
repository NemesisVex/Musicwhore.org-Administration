@extends('layout')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
 &raquo; Delete
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Delete</h3>
@stop

@section('content')

<p>
	You are about to delete <strong>{{ $artist->artist_display_name }}</strong> from the database. Deleting an artist also removes all albums, releases and tracks related to this artist.
</p>

<p>
	Are you sure you want to do this?
</p>

{{ Form::model( $artist, array( 'route' => array('artist.destroy', $artist->artist_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) }}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '1') }} Yes, I want to delete {{ $artist->artist_display_name }}.
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '0') }} No, I don't want to delete {{ $artist->artist_display_name }}.
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
