@extends('layout')

@section('content')

@if (!empty($artists))
<div class="form-group">
	{{ Form::label( 'album_artist_id', 'Artist:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'album_artist_id', $artists, $album->album_artist_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>
@else
{{ Form::hidden( 'album_artist_id' , $album->album_artist_id) }}
@endif

<div class="form-group">
	{{ Form::label( 'album_format_id', 'Format:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'album_format_id', $formats, $album->album_format_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_title', 'Title:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_title', $album->album_title, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_alt_title', 'Alternate title:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_alt_title', $album->album_alt_title, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_sort_title', 'Sort title:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_sort_title', $album->album_sort_title, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_label', 'Label:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_label', $album->album_label, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_release_date', 'Release date:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_release_date', date('Y-m-d', strtotime($album->album_release_date)), array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_image', 'Image:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_image', $album->album_image, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
	</div>
</div>

<script type="text/javascript">
	(function ($) {
		$(function () {
			$('#album_format_id').chosen();
			$('#album_artist_id').chosen();

			// Date pickers.
			$('#album_release_date').datepicker({
				dateFormat: 'yy-mm-dd'
			});
		});
	})(jQuery);
</script>

@stop