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
		{{ Form::label( 'track_song_id', 'Song:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::select( 'track_song_id', $songs, $track->track_song_id, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_alias', 'Alias:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::text( 'track_alias', $track->track_alias, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_is_visible', 'Visibility:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			<div class="radio">
				<label>
					{{ Form::radio( 'track_is_visible', 1, ($track->track_is_visible == 1) ) }} Show
				</label>
			</div>
			<div class="radio">
				<label>
					{{ Form::radio( 'track_is_visible', 0, ($track->track_is_visible == 0) ) }} Hide
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_audio_is_linked', 'Playable:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			<div class="radio">
				<label>
					{{ Form::radio( 'track_audio_is_linked', 1, ($track->track_audio_is_linked == 1) ) }} Yes
				</label>
			</div>
			<div class="radio">
				<label>
					{{ Form::radio( 'track_audio_is_linked', 0, ($track->track_audio_is_linked == 0) ) }} No
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_audio_is_downloadable', 'Downloadable:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			<div class="radio">
				<label>
					{{ Form::radio( 'track_audio_is_downloadable', 1, ($track->track_audio_is_downloadable == 1) ) }} Yes
				</label>
			</div>
			<div class="radio">
				<label>
					{{ Form::radio( 'track_audio_is_downloadable', 0, ($track->track_audio_is_downloadable == 0) ) }} No
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_uplaya_score', 'uPlaya score:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::text( 'track_uplaya_score', $track->track_uplaya_score, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'track_recording_id', 'Recording:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::select( 'track_recording_id', $recordings, $track->track_recording_id, array( 'class' => 'form-control' ) ) }}
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
		$('#track_song_id').chosen();
		$('#track_recording_id').chosen();
		$('#track_release_id').chosen();

		// Date pickers.
//		$('#release_release_date').datepicker({
//			dateFormat: 'yy-mm-dd'
//		});

		$('#track_song_id').change(function () {
			var alias = $('#track_song_id>option:selected').text().trim().toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
			$('#track_alias').val(alias);
		});
	})(jQuery);
</script>

@stop