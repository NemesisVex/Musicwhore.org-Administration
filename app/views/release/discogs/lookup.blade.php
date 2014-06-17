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
<h3>Discogs lookup</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::open( array( 'route' => 'release.discogs.search', 'class' => 'form-horizontal' ) ) }}
	<div class="form-group">
		{{ Form::label( 'q_release', 'Title', array( 'class' => 'col-md-3' ) ) }}
		<div class="col-md-9">
			{{ Form::text( 'q_release', $q_release, array( 'class' => 'form-control' ) ) }}
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
			{{ Form::hidden( 'id', $release->release_id ) }}
		</div>
	</div>
	{{ Form::close() }}

	@if (count($releases) > 0)
	{{ Form::model( $release, array( 'route' => array('release-setting.update', $release->release_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}

	@foreach ($releases as $discog_release)
	<div class="form-group">
		<div class="col-sm-4">
			<div class="radio">
				<label class="discogs-result" title="{{ $discog_release->getId() }}" data-toggle="tooptip" data-placement="top">
					{{ Form::radio( 'discogs_release_id', $discog_release->getId(), ($discog_release->getID() == $release->meta->discogs_release_id) ) }}
					<a href="http://discogs.com{{ $discog_release->getUri() }}">{{ $discog_release->getTitle() }}</a>
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			{{ $discog_release->getCatNo() }}
		</div>
		<div class="col-sm-6">
			{{ $discog_release->getCountry() }}
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
