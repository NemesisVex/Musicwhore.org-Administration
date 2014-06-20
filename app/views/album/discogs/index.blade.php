@extends('layout')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
 &raquo; Albums
 &raquo; Musicbrainz Import
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>
	Albums
	<small>Musicbrainz Import</small>
</h3>
@stop

@section('content')
{{ Form::open( array( 'route' => 'album-discogs.create', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'get' ) ) }}

{{ Form::submit( 'Import', array( 'class' => 'btn btn-default' ) ) }}
{{ Form::hidden( 'album_artist_id', $artist->artist_id ) }}

@foreach ($discogs_albums as $discogs_album)
<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label class="mb-result" title="{{ $discogs_album->getId() }}" data-toggle="tooptip" data-placement="above">
				{{ Form::radio( 'discogs_album_id', $discogs_album->getId() ) }}
				<a href="http://discogs.com{{ $discogs_album->getUri(); }}">{{ $discogs_album->getTitle() }}</a>
			</label>
		</div>
	</div>
</div>
@endforeach

{{ Form::submit( 'Import', array( 'class' => 'btn btn-default' ) ) }}

{{ Form::close() }}

{{ $pagination->appends( 'artist', $artist->artist_id )->appends( 'discogs_artist_id', $discogs_artist_id )->links() }}

<script type="text/javascript">
	(function ($) {
		$(function () {
			$('.mb-result').tooltip();
		});
	})(jQuery);
</script>
@stop