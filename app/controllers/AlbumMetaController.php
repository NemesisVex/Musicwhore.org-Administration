<?php

class AlbumMetaController extends \BaseController {

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
	 * @param  int  $id ID of album to which the meta data is related
	 * @return Response
	 */
	public function store($id)
	{
		$fields = Input::all();

		$meta_fields = array();
		foreach ($fields as $field => $value) {
			if (($field != '_method' && $field != '_token') && !empty($value)) {
				$meta_field = new AlbumMeta;
				$meta_field->meta_field_name = $field;
				$meta_field->meta_field_value = $value;
				$meta_field->meta_album_id = $id;

				$meta_fields[] = $meta_field;
			}
		}
		$meta = $meta_field->newCollection($meta_fields);

		$result = $meta->save();

		if ($result !== false) {
			return Redirect::route('album.show', array('id' => $id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('album.show', array('id' => $id))->with('error', 'Your changes were not saved.');
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
		$album = Album::find($id);
		$artists = Artist::whereHas('meta', function ($query) { $query->where('meta_field_name', 'is_classical_artist')->where('meta_field_value', 1); })->orderBy('artist_last_name')->get()->lists('artist_display_name', 'artist_id');
		$artists = array(0 => '&nbsp;') + $artists;

		$method_variables = array(
			'album' => $album,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.meta.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$meta = AlbumMeta::where('meta_album_id', $id)->get();

		if ($meta->count() == 0) {
			$this->store($id);
			die();
		}

		$fields = Input::all();

		foreach ($fields as $field => $value) {
			if ($field != '_method' && $field != '_token') {
				$meta->{$field} = $value;
			}
		}

		$result = $meta->save();

		if ($result !== false) {
			return Redirect::route('album.show', array('id' => $id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('album.show', array('id' => $id))->with('error', 'Your changes were not saved.');
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
