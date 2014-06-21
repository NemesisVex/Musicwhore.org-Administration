@extends('layout')

@section('page_title')
@if (!empty($release))
&raquo; {{ $release->album->artist->artist_display_name }}
&raquo; {{ $release->album->album_title }}
@endif
&raquo; Amazon lookup
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
<h3>Amazon lookup</h3>
@stop

@section('content')
<div class="col-md-12">
	{{ Form::open( array( 'route' => 'release-setting.amazon.search', 'class' => 'form-horizontal' ) ) }}
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

	@if (!empty($releases->Request->Errors))
	<p class="alert alert-danger">
		{{ $releases->Request->Errors->Error->Message }}
	</p>
	@else
	{{ Form::model( $release, array( 'route' => array('release-setting.update', $release->release_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}

	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}

	@if (count($releases) > 0)

	<table class="table">
		<thead>
		<tr>
			<th>ASIN</th>
			<th>Title</th>
			<th>EAN</th>
			<th>MPN</th>
		</tr>
		</thead>
		<tbody>
		@foreach ($releases->Item as $amazon_release)
		<tr>
			<td>
				<div class="radio">
					<label class="mb-result" title="{{ $amazon_release->ASIN }}" data-toggle="tooptip" data-placement="above">
						{{ Form::radio( 'asin_num', $amazon_release->ASIN, ($amazon_release->ASIN == $release->meta->asin_num) ) }}
						<a href="{{ $amazon_release->DetailPageURL }}">
							@if (!empty($amazon_release->ASIN) )
							{{ $amazon_release->ASIN }}
							@else
							Not set
							@endif
						</a>
					</label>
				</div>
			</td>
			<td>
				@if (!empty($amazon_release->ItemAttributes->Title))
				{{ $amazon_release->ItemAttributes->Title }}
				@endif
			</td>
			<td>
				@if (!empty($amazon_release->ItemAttributes->EAN))
				{{ $amazon_release->ItemAttributes->EAN }}
				@endif
			</td>
			<td>
				@if (!empty($amazon_release->ItemAttributes->MPN))
				{{ $amazon_release->ItemAttributes->MPN }}
				@endif
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>

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
		No releases were found for this album.
	</p>
	@endif
	@endif



</div>
@stop
