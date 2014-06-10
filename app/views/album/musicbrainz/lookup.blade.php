@extends('layout')

@section('page_title')
 &raquo; {{ $album->artist->artist_display_name }}
 &raquo; {{ $album->album_title }}
 &raquo; Musicbrainz lookup
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $album->artist->artist_display_name }}
		<small>{{ $album->album_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Musicbrainz lookup</h3>
@stop

@section('content')
<div class="col-md-12">

	@if (count($release_groups) > 0)
	{{ Form::model( $album, array( 'route' => array('album-setting.update', $album->album_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}

	@foreach ($release_groups as $release_group)
	<div class="form-group">
		<div class="col-sm-12">
			<div class="radio">
				<label class="mb-result" title="{{ $release_group->id }}" data-toggle="tooptip" data-placement="above">
					{{ Form::radio( 'musicbrainz_gid', $release_group->getId() ) }} {{ $release_group->getTitle() }}
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
