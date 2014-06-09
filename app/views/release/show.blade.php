@extends('layout')

@section('page_title')
 &raquo; {{ $release->album->artist->artist_display_name }}
 &raquo; {{ $release->album->album_title }}
@if (!empty($release->release_catalog_num))
 &raquo; {{ $release->release_catalog_num }}
@endif
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $release->album->artist->artist_display_name }}
		<small>{{ $release->album->album_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>
	Release info
	@if (!empty($release->release_catalog_num))
	<small>{{ $release->release_catalog_num }}</small>
	@endif
</h3>
@stop

@section('content')
<div class="col-md-12">

	<ul class="list-inline">
		<li><a href="{{ route( 'release.edit', array( 'id' => $release->release_id ) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
		<li><a href="{{ route( 'release.delete', array( 'id' => $release->release_id ) ) }}" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
	</ul>

	<ul class="list-unstyled">
		<li class="row">
				<label class="col-md-3">Format</label>
			<div class="col-md-9">
				{{ $release->format->format_name }}
			</div>
		</li>
		@if (!empty($release->release_label))
		<li class="row">
			<label class="col-md-3">Label</label>
			<div class="col-md-9">
				{{ $release->release_label }}
			</div>
		</li>
		@endif
		@if (!empty($release->release_alternate_title))
		<li class="row">
			<label class="col-md-3">Alternate title</label>
			<div class="col-md-9">
				{{ $release->release_alternate_title }}
			</div>
		</li>
		@endif
		@if (!empty($release->release_ean_num))
		<li class="row">
			<label class="col-md-3">UPC No.</label>
			<div class="col-md-9">
				{{ $release->release_ean_num }}
			</div>
		</li>
		@endif
		@if (!empty($release->release_catalog_num))
		<li class="row">
			<label class="col-md-3">Catalog No.</label>
			<div class="col-md-9">
				{{ $release->release_catalog_num }}
			</div>
		</li>
		@endif
		@if (!empty($release->release_release_date))
		<li class="row">
			<label class="col-md-3">Release Date</label>
			<div class="col-md-9">
				{{ date('Y-m-d', strtotime($release->release_release_date)) }}
			</div>
		</li>
		@endif
		@if (!empty($release->release_country_name))
		<li class="row">
			<label class="col-md-3">Country</label>
			<div class="col-md-9">
				{{ $release->release_country_name }}
			</div>
		</li>
		@endif
		@if (!empty($release->release_image))
		<li class="row">
			<label class="col-md-3">Image</label>
			<div class="col-md-9">
				{{ $release->release_image }}
			</div>
		</li>
		@endif
	</ul>

	<h3>Settings</h3>

	<ul class="list-inline">
		<li><a href="{{ route( 'release-setting.edit', array( 'id' => $release->release_id ) ) }}" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
	</ul>

	<ul class="list-unstyled">
		<li class="row">
			<label class="col-md-3">Amazon ASIN</label>
			<div class="col-md-9">
				{{ $release->meta->asin_num }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Musicbrainz GID</label>
			<div class="col-md-9">
				{{ $release->meta->musicbrainz_gid }}
			</div>
		</li>
		<li class="row">
			<label class="col-md-3">Discogs ID</label>
			<div class="col-md-9">
				{{ $release->meta->discogs_id }}
			</div>
		</li>
	</ul>

	<h3>Tracks</h3>

	{{ Form::open( array( 'route' => array( 'track.save-order' ), 'id' => 'save-order-form' ) ) }}
	<ul class="list-inline">
		<li><a href="{{ route( 'track.create', array('release' => $release->release_id) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add a track</a></li>
		@if (count($release->release_track_list) > 0)
		<li>{{ Form::button( 'Save track order', array( 'id' => 'save-order', 'class' => 'btn btn-default' ) ) }}</li>
		@endif
	</ul>
	<p>

	</p>
	{{ Form::close() }}

	@if (count($release->release_track_list) > 0)
	<ol class="list-unstyled disc-list">
		@foreach ($release->release_track_list as $disc_num => $tracks)
		<li> <h4>Disc: <span class="disc-num-display">{{ $disc_num }}</span>:</h4>
			<ol class="list-unstyled track-list">
				@foreach ($tracks as $track)
				<li>
					<div>
						<ul class="list-inline">
							<li><a href="{{ route( 'track.edit', array( 'id' => $track->track_id ) ) }}" title="[Edit]" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> <span class="sr-only">Edit</span></a></li>
							<li><a href="{{ route( 'track.delete', array( 'id' => $track->track_id ) ) }}" title="[Delete]" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span> <span class="sr-only">Delete</span></a></li>
							<li>
								<span class="track-num-display">{{ $track->track_track_num }}</span>. <a href="{{ route( 'track.show', array( 'id' => $track->track_id ) ) }}">{{ $track->track_song_title }}</a>
								<input type="hidden" name="track_id" value="{{ $track->track_id }}" />
								<input type="hidden" name="track_disc_num" value="{{ $track->track_disc_num }}" />
							</li>
						</ul>
					</div>
				</li>
				@endforeach
			</ol>
		</li>
		@endforeach
	</ol>

	<div id="save-order-dialog">
		<p class="msg"></p>
	</div>

	<script type="text/javascript">
		$('.track-list').sortable({
			update: function (event, ui) {
				var new_track_num = 1;
				$(this).children().each(function () {
					$(this).find('.track-num-display').html(new_track_num);
					new_track_num++;
				});
			}
		});
		if ($('.disc-list').children().length > 1) {
			$('.disc-list').sortable({
				update: function (event, ui) {
					var new_disc_num = 1;
					$(this).children().each(function () {
						$(this).find('.disc-num-display').html(new_disc_num);
						$(this).find('.track-list li').each(function () {
							$(this).find('input[name=track_disc_num]').val(new_disc_num);
						});
						new_disc_num++;
					});
				}
			});
		}
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
			var tracks = [], track_disc, track_num, track_id, track_info;
			$('.track-list').children().each(function () {
				track_num = $(this).find('.track-num-display').html();
				track_id = $(this).find('input[name=track_id]').val();
				track_disc = $(this).find('input[name=track_disc_num]').val();
				track_info = {
					'track_id': track_id,
					'track_track_num': track_num,
					'track_disc_num': track_disc
				}
				tracks.push(track_info);
			});
			var _token = $('#save-order-form').find('input[name=_token]').val();
			var url = $('#save-order-form').attr('action');
			var data = {
				'tracks': tracks,
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

	@else
	<p>
		This release has no tracks.
	</p>
	@endif


	<h4>Ecommerce links</h4>

	{{ Form::open( array( 'route' => array( 'ecommerce.save-order' ), 'id' => 'save-ecommerce-form' ) ) }}
	<ul class="list-inline">
		<li><a href="{{ route( 'ecommerce.create', array('release' => $release->release_id) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add an ecommerce link</a></li>
		@if (count($release->ecommerce) > 0)
		<li>{{ Form::button( 'Save ecommerce link order', array('id' => 'save-ecommerce-order', 'class' => 'btn btn-default') ) }}</li>
		@endif
	</ul>
	{{ Form::close() }}

	@if (count($release->ecommerce) > 0)
	<ul class="ecommerce-list">
		@foreach ($release->ecommerce as $ecommerce)
		<li>
			<div>
				<ul class="list-inline">
					<li><a href="{{ route( 'ecommerce.edit', array('id' => $ecommerce->ecommerce_id) ) }}"><span class="glyphicon glyphicon-pencil"></span></a></li>
					<li><a href="{{ route( 'ecommerce.delete', array('id' => $ecommerce->ecommerce_id) ) }}"><span class="glyphicon glyphicon-remove"></span></a></li>
					<li>
						<span class="ecommerce-list-order">{{ $ecommerce->ecommerce_list_order }}</span>. <a href="{{ route( 'ecommerce.show', array('id' => $ecommerce->ecommerce_id) ) }}">{{ $ecommerce->ecommerce_label }}</a>
						<input type="hidden" name="ecommerce_id" value="{{ $ecommerce->ecommerce_id }}" />
					</li>
				</ul>
			</div>
		</li>
		@endforeach
	</ul>

	<div id="save-list-order-dialog">
		<p class="msg"></p>
	</div>

	<script type="text/javascript">
		$('.ecommerce-list').sortable({
			update: function (event, ui) {
				var new_list_order = 1;
				$(this).children().each(function () {
					$(this).find('.ecommerce-list-order').html(new_list_order);
					new_list_order++;
				});
			}
		});
		$('#save-list-order-dialog').dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				"OK": function () {
					$(this).dialog('close');
				}
			}
		});
		$('#save-ecommerce-order').click(function () {
			var ecomm_links = [], ecomm_list_order, ecomm_id, ecomm_info;
			$('.ecommerce-list').children().each(function () {
				ecomm_list_order = $(this).find('.ecommerce-list-order').html();
				ecomm_id = $(this).find('input[name=ecommerce_id]').val();
				ecomm_info = {
					'ecommerce_id': ecomm_id,
					'ecommerce_list_order': ecomm_list_order,
				}
				ecomm_links.push(ecomm_info);
			});
			var _token =  $('#save-ecommerce-form').find('input[name=_token]').val();
			var url = $('#save-ecommerce-form').attr('action');
			var data = {
				'ecommerce': ecomm_links,
				'_token': _token
			};
			$.post(url, data, function (result) {
				$('#save-list-order-dialog').dialog('open');
				$('#save-list-order-dialog').find('.msg').html(result);
			}).error(function (result) {
				var error_msg = 'Your request could not be completed. The following error was given: ' + result.statusText;
				$('#save-list-order-dialog').dialog('open');
				$('#save-list-order-dialog').find('.msg').html(error_msg);
			});
		});
	</script>
	@else
	<p>This release has no ecommerce links.</p>
	@endif

</div>

@stop

