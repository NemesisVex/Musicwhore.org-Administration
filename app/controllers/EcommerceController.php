<?php

class EcommerceController extends \BaseController {

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
		$track_id = Input::get('track');

		if (!empty($release_id)) {
			$release = Release::find($release_id);
			$track = new Track;
			$ecommerce = Ecommerce::with('release')->where('ecommerce_release_id', $release_id)->orderBy('ecommerce_release_id')->orderBy('ecommerce_track_id')->orderBy('ecommerce_list_order')->get();
		} elseif (!empty($track_id)) {
			$track = Track::find($track_id);
			$release = $track->release;
			$ecommerce = Ecommerce::with('track')->where('ecommerce_track_id', $track_id)->orderBy('ecommerce_release_id')->orderBy('ecommerce_track_id')->orderBy('ecommerce_list_order')->get();
		} else {
			$release = new Release;
			$track = new Track;
			$ecommerce = Ecommerce::orderBy('ecommerce_release_id')->orderBy('ecommerce_track_id')->orderBy('ecommerce_list_order')->get();
		}

		$method_variables = array(
			'ecommerce' => $ecommerce,
			'release' => $release,
			'track' => $track,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('ecommerce.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$ecommerce = new Ecommerce;

		$release_id = Input::get('release');

		if (!empty($release_id)) {
			$ecommerce->ecommerce_release_id = $release_id;
			$ecommerce->release = Release::find($release_id);

			$link_count = Ecommerce::where('ecommerce_release_id', $release_id)->count();
			$ecommerce->ecommerce_list_order = $link_count + 1;

			$release_list = Release::with('album')->whereHas('album', function ($q) use ($ecommerce) { $q->where('album_artist_id', $ecommerce->release->album->album_artist_id); })->orderBy('release_catalog_num')->get();
		} else {
			$release_list = Release::with('album')->orderBy('release_catalog_num')->get();
		}

		$releases = $release_list->lists('release_catalog_num', 'release_id');
		foreach ($releases as $r => $release_item) {
			$releases[$r] = $release_item . ' (' . $release_list->find($r)->album->album_title . ')';
		}
		$releases = array(0 => '') + $releases;

		$labels = Ecommerce::select('ecommerce_label')->groupBy('ecommerce_label')->orderBy('ecommerce_label')->get();

		$method_variables = array(
			'ecommerce' => $ecommerce,
			'releases' => $releases,
			'labels' => json_encode($labels->lists('ecommerce_label')),
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('ecommerce.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$ecommerce = new Ecommerce;

		$fields = $ecommerce->getFillable();

		foreach ($fields as $field) {
			$ecommerce->{$field} = Input::get($field);
		}

		$result = $ecommerce->save();

		if ($result !== false) {
			return Redirect::route('ecommerce.show', array('id' => $ecommerce->ecommerce_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('release.show', array('id' => $ecommerce->ecommerce_release_id))->with('error', 'Your changes were not saved.');
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
			'ecommerce' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('ecommerce.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$release_list = Release::with('album')->whereHas('album', function ($q) use ($id) { $q->where('album_artist_id', $id->release->album->album_artist_id); })->orderBy('release_catalog_num')->get();
		$releases = $release_list->lists('release_catalog_num', 'release_id');
		foreach ($releases as $r => $release_item) {
			$releases[$r] = $release_item . ' (' . $release_list->find($r)->album->album_title . ')';
		}
		$releases = array(0 => '') + $releases;

		$labels = Ecommerce::select('ecommerce_label')->groupBy('ecommerce_label')->orderBy('ecommerce_label')->get();

		$method_variables = array(
			'ecommerce' => $id,
			'releases' => $releases,
			'labels' => json_encode($labels->lists('ecommerce_label')),
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('ecommerce.edit', $data);
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
			return Redirect::route('ecommerce.show', array('id' => $id->ecommerce_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('release.show', array('id' => $id->ecommerce_release_id))->with('error', 'Your changes were not saved.');
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
			'ecommerce' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('ecommerce.delete', $data);
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
		$ecommerce_label = $id->ecommerce_label;
		$release_id = $id->ecommerce_release_id;

		if ($confirm === true) {
			$id->delete();
			return Redirect::route('release.show', array('id' => $release_id))->with('message', $ecommerce_label . ' was deleted.');
		} else {
			return Redirect::route('ecommerce.show', array('id' => $id->ecommerce_id))->with('error', $ecommerce_label . ' was not deleted.');
		}
	}


	public function save_order() {
		$ecomm_links = Input::get('ecommerce');

		$is_success = true;
		if (count($ecomm_links) > 0) {
			foreach ($ecomm_links as $ecomm_link) {
				if (false === $this->_update_ecommerce($ecomm_link['ecommerce_id'], $ecomm_link)) {
					$is_success = false;
					$error = 'Ecommerce list order was not saved. Check link for ' . $ecomm_link['ecommerce_label'] . ' (' . $ecomm_link['ecommerce_url'] . ').';
					break;
				}
			}
		}

		echo ($is_success == true) ? 'Ecommerce list order has been saved.' : $error;
	}

	private function _update_ecommerce($ecommerce_id, $input) {
		$ecommerce = Ecommerce::find($ecommerce_id);

		$ecommerce->ecommerce_list_order = $input['ecommerce_list_order'];

		return $ecommerce->save();
	}
}
