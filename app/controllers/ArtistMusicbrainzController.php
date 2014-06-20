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
		$artist_id = Input::get('artist');
		$artists = null;
		$artist = null;

		if (!empty($artist_id)) {
			$artist = Artist::find($artist_id);

			if (empty($q_artist)) {
				$q_artist = $artist->artist_display_name;
			}
		}

		if (!empty($q_artist)) {
			$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

			$args = array(
				'artist' => $q_artist,
			);

			$artists = $brainz->search( new ArtistFilter( $args ) );
		}

		$method_variables = array(
			'artist' => $artist,
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
		$default_amazon_locale = 'us';
		$default_itunes_store = 'US';

		if (!empty($gid)) {
			$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

			$brainz_artist = (object) $brainz->lookup( 'artist', $gid );

			$artist = new Artist;

			$artist->artist_last_name = $brainz_artist->{ 'name' };
			$artist->artist_sort_name = $brainz_artist->{ 'sort-name' };
			$artist->artist_file_system = str_replace( ' ', '-', strtolower($brainz_artist->{ 'name' }) );

			$default_amazon_locale = strtolower( $brainz_artist->{ 'country' } ) ;
			$default_itunes_store = strtoupper( $brainz_artist->{ 'country' } );
		}

		$method_variables = array(
			'artist' => $artist,
			'gid' => $gid,
			'default_amazon_locale' => $default_amazon_locale,
			'default_itunes_store' => $default_itunes_store,
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
			$gid_meta = new ArtistMeta;
			$gid_meta->meta_field_name = 'musicbrainz_gid';
			$gid_meta->meta_field_value = Input::get('musicbrainz_gid');

			$amazon_meta = new ArtistMeta;
			$amazon_meta->meta_field_name = 'default_amazon_locale';
			$amazon_meta->meta_field_value = Input::get( 'default_amazon_locale' );

			$itunes_meta = new ArtistMeta;
			$itunes_meta->meta_field_name = 'default_itunes_locale';
			$itunes_meta->meta_field_value = Input::get( 'default_itunes_locale' );

			$settings = array( $gid_meta, $amazon_meta, $itunes_meta, );

			$artist->meta()->saveMany($settings);

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
		$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );
		$brainz_artist = (object) $brainz->lookup( 'artist', $id );

		$artist_id = Input::get('artist');
		$artist = Artist::find($artist_id);

		if (!empty($brainz_artist->{ 'sort-name' })) {
			list ($last_name, $first_name) = explode(', ', $brainz_artist->{ 'sort-name' });
			$artist->artist_last_name = $last_name;
			$artist->artist_first_name = $first_name;
		} else {
			$artist->artist_last_name = $brainz_artist->{ 'name' };
		}
		$artist->artist_sort_name = $brainz_artist->{ 'sort-name' };
		$artist->artist_file_system = str_replace( ' ', '-', strtolower($brainz_artist->{ 'name' }) );

		$default_amazon_locale = strtolower( $brainz_artist->{ 'country' } );
		$default_itunes_store = strtoupper( $brainz_artist->{ 'country' } );

		$method_variables = array(
			'artist' => $artist,
			'gid' => $id,
			'default_amazon_locale' => $default_amazon_locale,
			'default_itunes_store' => $default_itunes_store,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.musicbrainz.edit', $data);
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
			$artist->meta->musicbrainz_gid = Input::get( 'musicbrainz_gid' );
			$artist->meta->default_amazon_locale = Input::get( 'default_amazon_locale' );
			$artist->meta->default_itunes_store = Input::get( 'default_itunes_store' );

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
