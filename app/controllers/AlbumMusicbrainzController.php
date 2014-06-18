<?php

use \Guzzle\Http\Client;
use \MusicBrainz\Filters\ArtistFilter;
use \MusicBrainz\Filters\ReleaseFilter;
use \MusicBrainz\Filters\RecordingFilter;
use \MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use \MusicBrainz\MusicBrainz;

class AlbumMusicbrainzController extends \BaseController {

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
		$arid = Input::get('arid');
		$artist_id = Input::get('artist');

		if (!empty($arid)) {
			$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

			$brainz_artist = (object) $brainz->lookup( 'artist', $arid, array( 'release-groups' ) );
		}

		if (!empty($artist_id)) {
			$artist = Artist::find($artist_id);
		}

		$method_variables = array(
			'brainz_artist' => $brainz_artist,
			'artist' => $artist,
			'arid' => $arid,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.musicbrainz.show', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
