@extends('layout')

@section('page_title')
@if (!empty($album))
 &raquo; {{ $album->artist->artist_display_name }}
 &raquo; {{ $album->album_title }}
@endif
 &raquo; Musicbrainz lookup
@stop

@section('section_header')
<hgroup>
	<h2>
		@if (!empty($album))
		{{ $album->artist->artist_display_name }}
		<small>{{ $album->album_title }}</small>
		@endif
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Musicbrainz lookup</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::open( array( 'route' => 'album.musicbrainz.search', 'class' => 'form-horizontal' ) ) }}
	<div class="form-group">
		<div class="col-md-10">
			{{ Form::text( 'q_master_release', $q_master_release, array( 'class' => 'form-control' ) ) }}
		</div>
		<div class="col-md-2">
			{{ Form::submit( 'Search', array( 'class' => 'btn btn-default' ) ) }}
			{{ Form::hidden( 'arid', $album->artist->meta->musicbrainz_gid ) }}
			{{ Form::hidden( 'artist', $album->artist->artist_display_name ) }}
			{{ Form::hidden( 'id', $album->album_id ) }}
		</div>
	</div>
	{{ Form::close() }}

	@if (count($release_groups) > 0)
	{{ Form::model( $album, array( 'route' => array('album-setting.update', $album->album_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}

	@foreach ($release_groups as $release_group)
	<div class="form-group">
		<div class="col-sm-12">
			<div class="radio">
				<label class="mb-result" title="{{ $release_group->id }}" data-toggle="tooptip" data-placement="above">
					{{ Form::radio( 'musicbrainz_gid', $release_group->getId() ) }}
					<a href="http://musicbrainz.org/release-group/{{ $release_group->getId() }}">{{ $release_group->getTitle() }}</a>
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
