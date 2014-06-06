@extends('layout')

@section('content')

<div class="form-group">
	{{ Form::label( 'release_album_id', 'Album:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'release_album_id', $albums, $release->release_album_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_alternate_title', 'Alternate title:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_alternate_title', $release->release_alternate_title, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_alias', 'Alias:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_alias', $release->release_alias, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_label', 'Label:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_label', $release->release_label, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_release_date', 'Release date:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_release_date', date('Y-m-d', strtotime($release->release_release_date) ), array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_upc_num', 'UPC:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_upc_num', $release->release_upc_num, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_catalog_num', 'Catalog no.:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_catalog_num', $release->release_catalog_num, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_format_id', 'Format:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'release_format_id', $formats, $release->release_format_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_image', 'Image:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_image', $release->release_image, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_is_visible', 'Visibility:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		<div class="radio">
			<label>
				{{ Form::radio( 'release_is_visible', 1, ($release->release_is_visible == 1) ) }} Show
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'release_is_visible', 0, ($release->release_is_visible == 0) ) }} Hide
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit('Save', array( 'class' => 'button' )) }}
	</div>
</div>

<script type="text/javascript">
	(function ($) {
		$(function () {
			$('#release_album_id').chosen();
			$('#release_format_id').chosen();

			// Date pickers.
			$('#release_release_date').datepicker({
				dateFormat: 'yy-mm-dd'
			});

			$('#release_album_id').change(function () {
				var alias = $('#release_album_id>option:selected').text().trim().toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
				if (alias != '') {alias += '-digital';}
				$('#release_alias').val(alias);
			});
		});
	})(jQuery);
</script>

@stop
