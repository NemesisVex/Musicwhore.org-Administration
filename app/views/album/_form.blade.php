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
	{{ Form::label( 'album_title', 'Title:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_title', $album->album_title, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_alias', 'Alias:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_alias', $album->album_alias, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_release_date', 'Release date:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_release_date', date('Y-m-d', strtotime($album->album_release_date)), array( 'class' => 'form-control' ) ) }}
	</div>
</div>

@if (!empty($album->album_id))
<div class="form-group">
	{{ Form::label( 'album_primary_release_id', 'Primary release:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'album_primary_release_id', $releases, $album->album_primary_release_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>
@endif

<div class="form-group">
	{{ Form::label( 'album_ctype_locale', 'Primary release:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'album_ctype_locale', $locales, $album->album_ctype_locale, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_format_id', 'Format:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'album_format_id', $formats, $album->album_format_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_image', 'Image:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'album_image', $album->album_image, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_description', 'Description:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::textarea( 'album_description', $album->album_description, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'album_is_visible', 'Visibility:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		<div class="radio">
			<label>
				{{ Form::radio( 'album_is_visible', 1, ($album->album_is_visible == 1) ) }} Show
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'album_is_visible', 0, ($album->album_is_visible == 0) ) }} Hide
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit( 'Save', array( 'class' => 'button' ) ) }}
	</div>
</div>

<script type="text/javascript">
	(function ($) {
		$('#album_primary_release_id').chosen();
		$('#album_format_id').chosen();
		$('#album_artist_id').chosen();

		// Date pickers.
		$('#album_release_date').datepicker({
			dateFormat: 'yy-mm-dd'
		});

		$('#album_title').keyup(function () {
			var alias = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
			$('#album_alias').val(alias);
		});
	})(jQuery);
</script>

@stop