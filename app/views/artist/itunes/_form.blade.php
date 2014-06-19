@extends('layout')

@section('content')

<div class="form-group">
	{{ Form::label( 'artist_last_name', 'Last name:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'artist_last_name', $artist->artist_last_name, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'artist_first_name', 'First name:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'artist_first_name', $artist->artist_first_name, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'artist_display_name', 'Display name:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'artist_display_name', $artist->artist_display_name, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'artist_file_system', 'File system alias:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'artist_file_system', $artist->artist_file_system, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'artist_biography', 'Biography:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::textarea( 'artist_biography', $artist->artist_biography, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'artist_biography_more', 'Biography (more):', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::textarea( 'artist_biography_more', $artist->artist_biography_more, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<h4>Settings</h4>

<div class="form-group">
	{{ Form::label( 'itunes_id', 'iTunes ID:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'itunes_id', $itunes_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
	</div>
</div>

@stop