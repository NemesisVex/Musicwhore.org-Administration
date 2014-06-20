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
		$gid = Input::get('musicbrainz_gid');
		$artist_id = Input::get( 'album_artist_id' );
		$album = null;

		if (!empty($gid)) {
			$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

			$brainz_album = (object) $brainz->lookup( 'release-group', $gid );

			$album = new Album;

			$album->album_artist_id = $artist_id;
			$album->album_title = $brainz_album->{ 'title' };
			$album->album_sort_title = $brainz_album->{ 'title' };
			$album->album_release_date = $brainz_album->{ 'first-release-date' };
			$album->album_format_id = (false !== ($result = AlbumFormat::where('format_alias', $brainz_album->{ 'primary-type' })->first() ) ) ? $result->format_id : null;

			$album->artist()->find($artist_id);
		}

		$formats = AlbumFormat::orderBy('format_alias')->get()->lists('format_alias', 'format_id');
		$formats = array(0 => '&nbsp;') + $formats;

		$method_variables = array(
			'album' => $album,
			'gid' => $gid,
			'formats' => $formats,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.musicbrainz.create', $data);
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
			$gid_meta->meta_field_name = 'musicbrainz_gid';
			$gid_meta->meta_field_value = Input::get('musicbrainz_gid');

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
