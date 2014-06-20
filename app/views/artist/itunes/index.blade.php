@extends('layout')

@section('page_title')
 &raquo; Artists
@if (!empty($artist))
 &raquo; {{ $artist->artist_display_name }}
@endif
 &raquo; iTunes Import
@stop

@section('section_header')
<h2>
	@if (!empty($artist))
	{{ $artist->artist_display_name }}
	@else
	Artists
	@endif
</h2>
@stop

@section('section_label')
<h3>iTunes Import</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::open( array( 'route' => 'artist-itunes.search', 'class' => 'form-horizontal' ) ) }}
	<div class="form-group">
		{{ Form::label( 'q_artist', 'Artist', array( 'class' => 'col-md-2' ) ) }}
		<div class="col-md-10">
			{{ Form::text( 'q_artist', $q_artist, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label( 'locale', 'Locale', array( 'class' => 'col-md-2' ) ) }}
		<div class="col-md-10">
			{{ Form::select( 'locale', Config::get( 'itunes.locales' ), $locale, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			{{ Form::submit( 'Search', array( 'class' => 'btn btn-default' ) ) }}
		</div>
	</div>
	{{ Form::close() }}

	@if ( count( $artists ) > 0 )

	@if ( !empty($artist->artist_id) )
	{{ Form::open( array( 'route' => array('artist-setting.update', $artist->artist_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
	@else
	{{ Form::open( array( 'route' => 'artist-itunes.create', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'get' ) ) }}

	{{ Form::submit( 'Import', array( 'class' => 'btn btn-default' ) ) }}
	@endif

	@foreach ($artists->results as $itunes_artist)
	<div class="form-group">
		<div class="col-sm-12">
			<div class="radio">
				<label class="mb-result" title="{{ $itunes_artist->artistId }}" data-toggle="tooptip" data-placement="above">
					{{ Form::radio( 'itunes_id', $itunes_artist->artistId ) }}
					<a href="{{ $itunes_artist->artistLinkUrl }}">
						{{ $itunes_artist->artistName }}
					</a>
				</label>
			</div>
		</div>
	</div>
	@endforeach

	{{ Form::submit( !empty($artist->artist_id) ? 'Save' : 'Import', array( 'class' => 'btn btn-default' ) ) }}

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
