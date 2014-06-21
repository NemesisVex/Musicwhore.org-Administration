<?php

class TrackController extends \BaseController {

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
		$release_id = Input::get('release');

		if (!empty($release_id)) {
			$tracks = Track::where('track_release_id', $release_id)->orderBy('track_disc_num')->orderBy('track_track_num')->get();
		} else {
			$tracks = Track::orderBy('track_release_id')->orderBy('track_disc_num')->orderBy('track_track_num')->get();
		}
		$tracks->load('release', 'song');

		$method_variables = array(
			'tracks' => $tracks,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('track.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$track = new Track;

		$release_id = Input::get('release');

		if (!empty($release_id)) {
			$release = Release::find($release_id);
			$track->release = $release;
			$track->track_release_id = $release->release_id;
			$track->track_album_id = $release->release_album_id;
			$last_disc_num = Track::where('track_release_id', $release_id)->max('track_disc_num');
			if (empty($last_disc_num)) {
				$last_disc_num = 1;
			}

			$track->track_disc_num = $last_disc_num;

			$last_track_num = Track::where('track_release_id', '=', $release_id)->max('track_track_num');
			if (empty($last_track_num)) {
				$last_track_num = 1;
			}

			$track->track_track_num = $last_track_num + 1;

		}


		$songs = $this->build_song_options($track);

		$recordings = $this->build_recording_options($track);

		$releases = $this->build_release_options($track);

		$method_variables = array(
			'track' => $track,
			'songs' => $songs,
			'recordings' => $recordings,
			'releases' => $releases,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('track.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$track = new Track;

		$fields = $track->getFillable();

		foreach ($fields as $field) {
			$track->{$field} = Input::get($field);
		}

		$result = $track->save();

		if ($result !== false) {
			return Redirect::route('track.show', array('id' => $track->track_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('release.show', array('id' => $track->track_release_id))->with('error', 'Your changes were not saved.');
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
			'track' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('track.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$releases = $this->build_release_options($id);

		$artists = Artist::orderBy('artist_last_name')->get()->lists('artist_display_name', 'artist_id');
		$artists = array(0 => '&nbsp;') + $artists;

		$method_variables = array(
			'track' => $id,
			'releases' => $releases,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('track.edit', $data);
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
			return Redirect::route('track.show', array('id' => $id->track_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('release.show', array('id' => $id->track_release_id))->with('error', 'Your changes were not saved.');
		}
	}


	public function delete($id) {

		$method_variables = array(
			'track' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('track.delete', $data);
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
		$track_song_title = $id->track_song_title;
		$release_id = $id->track_release_id;

		if ($confirm === true) {
			// Remove ecommerce.
			$id->ecommerce()->delete();

			// Remove track.
			$id->delete();
			return Redirect::route('release.show', array('id' => $id->track_release_id  ))->with('message', $track_song_title . ' was deleted.');
		} else {
			return Redirect::route('track.show', array('id' => $id->track_id))->with('error', $track_song_title . ' was not deleted.');
		}
	}

	public function save_order() {
		$tracks = Input::get('tracks');

		$is_success = true;
		if (count($tracks) > 0) {
			foreach ($tracks as $track) {
				if (false === $this->_update_track($track['track_id'], $track)) {
					$is_success = false;
					$error = 'Track order was not saved. Check disc ' . $track['track_disc_num'] . ', track ' . $track['track_track_num'] . '.';
					break;
				}
			}
		}

		echo ($is_success == true) ? 'Track order has been saved.' : $error;
	}

	private function _update_track($track_id, $input) {
		$track = Track::find($track_id);

		$track->track_disc_num = $input['track_disc_num'];
		$track->track_track_num = $input['track_track_num'];

		return $track->save();
	}

	private function build_release_options($track) {

		if (!empty($track->release->release_album_id)) {
			$release_titles = Release::with('album')->where('release_album_id', $track->release->release_album_id)->orderBy('release_catalog_num')->get();
		} else {
			$release_titles = Release::with('album')->orderBy('release_catalog_num')->get();
		}

		$releases = $release_titles->lists('release_catalog_num', 'release_id');
		foreach ($releases as $r => $release) {
			$releases[$r] = empty($release) ? 'Catalog no. not set' : $release;
			$releases[$r] .= ' (' . $release_titles->find($r)->album->album_title . ')';
		}

		$releases = array(0 => '&nbsp;') + $releases;
		return $releases;
	}

}
