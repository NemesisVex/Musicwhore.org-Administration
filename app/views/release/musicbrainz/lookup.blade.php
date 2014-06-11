@extends('layout')

@section('page_title')
@if (!empty($release))
 &raquo; {{ $release->album->artist->artist_display_name }}
 &raquo; {{ $release->album->album_title }}
@endif
 &raquo; Musicbrainz lookup
@stop

@section('section_header')
<hgroup>
	<h2>
		@if (!empty($release))
		{{ $release->album->artist->artist_display_name }}
		<small>{{ $release->album->album_title }}</small>
		@endif
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Musicbrainz lookup</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::open( array( 'route' => 'release.musicbrainz.search', 'class' => 'form-horizontal' ) ) }}
	<div class="form-group">
		<div class="col-md-10">
			{{ Form::text( 'q_release', $q_release, array( 'class' => 'form-control' ) ) }}
		</div>
		<div class="col-md-2">
			{{ Form::submit( 'Search', array( 'class' => 'btn btn-default' ) ) }}
			{{ Form::hidden( 'rgid', $release->album->meta->musicbrainz_gid ) }}
			{{ Form::hidden( 'release', $release->album->album_title ) }}
			{{ Form::hidden( 'id', $release->release_id ) }}
		</div>
	</div>
	{{ Form::close() }}

	@if (count($releases) > 0)
	{{ Form::model( $release, array( 'route' => array('release-setting.update', $release->release_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}

	@foreach ($releases as $release)
	<div class="form-group">
		<div class="col-sm-12">
			<div class="radio">
				<label class="mb-result" title="{{ $release->id }}" data-toggle="tooptip" data-placement="above">
					{{ Form::radio( 'musicbrainz_gid', $release->getId() ) }}
					<a href="http://musicbrainz.org/release/{{ $release->getId() }}">{{ $release->barcode }}</a>
				</label>
			</div>
		</div>
	</div>
	@endforeach

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}

	{{ Form::close() }}
	<script type="text/javascript">
		(function ($) {
			$(function () {
				$('.mb-result').tooltip();
			});
		})(jQuery);
	</script>

	@else
	<p>
		No release groups were found for this album.
	</p>
	@endif


</div>
@stop
