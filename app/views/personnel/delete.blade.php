@extends('layout')

@section('page_title')
 &raquo; {{ $member->artist->artist_display_name }}
 &raquo; {{ $member->member_display_name }}
 &raquo; Delete
@stop

@section('section_header')
<h2>{{ $member->artist->member_display_name }}</h2>
@stop

@section('section_label')
<h3>
	Delete
	<small>{{ $member->member_display_name }}</small>
</h3>
@stop

@section('content')

<p>
	You are about to delete <strong>{{ $member->member_display_name }}</strong> from the database. Deleting an artist also removes all albums, releases and tracks related to this artist.
</p>

<p>
	Are you sure you want to do this?
</p>

{{ Form::model( $member, array( 'route' => array('personnel.destroy', $member->member_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) }}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '1') }} Yes, I want to delete {{ $member->member_display_name }}.
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '0') }} No, I don't want to delete {{ $member->member_display_name }}.
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
