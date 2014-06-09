@extends('layout')

@section('content')

<div class="form-group">

	<div class="form-group">
		{{ Form::label( 'itunes_id', 'iTunes ID:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::text( 'itunes_id', $track->meta->itunes_id, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			{{ Form::submit('Save', array( 'class' => 'button' )) }}
		</div>
	</div>
</div>

<script type="text/javascript">
	(function ($) {
	})(jQuery);
</script>

@stop