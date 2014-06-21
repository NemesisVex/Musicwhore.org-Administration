<?php

class ArtistController extends \BaseController {

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
		$filter = Input::get('browse');

		if (!empty($filter)) {
			$artists = Artist::orderBy('artist_last_name')->where('artist_last_name', 'LIKE', $filter . '%')->get();
		} else {
			$artists = Artist::orderBy('artist_last_name')->get();
		}

		$artist_model = new Artist;
		$artist_list = $artist_model->getAllByInitialLetter();

		$method_variables = array(
			'artists' => $artists,
			'artist_list' => $artist_list,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$artist = new Artist;

		$method_variables = array(
			'artist' => $artist,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$artist = new Artist;

		$fields = $artist->getFillable();

		foreach ($fields as $field) {
			$artist->{$field} = Input::get($field);
		}

		$result = $artist->save();

		if ($result !== false) {
			return Redirect::route('artist.show', array('id' => $artist->artist_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.index')->with('error', 'Your changes were not saved.');
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
		$id->albums->sortByDesc(function ($album) {
			return $album->album_release_date;
		});

		$method_variables = array(
			'artist' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$method_variables = array(
			'artist' => $id->load('meta'),
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.edit', $data);
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
			return Redirect::route('artist.show', array('id' => $id->artist_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.index')->with('error', 'Your changes were not saved.');
		}
	}

	/**
	 * Show the form for deleting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id) {

		$method_variables = array(
			'artist' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.delete', $data);
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
		$artist_display_name = $id->artist_display_name;

		if ($confirm === true) {
			// Gather albums, releases, tracks, audio, and ecommerce.
			if (count($id->albums) > 0) {
				foreach ($id->albums as $album) {
					if (count($album->releases) > 0) {
						foreach ($album->releases as $release) {
							if (count($release->tracks) > 0) {
								foreach ($release->tracks as $track) {
									// Remove track settings
									$track->meta()->delete();

									// Remove ecommerce and content by tracks.
									//$track->ecommerce()->delete();
								}

								// Remove release meta
								$release->meta()->delete();

								// Remove tracks.
								$release->tracks()->delete();


								// Remove ecommerce.
								//$release->ecommerce()->delete();
							}
						}
					}

					// Remove releases.
					$album->releases()->delete();

					// Remove album settings.
					$album->meta()->delete();
				}
			}

			// Remove albums.
			$id->albums()->delete();

			// Remove artist settings.
			$id->meta()->delete();

			// Remove personnel.
			$id->personnel()->delete();

			// Remove artist.
			$artist_id = $id->artist_id;
			$id->delete();

			return Redirect::route('artist.index')->with('message', $artist_display_name . ' was deleted.');
		} else {
			return Redirect::route('artist.show', array('id' => $id->artist_id))->with('error', $artist_display_name . ' was not deleted.');
		}
	}


}
