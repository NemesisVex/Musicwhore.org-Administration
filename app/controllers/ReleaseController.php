<?php

use \Guzzle\Http\Client;
use \MusicBrainz\Filters\ReleaseFilter;
use \MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use \MusicBrainz\MusicBrainz;
use \Discogs;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;

class ReleaseController extends \BaseController {

	private $layout_variables = array();
	private $amazon_config;
	private $associate_suffixes;
	private $country_codes;
	private $associate_tag_base = 'musicwhore-';

	public function __construct() {
		global $config_url_base;

		$this->layout_variables = array(
			'config_url_base' => $config_url_base,
		);

		$this->amazon_config = new GenericConfiguration();
		$this->amazon_config->setAccessKey(ACCESS_KEY_ID)->setSecretKey(SECRET_ACCESS_KEY);
		$this->associate_suffixes = Config::get('amazon.associate_suffixes');
		$this->country_codes = Config::get('amazon.country_codes');

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
		$album_id = Input::get('album');
		if (!empty($album_id)) {
			$releases = Release::where('release_album_id', $album_id)->orderBy('release_catalog_num')->get();
		} else {
			$releases = Release::orderBy('release_catalog_num')->get();
		}
		$releases->load('album');

		$method_variables = array(
			'releases' => $releases,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$release = new Release;
		$release->release_release_date = date('Y-m-d');

		$album_id = Input::get('album');

		if (!empty($album_id)) {
			$release->release_album_id = $album_id;
			$release->album = Album::find($album_id);
			$albums = Album::where('album_artist_id', $release->album->album_artist_id)->orderBy('album_title')->lists('album_title', 'album_id');
		} else {
			$albums = Album::orderBy('album_title')->lists('album_title', 'album_id');
		}
		$albums = array('0' => '&nbsp;') + $albums;

		$formats = ReleaseFormat::all()->lists('format_alias', 'format_id');
		$formats = array('0' => '&nbsp;') + $formats;

		$countries = Country::orderBy('country_name')->lists('country_name', 'country_name');
		$countries = array('0' => '&nbsp;') + $countries;


		$method_variables = array(
			'release' => $release,
			'albums' => $albums,
			'formats' => $formats,
			'countries' => $countries,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$release = new Release;

		$fields = $release->getFillable();

		foreach ($fields as $field) {
			$release->{$field} = Input::get($field);
		}

		$result = $release->save();

		if ($result !== false) {
			return Redirect::route('release.show', array('id' => $release->release_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('album.show', array('id' => $release->release_album_id) )->with('error', 'Your changes were not saved.');
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
		$track_model = new Track();
		$id->release_track_list = $track_model->findReleaseTracks($id->release_id);
		//$id->ecommerce->sortBy('ecommerce_list_order');

		$method_variables = array(
			'release' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$albums = Album::where('album_artist_id', $id->album->album_artist_id)->orderBy('album_title')->lists('album_title', 'album_id');
		$albums = array('0' => '&nbsp;') + $albums;

		$formats = ReleaseFormat::lists('format_alias', 'format_id');
		$formats = array('0' => '&nbsp;') + $formats;

		$countries = Country::orderBy('country_name')->lists('country_name', 'country_name');
		$countries = array('0' => '&nbsp;') + $countries;

		$method_variables = array(
			'release' => $id,
			'albums' => $albums,
			'formats' => $formats,
			'countries' => $countries,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.edit', $data);
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
			return Redirect::route('release.show', array('id' => $id->release_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('album.show', array('id' => $id->release_album_id))->with('error', 'Your changes were not saved.');
		}
	}


	public function delete($id) {

		$method_variables = array(
			'release' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.delete', $data);
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
		$release_catalog_num = $id->release_catalog_num;
		$album_id = $id->release_album_id;

		if ($confirm === true) {
			/*
			 * Tracks are currently not supported, but this bit of logic will be available if/when they are.
			$ecommerce_tracks = Track::with('ecommerce')->where('track_release_id', $id->release_id)->get();
			foreach ($ecommerce_tracks as $ecommerce_track) {
				$ecommerce_track->ecommerce()->delete();
			}
			 */

			// Remove ecommerce.
			$id->ecommerce()->delete();

			// Remove tracks.
			$id->tracks()->delete();

			// Remove releases.
			$id->delete();
			return Redirect::route('album.show', array('id' => $album_id  ))->with('message', 'The record was deleted.');
		} else {
			return Redirect::route('release.show', array('id' => $id->release_id))->with('error', 'The record was not deleted.');
		}
	}

	public function lookup_musicbrainz($id) {

		$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

		if ($id->album->meta->musicbrainz_gid != null) {
			$args['rgid'] = $id->album->meta->musicbrainz_gid;
		} else {
			$args['release'] = $id->album->album_title;
		}

		$releases = $brainz->search( new ReleaseFilter( $args ) );

		$method_variables = array(
			'release' => $id,
			'q_release' => $id->album_title,
			'releases' => $releases,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.musicbrainz.lookup', $data);
	}

	public function search_musicbrainz() {

		$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

		$q_release_group = Input::get('q_release_group');
		$arid = Input::get('arid');
		$artist = Input::get('artist');
		$id = Input::get('id');

		$args = array(
			'release' => $q_release_group,
		);

		if (!empty($arid)) {
			$args['arid'] = $arid;
		} elseif (!empty($artist)) {
			$args['artist'] = $artist;
		}

		$release_groups = $brainz->search( new ReleaseFilter( $args ) );

		$method_variables = array(
			'album' => Album::find($id),
			'q_release_group' => $q_release_group,
			'release_groups' => $release_groups,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.musicbrainz.lookup', $data);
	}

	public function lookup_discogs($id) {

		$discogs = new Discogs\Service();

		$args = array(
			'q' => $id->album_title,
			'artist' => $id->album->artist->artist_display_name,
			'type' => 'release',
		);

		$releases = $discogs->search( $args );

		$method_variables = array(
			'release' => $id,
			'artist' => $id->album->artist->artist_display_name,
			'q_release' => $id->album->album_title,
			'releases' => $releases,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.discogs.lookup', $data);
	}

	public function search_discogs() {

		$discogs = new Discogs\Service();

		$q_release = Input::get('q_release');
		$artist = Input::get('artist');
		$id = Input::get('id');

		$args = array(
			'q' => $q_release,
			'artist' => $artist,
			'type' => 'release',
		);

		$releases = $discogs->search( $args );

		$method_variables = array(
			'release' => Release::find($id),
			'artist' => $artist,
			'q_release' => $q_release,
			'releases' => $releases,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.discogs.lookup', $data);
	}

	public function lookup_amazon($id) {

		$locale = $id->album->artist->meta->default_amazon_locale;
		if (empty($locale)) { $locale = 'us'; }

		$associate_tag = $this->get_associate_tag($locale);
		$this->amazon_config->setAssociateTag($associate_tag);
		$this->amazon_config->setCountry($this->country_codes[$locale]);

		$apaiIO = new ApaiIO($this->amazon_config);

		$search = new Search();
		$search->setCategory('Music');
		$search->setArtist($id->album->artist->artist_display_name);
		$search->setKeywords($id->album->album_title);
		$search->setResponseGroup(array('Large', 'Small'));

		$response = simplexml_load_string($apaiIO->runOperation($search));
		$releases = json_decode(json_encode($response->Items));

		$method_variables = array(
			'release' => $id,
			'artist' => $id->album->artist->artist_display_name,
			'q_release' => $id->album->album_title,
			'releases' => $releases,
			'domain' => $this->country_codes[$locale],
			'locales' => Config::get('amazon.locales'),
			'locale' => $locale,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.amazon.lookup', $data);
	}

	public function search_amazon() {

		$q_release = Input::get('q_release');
		$artist = Input::get('artist');
		$locale = Input::get('locale');
		$id = Input::get('id');

		if (empty($locale)) { $locale = 'us'; }

		$associate_tag = $this->get_associate_tag($locale);
		$this->amazon_config->setAssociateTag($associate_tag);
		$this->amazon_config->setCountry($this->country_codes[$locale]);

		$apaiIO = new ApaiIO($this->amazon_config);

		$search = new Search();
		$search->setCategory('Music');
		if (!empty($artist)) {
			$search->setArtist($artist);
		}
		$search->setKeywords($q_release);
		$search->setResponseGroup(array('Large', 'Small'));

		$response = simplexml_load_string($apaiIO->runOperation($search));
		$releases = json_decode(json_encode($response->Items));

		$method_variables = array(
			'release' => Release::find($id),
			'artist' => $artist,
			'q_release' => $q_release,
			'releases' => $releases,
			'domain' => $this->country_codes[$locale],
			'locales' => Config::get('amazon.locales'),
			'locale' => $locale,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.amazon.lookup', $data);
	}

	private function get_associate_tag($locale = 'us') {
		return $this->associate_tag_base . $this->associate_suffixes[$locale];
	}

	public function lookup_itunes($id) {

		$locale = strtoupper($id->album->artist->meta->default_itunes_store);
		if (empty($locale)) { $locale = 'US'; }

		$results = ITunes::musicInRegion($locale, $id->album->artist->artist_display_name . ' ' . $id->album->album_title, array('entity' => 'album'));
		$releases = json_decode($results);

		$method_variables = array(
			'release' => $id,
			'artist' => $id->album->artist->artist_display_name,
			'q_release' => $id->album->album_title,
			'releases' => $releases,
			'locales' => Config::get('itunes.locales'),
			'locale' => $locale,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.itunes.lookup', $data);
	}

	public function search_itunes() {
		$q_release = Input::get('q_release');
		$artist = Input::get('artist');
		$locale = Input::get('locale');
		$id = Input::get('id');

		if (empty($locale)) { $locale = 'US'; }

		$results = ITunes::musicInRegion($locale, $artist . ' ' . $q_release, array('entity' => 'album'));
		$releases = json_decode($results);

		$method_variables = array(
			'release' => Release::find($id),
			'artist' => $artist,
			'q_release' => $q_release,
			'releases' => $releases,
			'locales' => Config::get('itunes.locales'),
			'locale' => $locale,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.itunes.lookup', $data);
	}
}
