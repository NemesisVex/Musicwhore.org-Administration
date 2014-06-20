@extends('layout')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
@if (!empty($album->album_title))
 &raquo; {{ $artist->album_title }}
@endif
 $raquo; Musicbrainz
@stop

@section('section_header')
<h2>
	{{ $artist->artist_display_name }}
	@if (!empty($album->album_title))
	<small>{{ $artist->album_title }}</small>
	@endif
</h2>
@stop

@section('section_label')
<h3>Musicbrainz</h3>
@stop

@section('content')

@if (!empty($album->album_id))
{{ Form::open( array( 'route' => array('album-setting.update', $album->album_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
@else
{{ Form::open( array( 'route' => 'album-musicbrainz.create', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'get' ) ) }}

{{ Form::submit( 'Import', array( 'class' => 'btn btn-default' ) ) }}
@endif

{{ Form::hidden( 'album_artist_id', $artist->artist_id ) }}

@foreach ($brainz_artist->{'release-groups'} as $release_group)
<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label class="mb-result" title="{{ $release_group['id'] }}" data-toggle="tooptip" data-placement="above">
				{{ Form::radio( 'musicbrainz_gid', $release_group['id'] ) }}
				<a href="http://musicbrainz.org/release-group/{{ $release_group['id'] }}">{{ $release_group['title'] }}</a>
			</label>
		</div>
	</div>
</div>
@endforeach

{{ Form::submit( (!empty( $album->album_id )) ? 'Save' : 'Import', array( 'class' => 'btn btn-default' ) ) }}

{{ Form::close() }}
<script type="text/javascript">
	(function ($) {
		$(function () {
			$('.mb-result').tooltip();
		});
	})(jQuery);
</script>
@stop