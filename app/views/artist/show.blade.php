@extends('layout')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
@stop

@section('section_head')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Profile</h3>
@stop

@section('content')
<div class="col-md-12">
	<ul class="list-inline">
		<li><a href="{{ route('artist.edit', array('id' => $artist->artist_id)) }}" class="button"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
		<li><a href="{{ route('artist.delete', array('id' => $artist->artist_id)) }}" class="button"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
	</ul>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Last name:</label>
			<div class="col-md-9">
				{{ $artist->artist_last_name }}
			</div>
		</li>
		@if (!empty($artist->artist_first_name))
		<li class="row">
			<label class="col-md-3">First name:</label>
			<div class="col-md-9">
				{{ $artist->artist_first_name }}
			</div>
		</li>
		@endif
		@if (!empty($artist->artist_display_name))
		<li class="row">
			<label class="col-md-3">Display name:</label>
			<div class="col-md-9">
				{{ $artist->artist_display_name }}
			</div>
		</li>
		@endif
		<li class="row">
			<label class="col-md-3">File system alias:</label>
			<div class="col-md-9">
				{{ $artist->artist_file_system }}
			</div>
		</li>
	</ul>

	<h3>Settings</h3>

	<ul class="list-inline">
		<li><a href="{{ route('artist-setting.edit', array('artist' => $artist->artist_id)) }}" class="button"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
	</ul>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Use Asian name format:</label>
			<div class="col-md-9">
				@if ($artist->meta->is_asian_name == true) Yes @else No @endif
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">J~E Artist:</label>
			<div class="col-md-9">
				@if ($artist->meta->is_je_artist == true) Yes @else No @endif
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Classical Artist:</label>
			<div class="col-md-9">
				@if ($artist->meta->is_classical_artist == true) Yes @else No @endif
			</div>
		</li>
	</ul>

	<h4>Navigation display</h4>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Profile:</label>
			<div class="col-md-9">
				@if ($artist->meta->nav_profile == true) Yes @else No @endif
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Discography:</label>
			<div class="col-md-9">
				@if ($artist->meta->nav_discography == true) Yes @else No @endif
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Posts:</label>
			<div class="col-md-9">
				@if ($artist->meta->nav_posts == true) Yes @else No @endif
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Shop:</label>
			<div class="col-md-9">
				@if ($artist->meta->nav_shop == true) Yes @else No @endif
			</div>
		</li>
	</ul>

	<h4>Ecommerce and external services</h4>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Musicbrainz GID:</label>
			<div class="col-md-9">
				{{ $artist->meta->musicbrainz_gid }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Default Amazon locale:</label>
			<div class="col-md-9">
				{{ $artist->meta->default_amazon_locale }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Default iTunes store:</label>
			<div class="col-md-9">
				{{ $artist->meta->default_itunes_store }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">iTunes ID:</label>
			<div class="col-md-9">
				{{ $artist->meta->itunes_id }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">YesAsia ID:</label>
			<div class="col-md-9">
				{{ $artist->meta->yesasia_id }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">eMusic SKU:</label>
			<div class="col-md-9">
				{{ $artist->meta->emusic_cjsku }}
			</div>
		</li>
	</ul>

	<h3>Albums</h3>

	<ul class="list-inline">
		<li><a href="{{ route( 'album.create', array( 'artist' => $artist->artist_id ) ) }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add album</a></li>
	</ul>

	@if ($artist->albums->count() > 0)
	<table class="table table-striped">
		<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Title</th>
			<th>Format</th>
			<th>Release Date</th>
			<th>Label</th>
		</tr>
		</thead>
		<tbody>
		@foreach ($artist->albums as $album)
		<tr>
			<td>
				<ul class="list-inline">
					<li><a href="{{ route( 'album.edit', array( 'id' => $album->album_id ) ) }}"><span class="glyphicon glyphicon-pencil"></span> <span class="sr-only">Edit</span></a></li>
					<li><a href="{{ route( 'album.delete', array( 'id' => $album->album_id ) ) }}"><span class="glyphicon glyphicon-remove"></span> <span class="sr-only">Delete</span></a></li>
				</ul>
			</td>
			<td><a href="{{ route( 'album.show', array( 'id' => $album->album_id ) ) }}">{{ $album->album_title }}</a></td>
			<td>{{ $album->format->format_alias }}</td>
			<td>{{ date('Y-m-d', strtotime($album->album_release_date)) }}</td>
			<td>{{ $album->album_label }}</td>
		</tr>
		@endforeach
		</tbody>
	</table>
	@else
	<p>
		This artist has no albums. Please <a href="{{ route( 'album.create', array( 'id' => $artist->artist_id ) ) }}">add one</a>.
	</p>
	@endif
</div>
@stop
