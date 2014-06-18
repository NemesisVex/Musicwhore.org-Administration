@extends('layout')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Profile</h3>
@stop

@section('content')
<div class="col-md-12">
	<ul class="list-inline">
		<li><a href="{{ route('artist.edit', array('id' => $artist->artist_id)) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
		<li><a href="{{ route('artist.delete', array('id' => $artist->artist_id)) }}" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
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

	<h3>Members</h3>

	{{ Form::open( array( 'route' => array( 'personnel.save-order' ), 'id' => 'save-order-form' ) ) }}
	<ul class="list-inline">
		<li><a href="{{ route( 'personnel.create', array( 'artist' => $artist->artist_id ) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add members</a></li>
		@if ($artist->personnel->count() > 0)
		<li>{{ Form::button( 'Save member order', array( 'id' => 'save-order', 'class' => 'btn btn-default' ) ) }}</li>
		@endif
	</ul>
	{{ Form::close() }}

	@if ($artist->personnel->count() > 0)
	<ul class="list-unstyled member-list">
		@foreach ($artist->personnel->sortBy('member_order') as $member)
		<li>
			<ul class="list-inline">
				<li><a href="{{ route( 'personnel.edit', array( 'id' => $member->member_id ) ) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> <span class="sr-only">Edit</span></a></li>
				<li><a href="{{ route( 'personnel.delete', array( 'id' => $member->member_id ) ) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span> <span class="sr-only">Delete</span></a></li>
				<li>
					<span class="member-order-display">{{ $member->member_order }}</span>. <a href="{{ route( 'personnel.show', array( 'id' => $member->member_id )) }}">{{ $member->member_display_name }}</a>@if (!empty($member->member_instruments)), {{$member->member_instruments}}@endif
					<input type="hidden" name="member_id" value="{{ $member->member_id }}" />
				</li>
			</ul>
		</li>
		@endforeach
	</ul>
	@else
	<p>
		This artist has no personnel.
	</p>
	@endif

	<div id="save-order-dialog">
		<p class="msg"></p>
	</div>

	<script type="text/javascript">
		$('.member-list').sortable({
			update: function (event, ui) {
				var new_order_num = 1;
				$(this).children().each(function () {
					$(this).find('.member-order-display').html(new_order_num);
					new_order_num++;
				});
			}
		});

		$('#save-order-dialog').dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				"OK": function () {
					$(this).dialog('close');
				}
			}
		});
		$('#save-order').click(function () {
			var members = [], member_order, member_id;
			$('.member-list').children().each(function () {
				member_order = $(this).find('.member-order-display').html();
				member_id = $(this).find('input[name=member_id]').val();
				member_info = {
					'member_id': member_id,
					'member_order': member_order,
				}
				members.push(member_info);
			});
			var _token = $('#save-order-form').find('input[name=_token]').val();
			var url = $('#save-order-form').attr('action');
			var data = {
				'members': members,
				'_token': _token
			};
			$.post(url, data, function (result) {
				$('#save-order-dialog').dialog('open');
				$('#save-order-dialog').find('.msg').html(result);
			}).error(function (result) {
				var error_msg = 'Your request could not be completed. The following error was given: ' + result.statusText;
				$('#save-order-dialog').dialog('open');
				$('#save-order-dialog').find('.msg').html(error_msg);
			});
		});
	</script>

	<h3>Settings</h3>

	<ul class="list-inline">
		<li><a href="{{ route('artist-setting.edit', array('artist' => $artist->artist_id)) }}" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
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
				<a href="{{ route( 'artist-musicbrainz.show', array( 'id' => $artist->meta->musicbrainz_gid, 'artist' => $artist->artist_id ) ) }}">{{ $artist->meta->musicbrainz_gid }}</a>
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
		<li><a href="{{ route( 'album.create', array( 'artist' => $artist->artist_id ) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add album</a></li>
	</ul>

	<h4>Import</h4>

	<ul class="list-inline">
		<li><a href="{{ route( 'album-musicbrainz.index', array( 'arid' => $artist->meta->musicbrainz_gid, 'artist' => $artist->artist_id ) ) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-plus"></span> Musicbrainz</a></li>
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
					<li><a href="{{ route( 'album.edit', array( 'id' => $album->album_id ) ) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> <span class="sr-only">Edit</span></a></li>
					<li><a href="{{ route( 'album.delete', array( 'id' => $album->album_id ) ) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span> <span class="sr-only">Delete</span></a></li>
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
