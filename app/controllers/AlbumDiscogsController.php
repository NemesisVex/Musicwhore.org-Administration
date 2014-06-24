<?php

use \Discogs;

class AlbumDiscogsController extends \BaseController {

	private $layout_variables = array();

	public function __construct() {
		global $config_url_base;

		$this->layout_variables = array(
			'config_url_base' => $config_url_base,
		);

		$this->beforeFilter('csrf', array( 'only' => array( 'store', 'update', 'destroy' ) ) );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$discogs_artist_id = Input::get('discogs_artist_id');
		$artist_id = Input::get('artist');
		$requested_page = Input::get('page');
		$discogs_albums = null;

		$discogs = new Discogs\Service();

		if (!empty($discogs_artist_id)) {

			$discogs_albums = $discogs->getReleases($discogs_artist_id);
		}

		if (!empty($artist_id)) {
			$artist = Artist::find($artist_id);

			if (empty($discogs_artist_id)) {

				$args = array(
					'q' => $artist->artist_display_name,
					'page' => $requested_page,
					'type' => 'master',
				);

				$results = $discogs->search( $args );
				$discogs_pagination = $results->getPagination();

				$discogs_albums = $results->getResults();

				$pagination = Paginator::make($discogs_albums, $discogs_pagination->getItems(), $discogs_pagination->getPerPage());
			}
		}

		$method_variables = array(
			'discogs_artist_id' => $discogs_artist_id,
			'discogs_albums' => $discogs_albums,
			'pagination' => $pagination,
			'artist' => $artist,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.discogs.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$discogs_master_release_id = Input::get('discogs_master_release_id');
		$artist_id = Input::get( 'album_artist_id' );
		$album = null;

		if (!empty($discogs_master_release_id)) {
			$discogs = new Discogs\Service();

			$discogs_album = $discogs->getMaster($discogs_master_release_id);

			$album = new Album;

			$album->album_artist_id = $artist_id;
			$album->album_title = $discogs_album->getTitle();
			$album->album_sort_title = $discogs_album->getTitle();
			$album->album_release_date = date('Y-m-d', strtotime( $discogs_album->getYear() . '-01-01' ) );

			$album->artist()->find($artist_id);
		}

		$formats = AlbumFormat::orderBy('format_alias')->get()->lists('format_alias', 'format_id');
		$formats = array(0 => '&nbsp;') + $formats;

		$method_variables = array(
			'album' => $album,
			'discogs_master_release_id' => $discogs_master_release_id,
			'formats' => $formats,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.discogs.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$album = new Album;

		$fields = $album->getFillable();

		foreach ($fields as $field) {
			$album->{$field} = Input::get($field);
		}

		$result = $album->save();

		if ($result !== false) {
			$gid_meta = new AlbumMeta;
			$gid_meta->meta_field_name = 'discogs_master_album_id';
			$gid_meta->meta_field_value = Input::get('discogs_master_release_id');

			$album->meta()->save($gid_meta);

			return Redirect::route('album.show', array('id' => $album->album_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', array('id' => Input::get( 'album_artist_id' ) ) )->with('error', 'Your changes were not saved.');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$discogs = new Discogs\Service;

		$discogs_master_release = $discogs->getMaster($id);

		$album_id = Input::get('album');

		$album = (!empty($album_id)) ? Album::find($album_id) : null;

		$method_variables = array(
			'album' => $album,
			'discogs_master_release' => $discogs_master_release,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.discogs.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
