@extends('layout')

@section('content')
<div class="form-group">
	{{ Form::label( 'asin_num', 'Amazon ASIN', array( 'class' => 'col-md-3' ) ) }}
	<div class="col-md-7">
		{{ Form::text( 'asin_num', $release->meta->asin_num, array( 'class' => 'form-control' ) ) }}
	</div>
	<div class="col-sm-2">
		<a href="{{ route( 'release.amazon.lookup', array( 'album' => $release->release_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'musicbrainz_gid', 'Musicbrainz GID', array( 'class' => 'col-md-3', 'id' => 'musicbrainz-gid-label', 'title' => 'Map to Release', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom' ) ) }}
	<div class="col-md-7">
		{{ Form::text( 'musicbrainz_gid', $release->meta->musicbrainz_gid, array( 'class' => 'form-control' ) ) }}
	</div>
	<div class="col-sm-2">
		<a href="{{ route( 'release.musicbrainz.lookup', array( 'album' => $release->release_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'discogs_release_id', 'Discogs ID', array( 'class' => 'col-md-3', 'id' => 'discogs-id-label', 'title' => 'Map to Release', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom' ) ) }}
	<div class="col-md-7">
		{{ Form::text( 'discogs_release_id', $release->meta->discogs_release_id, array( 'class' => 'form-control' ) ) }}
	</div>
	<div class="col-sm-2">
		<a href="{{ route( 'release.discogs.lookup', array( 'album' => $release->release_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
	</div>
</div>

<div class="col-md-offset-3 col-md-9">
	{{ Form::submit('Save', array( 'class' => 'btn btn-default' ) ) }}
</div>

<script type="text/javascript">
	(function ($) {
		$(function () {
			$('#musicbrainz-gid-label').tooltip();
			$('#discogs-id-label').tooltip();
		});
	})(jQuery);
</script>

@stop