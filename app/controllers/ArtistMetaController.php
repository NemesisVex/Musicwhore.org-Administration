<?php

class ArtistMetaController extends \BaseController {

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
		//
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
	public function store($id)
	{
		$fields = Input::all();

		$result = true;

		foreach ($fields as $field => $value) {
			$meta_item = new ArtistMeta;
			if ($field != '_method' && $field != '_token') {
				$meta_item->meta_artist_id = $id;
				$meta_item->meta_field_name = $field;
				$meta_item->meta_field_value = $value;

				$save_result = $meta_item->save();

				if ($save_result === false) {
					$result = false;
				}
			}
		}

		if ($result !== false) {
			return Redirect::route('artist.show', array('id' => $id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', array('id' => $id))->with('error', 'Your changes were not saved.');
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
		$artist = Artist::find($id);

		$method_variables = array(
			'artist' => $artist,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.meta.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$meta = ArtistMeta::where('meta_artist_id', $id)->get();

		if ($meta->count() == 0) {
			return $this->store($id);
		}

		$fields = Input::all();

		foreach ($fields as $field => $value) {
			if ($field != '_method' && $field != '_token') {
				$meta->{$field} = $value;
			}
		}

		$result = $meta->save();

		if ($result !== false) {
			return Redirect::route('artist.show', array('id' => $id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', array('id' => $id))->with('error', 'Your changes were not saved.');
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
