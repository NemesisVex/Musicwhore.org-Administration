@extends('layout')

@section('page_title')
 &raquo; {{ $album->artist->artist_display_name }}
 &raquo; {{ $album->album_title }}
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
<h3>Album info</h3>
@stop

@section('content')
<div class="col-md-12">
	<ul class="list-inline">
		<li><a href="{{ route('album.edit', array('id' => $album->album_id)) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
		<li><a href="{{ route('album.delete', array('id' => $album->album_id)) }}" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
	</ul>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Title</label>
			<div class="col-md-9">
				{{ $album->album_title }}
			</div>
		</li>
		@if (!empty($album->format->format_alias))
		<li class="row">
			<label class="col-md-3">Format</label>
			<div class="col-md-9">
				{{ $album->format->format_alias }}
			</div>
		</li>
		@endif
		@if (!empty($album->album_sort_title))
		<li class="row">
			<label class="col-md-3">Sort title</label>
			<div class="col-md-9">
				{{ $album->album_sort_title }}
			</div>
		</li>
		@endif
		@if (!empty($album->album_alt_title))
		<li class="row">
			<label class="col-md-3">Alternate title</label>
			<div class="col-md-9">
				{{ $album->album_alt_title }}
			</div>
		</li>
		@endif
		@if (!empty($album->album_label))
		<li class="row">
			<label class="col-md-3">Label</label>
			<div class="col-md-9">
				{{ $album->album_label }}
			</div>
		</li>
		@endif
		@if (!empty($album->album_release_date))
		<li class="row">
			<label class="col-md-3">Release date</label>
			<div class="col-md-9">
				{{ date('Y-m-d', strtotime( $album->album_release_date )) }}
			</div>
		</li>
		@endif
		@if (!empty($album->album_image))
		<li class="row">
			<label class="col-md-3">Image</label>
			<div class="col-md-9">
				{{ $album->album_image }}
			</div>
		</li>
		@endif
	</ul>

	<h3>Settings</h3>

	<ul class="list-inline">
		<li><a href="{{ route('album-setting.edit', array('id' => $album->album_id)) }}" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
	</ul>

	<h4>External services</h4>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Musicbrainz GID</label>
			<div class="col-md-9">
				@if ($album->meta->musicbrainz_gid !== null)
				<a href="{{ route( 'album-musicbrainz.show', array( 'id' => $album->meta->musicbrainz_gid, 'album' => $album->album_id ) ) }}">{{ $album->meta->musicbrainz_gid }}</a>
				@else
				Not set
				<a href="{{ route( 'album-musicbrainz.index', array( 'album' => $album->album_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
				@endif
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Discogs ID</label>
			<div class="col-md-9">
				@if ($album->meta->discogs_master_release_id !== null)
				<a href="http://discogs.com/master/{{ $album->meta->discogs_master_release_id }}">{{ $album->meta->discogs_master_release_id }}</a>
				@else
				Not set
				<a href="{{ route( 'album-setting.discogs.lookup', array( 'album' => $album->album_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
				@endif
			</div>
		</li>
	</ul>

	@if ($album->artist->meta->is_classical_artist == true)
	<h4>Classical</h4>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Ensemble</label>
			<div class="col-md-9">
				@if ($album->meta->ensemble_id > 0)
				{{ Artist::find( $album->meta->ensemble_id )->artist_display_name }}
				@else
				Not set
				@endif
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Soloist</label>
			<div class="col-md-9">
				@if ($album->meta->soloist_id > 0)
				{{ Artist::find( $album->meta->soloist_id )->artist_display_name }}
				@else
				Not set
				@endif
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Conductor</label>
			<div class="col-md-9">
				@if ($album->meta->conductor_id > 0)
				{{ Artist::find( $album->meta->conductor_id )->artist_display_name }}
				@else
				Not set
				@endif
			</div>
		</li>
	</ul>
	@endif

	<h3>Releases</h3>

	<ul class="list-inline">
		<li><a href="{{ route('release.create', array( 'album' => $album->album_id )) }}" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add a release</a></li>
	</ul>

	@if (count($album->releases) > 0)
	<table class="table">
		<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Catalog No.</th>
			<th>UPC</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
		@foreach ($album->releases as $release)
		<tr>
			<td>
				<div>
					<ul class="list-inline">
						<li><a href="{{ route( 'release.edit', array( 'id' => $release->release_id ) ) }}/" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil" title="[Edit]"></span> <span class="sr-only">Edit</span></a></li>
						<li><a href="{{ route( 'release.delete', array( 'id' => $release->release_id ) ) }}/" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove" title="[Delete]"></span> <span class="sr-only">Delete</span></a></li>
					</ul>
				</div>
			</td>
			<td>
				<a href="{{ route( 'release.show', array( 'id' => $release->release_id ) ) }}">
					@if (!empty($release->release_catalog_num))
					{{ $release->release_catalog_num }}
					@else
					Unassigned
					@endif
				</a>
			</td>
			<td>
				@if (!empty($release->release_ean_num))
				{{ $release->release_ean_num }}
				@else
				Unassigned
				@endif
			</td>
		</tr>
		@endforeach
	</table>
	@else
	<p>
		This album has no releases. Please add one.
	</p>
	@endif
</div>

@stop
