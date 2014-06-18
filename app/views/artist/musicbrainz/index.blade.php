@extends('layout')

@section('page_title')
 &raquo; Artists &raquo; Musicbrainz Import
@stop

@section('section_header')
<h2>Artists</h2>
@stop

@section('section_label')
<h3>Musicbrainz Import</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::open( array( 'route' => 'artist-musicbrainz.search', 'class' => 'form-horizontal' ) ) }}
	<div class="form-group">
		<div class="col-md-10">
			{{ Form::text( 'q_artist', $q_artist, array( 'class' => 'form-control' ) ) }}
		</div>
		<div class="col-md-2">
			{{ Form::submit( 'Search', array( 'class' => 'btn btn-default' ) ) }}
		</div>
	</div>
	{{ Form::close() }}

	@if ( count( $artists ) > 0 )
	{{ Form::open( array( 'route' => 'artist-musicbrainz.create', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'get' ) ) }}

	{{ Form::submit( 'Import', array( 'class' => 'btn btn-default' ) ) }}

	@foreach ($artists as $brainz_artist)
	<div class="form-group">
		<div class="col-sm-12">
			<div class="radio">
				<label class="mb-result" title="{{ $brainz_artist->id }}" data-toggle="tooptip" data-placement="above">
					{{ Form::radio( 'musicbrainz_gid', $brainz_artist->getId() ) }}
					<a href="http://musicbrainz.org/artist/{{ $brainz_artist->getId() }}">
						{{ $brainz_artist->getName() }}
					</a>
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

	@endif
</div>

@stop
