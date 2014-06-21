@extends('layout')

@section('content')

<div class="form-group">

	<div class="form-group">
		{{ Form::label( 'track_release_id', 'Release:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::select( 'track_release_id', $releases, $track->track_release_id, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_disc_num', 'Disc no.:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::text( 'track_disc_num', $track->track_disc_num, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_track_num', 'Track no.:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::text( 'track_track_num', $track->track_track_num, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_song_title', 'Title:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::text( 'track_song_title', $track->track_song_title, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_sort_title', 'Sort title:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::text( 'track_sort_title', $track->track_sort_title, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_alt_title', 'Alternate title:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::text( 'track_alt_title', $track->track_alt_title, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_va_artist_id', 'Track artist:', array( 'class' => 'col-sm-2', 'id' => 'track-va-artist-label', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'For various artists only' ) ) }}
		<div class="col-sm-10">
			{{ Form::select( 'track_va_artist_id', $artists, $track->track_va_artist_id, array( 'class' => 'form-control' ) ) }}
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
		$('#track-va-artist-label').tooltip();
		$('#track_release_id').chosen();
		$('#track_va_artist_id').chosen();
	})(jQuery);
</script>

@stop