@extends('album._form')

@section('content')
@parent

<h4>Settings</h4>

<div class="form-group">
	{{ Form::label( 'discogs_master_release_id', 'Discogs ID:', array( 'class' => 'control-label col-md-2' ) ) }}
	<div class="col-md-10">
		{{ Form::text( 'discogs_master_release_id', $discogs_master_release_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	<div class="col-md-offset-2 col-md-10">
		{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
	</div>
</div>

@stop