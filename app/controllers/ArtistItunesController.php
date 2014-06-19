<?php

class ArtistItunesController extends \BaseController {

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
		$q_artist = Input::get('q_artist');
		$artist_id = Input::get('artist');
		$locale = Input::get('locale');
		$artists = null;
		$artist = null;

		if (empty($locale)) {
			$locale = 'US';
		}

		if (!empty($artist_id)) {
			$artist = Artist::find($artist_id);

			if (empty($q_artist)) {
				$q_artist = $artist->artist_display_name;
			}
		}

		if (!empty($q_artist)) {
			$results = ITunes::musicInRegion($locale, $q_artist, array('entity' => 'musicArtist'));
			$artists = json_decode($results);
		}

		$method_variables = array(
			'artist' => $artist,
			'artists' => $artists,
			'q_artist' => $q_artist,
			'locale' => $locale,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.itunes.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$itunes_id = Input::get('itunes_artist_id');

		if (!empty($itunes_id)) {
			$results = ITunes::lookup($itunes_id);
			$itunes_artist = json_decode($results);

			if ($itunes_artist->resultCount > 0) {
				$artist = new Artist;

				$artist->artist_last_name = $itunes_artist->results[0]->{ 'artistName' };
				$artist->artist_file_system = str_replace( ' ', '-', strtolower($itunes_artist->results[0]->{ 'artistName' }) );
			}
		}

		$method_variables = array(
			'artist' => $artist,
			'itunes_id' => $itunes_id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.itunes.create', $data);
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
			$itunes_meta = new ArtistMeta;
			$itunes_meta->meta_field_name = 'itunes_id';
			$itunes_meta->meta_field_value = Input::get( 'itunes_id' );

			$artist->meta()->save($itunes_meta);

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
		$artist_id = Input::get('artist');

		if (!empty($id)) {
			$results = ITunes::lookup($id);
			$itunes_artists = json_decode($results);
		}

		if (!empty($artist_id)) {
			$artist = Artist::find($artist_id);
		}

		$method_variables = array(
			'itunes_artists' => $itunes_artists,
			'artist' => $artist,
			'itunes_id' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.itunes.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$results = ITunes::lookup($id);
		$itunes_artists = json_decode($results);

		$artist_id = Input::get('artist');
		$artist = Artist::find($artist_id);

		$artist->artist_last_name = $itunes_artists->results[0]->{ 'artistName' };
		$artist->artist_file_system = str_replace( ' ', '-', strtolower($itunes_artists->results[0]->{ 'artistName' }) );

		$method_variables = array(
			'artist' => $artist,
			'itunes_id' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.itunes.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$artist = Artist::find($id);

		$fields = $artist->getFillable();

		foreach ($fields as $field) {
			$artist->{$field} = Input::get($field);
		}

		$result = $artist->save();

		if ($result !== false) {
			$artist->meta->itunes_id = Input::get( 'itunes_id' );

			$artist->meta->save();

			return Redirect::route('artist.show', array('id' => $artist->artist_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.index')->with('error', 'Your changes were not saved.');
		}
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
