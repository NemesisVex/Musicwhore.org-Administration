<?php

class AlbumController extends \BaseController {

	private $layout_variables = array();

	public function __construct() {
		global $config_url_base;

		$format_list = array();
		$formats = AlbumFormat::orderBy('format_alias')->get();
		foreach ($formats as $format) {
			$format_list[$format->format_id] = $format->format_alias;
		}

		$this->layout_variables = array(
			'config_url_base' => $config_url_base,
			'formats' => $format_list,
			'locales' => array('en', 'jp'),
		);

		$this->beforeFilter('auth');

		$this->beforeFilter('csrf', array( 'only' => array( 'store', 'update', 'destroy' ) ) );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$artist_id = Input::get('artist');
		if (!empty($artist_id)) {
			$albums = Album::where('album_artist_id', $artist_id)->orderBy('album_title')->get();
		} else {
			$albums = Album::orderBy('album_title')->get();
		}
		$albums->load('artist');

		$method_variables = array(
			'albums' => $albums,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$artist_id = Input::get('artist');

		$album = new Album;
		$album->album_release_date = date('Y-m-d');
		$album->album_ctype_locale = 'en';
		if (!empty($artist_id)) {
			$album->album_artist_id = $artist_id;
			$album->artist = Artist::find($artist_id);
		}

		$artists = Artist::orderBy('artist_last_name')->lists('artist_display_name', 'artist_id');

		$method_variables = array(
			'album' => $album,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$id = new Album;

		$fields = $id->getFillable();

		foreach ($fields as $field) {
			$id->{$field} = Input::get($field);
		}

		$result = $id->save();

		if ($result !== false) {
			return Redirect::route('album.show', array('id' => $id->album_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', array('id' => $id->album_artist_id))->with('error', 'Your changes were not saved.');
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
		$method_variables = array(
			'album' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$releases = $id->releases->lists('release_catalog_num', 'release_id');
		$artists = Artist::orderBy('artist_last_name')->lists('artist_display_name', 'artist_id');

		$method_variables = array(
			'album' => $id,
			'releases' => $releases,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$fields = $id->getFillable();

		foreach ($fields as $field) {
			$id->{$field} = Input::get($field);
		}

		$result = $id->save();

		if ($result !== false) {
			return Redirect::route('album.show', array('id' => $id->album_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', array('id' => $id->album_artist_id))->with('error', 'Your changes were not saved.');
		}
	}


	public function delete($id) {

		$method_variables = array(
			'album' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.delete', $data);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$confirm = (boolean) Input::get('confirm');
		$album_title = $id->album_title;
		$artist_id = $id->album_artist_id;

		if ($confirm === true) {
			if (count($id->releases) > 0) {
				foreach ($id->releases as $release) {
					/*
					 * This bit of logic is not yet supported.
					foreach ($release->tracks as $track) {
						$track->ecommerce()->delete();
					}
					 */

					// Remove ecommerce.
					$release->ecommerce()->delete();

					// Remove tracks.
					$release->tracks()->delete();
				}

				// Remove releases.
				$id->releases()->delete();
			}

			// Remove album.
			$id->delete();
			return Redirect::route('artist.show', array('id' => $artist_id  ))->with('message', $album_title . ' was deleted.');
		} else {
			return Redirect::route('album.show', array('id' => $id->album_id))->with('error', $album_title . ' was not deleted.');
		}
	}

	public function save_order() {
		$albums = Input::get('albums');

		$is_success = true;
		if (count($albums) > 0) {
			foreach ($albums as $album) {
				if (false === $this->_update_album($album['album_id'], $album)) {
					$is_success = false;
					$error = 'Album order was not saved.';
					break;
				}
			}
		}

		echo ($is_success == true) ? 'Album order has been saved.' : $error;
	}

	private function _update_album($album_id, $input) {
		$album = Album::find($album_id);

		$album->album_order = $input['album_order'];

		return $album->save();
	}


}
