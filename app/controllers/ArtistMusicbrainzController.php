<?php

use \Guzzle\Http\Client;
use \MusicBrainz\Filters\ArtistFilter;
use \MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use \MusicBrainz\MusicBrainz;

class ArtistMusicbrainzController extends \BaseController {

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
		$artists = null;

		if (!empty($q_artist)) {
			$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

			$args = array(
				'artist' => $q_artist,
			);

			$artists = $brainz->search( new ArtistFilter( $args ) );
		}

		$method_variables = array(
			'artists' => $artists,
			'q_artist' => $q_artist,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.musicbrainz.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$gid = Input::get('musicbrainz_gid');

		if (!empty($gid)) {
			$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

			$brainz_artist = (object) $brainz->lookup( 'artist', $gid );

			$artist = new Artist;

			$artist->artist_last_name = $brainz_artist->{ 'name' };
			$artist->artist_sort_name = $brainz_artist->{ 'sort-name' };
			$artist->artist_file_system = str_replace( ' ', '-', strtolower($brainz_artist->{ 'name' }) );
		}

		$method_variables = array(
			'artist' => $artist,
			'gid' => $gid,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.musicbrainz.create', $data);
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

			$artist_meta = new ArtistMeta;
			$artist_meta->meta_artist_id = $artist->artist_id;
			$artist_meta->meta_field_name = 'musicbrainz_gid';
			$artist_meta->meta_field_value = Input::get('musicbrainz_gid');
			$artist_meta->save();

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
			$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

			$brainz_artist = (object) $brainz->lookup( 'artist', $id );
		}

		if (!empty($artist_id)) {
			$artist = Artist::find($artist_id);
		}

		$method_variables = array(
			'brainz_artist' => $brainz_artist,
			'artist' => $artist,
			'gid' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.musicbrainz.show', $data);
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
