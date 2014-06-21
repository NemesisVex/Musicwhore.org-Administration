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
<h3>Discogs lookup</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::open( array( 'route' => 'album-setting.discogs.search', 'class' => 'form-horizontal' ) ) }}
	<div class="form-group">
		{{ Form::label( 'q_master_release', 'Title', array( 'class' => 'col-md-3' ) ) }}
		<div class="col-md-9">
			{{ Form::text( 'q_master_release', $q_master_release, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label( 'artist', 'Artist', array( 'class' => 'col-md-3' ) ) }}
		<div class="col-md-9">
			{{ Form::text( 'artist', $artist, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-3 col-md-9">
			{{ Form::submit( 'Search', array( 'class' => 'btn btn-default' ) ) }}
			{{ Form::hidden( 'id', $album->album_id ) }}
		</div>
	</div>
	{{ Form::close() }}

	@if (count($master_releases) > 0)
	{{ Form::model( $album, array( 'route' => array('album-setting.update', $album->album_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}

	@foreach ($master_releases as $master_release)
	<div class="form-group">
		<div class="col-sm-12">
			<div class="radio">
				<label class="discogs-result" title="{{ $master_release->getId() }}" data-toggle="tooptip" data-placement="top">
					{{ Form::radio( 'discogs_master_release_id', $master_release->getId(), $album->meta->discogs_master_release_id != null && ( $album->meta->discogs_master_release_id == $master_release->getId() ) ) }}
					<a href="http://discogs.com/master/{{ $master_release->getId() }}">{{ $master_release->getTitle() }}</a>
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
				$('.discogs-result').tooltip();
			});
		})(jQuery);
	</script>

	@else
	<p>
		No master releases were found for this album.
	</p>
	@endif


</div>
@stop
