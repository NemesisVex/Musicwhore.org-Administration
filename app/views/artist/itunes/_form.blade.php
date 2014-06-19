@extends('artist._form')

@section('content')

@parent

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