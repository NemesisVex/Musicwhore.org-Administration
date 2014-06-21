@extends('layout')

@section('page_title')
@if (!empty($release))
&raquo; {{ $release->album->artist->artist_display_name }}
&raquo; {{ $release->album->album_title }}
@endif
&raquo; iTunes lookup
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
<h3>iTunes lookup</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::open( array( 'route' => 'release-setting.itunes.search', 'class' => 'form-horizontal' ) ) }}
	<div class="form-group">
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
			{{ Form::label( 'locale', 'Locale', array( 'class' => 'col-md-3' ) ) }}
			<div class="col-md-9">
				{{ Form::select( 'locale', $locales, $locale, array( 'class' => 'form-control' ) ) }}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-3 col-md-9">
				{{ Form::submit( 'Search', array( 'class' => 'btn btn-default' ) ) }}
				{{ Form::hidden( 'id', $release->release_id ) }}
			</div>
		</div>
	</div>
	{{ Form::close() }}

	{{ Form::model( $release, array( 'route' => array('release-setting.update', $release->release_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}

	@if (count($releases) > 0)
	@foreach ($releases->results as $itunes_release)
	<div class="form-group">
		<div class="col-sm-2">
			<div class="radio">
				<label class="mb-result" title="{{ $itunes_release->collectionId }}" data-toggle="tooptip" data-placement="above">
					{{ Form::radio( 'itunes_collection_id', $itunes_release->collectionId, ($itunes_release->collectionId == $release->meta->itunes_collection_id) ) }}
					<a href="{{ $itunes_release->collectionViewUrl }}">
						@if (!empty($itunes_release->collectionId) )
						{{ $itunes_release->collectionId }}
						@else
						Not set
						@endif
					</a>
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			{{ $itunes_release->artistName}}
		</div>
		<div class="col-sm-8">
			{{ $itunes_release->collectionName}}
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
		No collections were found for this album.
	</p>
	@endif

</div>
@stop
