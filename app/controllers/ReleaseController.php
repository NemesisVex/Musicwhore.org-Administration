<?php

class ReleaseController extends \BaseController {

	private $layout_variables = array();

	public function __construct() {
		global $config_url_base;

		$this->layout_variables = array(
			'config_url_base' => $config_url_base,
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

		$formats = ReleaseFormat::all()->lists('format_alias', 'format_id');

		$method_variables = array(
			'release' => $release,
			'albums' => $albums,
			'formats' => $formats,
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

	public function export_id3($id) {

		$file_lines = array();
		foreach ($id->tracks as $track) {
			$tag = array(
				$track->release->album->artist->artist_display_name,
				$track->release->album->artist->artist_display_name,
				$track->release->album->album_title,
				date('Y', strtotime($track->release->release_release_date)),
				'Other',
				'℗ ' . date('Y', strtotime($track->release->release_release_date)) . ' Observant Records',
				$track->recording->recording_isrc_num,
				sprintf('%02d', $track->track_track_num),
				$track->song->song_title,
			);
			$tag_line = implode('|', $tag);
			$file_lines[] = $tag_line;
		}
		$file = implode("\r\n", $file_lines);

		$file_with_bom = chr(239) . chr(187) . chr(191) . $file;

		$file_name = $id->album->artist->artist_display_name . ' - ' . $id->album->album_title . '.m3u.txt';
		header('Cache-Control: private');
		header('Content-Disposition: attachment; filename="' . $file_name . '"');
		header("Content-Type: text/plain; charset=utf-8");
		echo $file_with_bom;
		die();
	}
}
