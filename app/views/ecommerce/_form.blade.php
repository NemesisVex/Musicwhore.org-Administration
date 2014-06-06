@extends('layout')

@section('content')

<div class="form-group">
	{{ Form::label( 'ecommerce_release_id', 'Release:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'ecommerce_release_id', $releases, $ecommerce->ecommerce_release_id, array( 'class' => 'form-control', 'id' => 'ecommerce_release_id' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'ecommerce_label', 'Label:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'ecommerce_label', $ecommerce->ecommerce_label, array( 'class' => 'form-control', 'id' => 'ecommerce_label' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'ecommerce_url', 'URL:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'ecommerce_url', $ecommerce->ecommerce_url, array( 'class' => 'form-control', 'id' => 'ecommerce_url' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'ecommerce_list_order', 'Order:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'ecommerce_list_order', $ecommerce->ecommerce_list_order, array( 'class' => 'form-control', 'id' => 'ecommerce_url' ) ) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit('Save', array( 'class' => 'button' )) }}
	</div>
</div>

<script type="text/javascript">
	(function ($) {
		var labels = {{ $labels }}

		$('#ecommerce_release_id').chosen();
		$('#ecommerce_label').autocomplete({
			source: labels
		});

	})(jQuery);
</script>

@stop