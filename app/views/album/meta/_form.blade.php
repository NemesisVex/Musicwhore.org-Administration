@extends('layout')

@section('content')
<h4>External services</h4>

<div class="form-group">
	{{ Form::label( 'musicbrainz_gid', 'Musicbrainz GID', array( 'class' => 'col-md-3', 'id' => 'musicbrainz-gid-label', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Map to Release Group' ) ) }}
	<div class="col-md-7">
		{{ Form::text( 'musicbrainz_gid', $album->meta->musicbrainz_gid, array( 'class' => 'form-control' ) ) }}
	</div>
	<div class="col-sm-2">
		<a href="{{ route( 'album-setting.musicbrainz.lookup', array( 'album' => $album->album_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'discogs_master_release_id', 'Discogs ID', array( 'class' => 'col-md-3', 'id' => 'discogs-master-release-id-label', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Map to Master Release' ) ) }}
	<div class="col-md-7">
		{{ Form::text( 'discogs_master_release_id', $album->meta->discogs_master_release_id, array( 'class' => 'form-control', 'data-toggle' => 'tooltip', 'title' => 'map to Master Release' ) ) }}
	</div>
	<div class="col-sm-2">
		<a href="{{ route( 'album-setting.discogs.lookup', array( 'album' => $album->album_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
	</div>
</div>

<h4>Classical</h4>

@if ($album->artist->meta->is_classical_artist == true)
<div class="form-group">
	{{ Form::label( 'ensemble_id', 'Ensemble', array( 'class' => 'col-md-3' ) ) }}
	<div class="col-md-9">
		{{ Form::select( 'ensemble_id', $artists, $album->meta->ensemble_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'soloist_id', 'Soloist', array( 'class' => 'col-md-3' ) ) }}
	<div class="col-md-9">
		{{ Form::select( 'soloist_id', $artists, $album->meta->soloist_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'conductor_id', 'Conductor', array( 'class' => 'col-md-3' ) ) }}
	<div class="col-md-9">
		{{ Form::select( 'conductor_id', $artists, $album->meta->conductor_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>
@else
<p>
	Enable {{ $album->artist->artist_display_name }} as a <a href="{{ route( 'artist-setting.edit', array( 'id' => $album->artist->artist_id ) ) }}">classical artist</a> to set classical settings on this album.
</p>
@endif

<div class="form-group">
	<div class="col-md-offset-3 col-md-9">
		{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
	</div>
</div>

<script type="text/javascript">
	(function ($) {
		$(function () {
			$('#ensemble_id').chosen();
			$('#soloist_id').chosen();
			$('#conductor_id').chosen();

			$('#musicbrainz-gid-label').tooltip();
			$('#discogs-master-release-id-label').tooltip();
		});
	})(jQuery);
</script>

@stop