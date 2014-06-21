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
	{{ Form::label( 'release_ean_num', 'UPC/EAN:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_ean_num', $release->release_ean_num, array( 'class' => 'form-control' ) ) }}
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
	{{ Form::label( 'release_country_name', 'Country:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'release_country_name', $countries, $release->release_country_name, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'release_image', 'Image:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'release_image', $release->release_image, array( 'class' => 'form-control' ) ) }}
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
			$('#release_country_name').chosen();

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
