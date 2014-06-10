<?php

class PersonnelController extends \BaseController {

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
		$artist_id = Input::get('artist');

		if (!empty($artist_id)) {
			$members = Personnel::where('member_parent_id', $artist_id)->orderBy('member_last_name')->get();
		} else {
			$members = Personnel::orderBy('member_last_name')->get();
		}

		$method_variables = array(
			'members' => $members,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('personnel.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$member = new Personnel;

		$band_id = Input::get('artist');

		if (!empty($band_id)) {
			$member->member_parent_id = $band_id;
			$member->band = Artist::find($band_id);
		}

		$artists = Artist::orderBy('artist_last_name')->get()->lists('artist_display_name', 'artist_id');
		$artists = array(0 => '&nbsp;') + $artists;

		$method_variables = array(
			'member' => $member,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('personnel.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$member = new Personnel;

		$fields = $member->getFillable();

		foreach ($fields as $field) {
			$member->{$field} = Input::get($field);
		}

		$result = $member->save();

		if ($result !== false) {
			return Redirect::route('personnel.show', array('id' => $member->member_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', array('id' => $member->member_parent_id))->with('error', 'Your changes were not saved.');
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
			'member' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('personnel.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$artists = Artist::orderBy('artist_last_name')->get()->lists('artist_display_name', 'artist_id');
		$artists = array(0 => '&nbsp;') + $artists;

		$method_variables = array(
			'member' => $id,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('personnel.edit', $data);
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
			return Redirect::route('personnel.show', array('id' => $id->member_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', array('id' => $id->band->artist_id))->with('error', 'Your changes were not saved.');
		}
	}


	public function delete($id) {

		$method_variables = array(
			'member' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('personnel.delete', $data);
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
		$member_display_name = $id->member_display_name;

		if ($confirm === true) {
			// Remove artist.
			$artist_id = $id->band->artist_id;
			$id->delete();

			return Redirect::route('artist.show', array( 'id' => $artist_id ))->with('message', $member_display_name . ' was deleted.');
		} else {
			return Redirect::route('personnel.show', array('id' => $id->member_id))->with('error', $member_display_name . ' was not deleted.');
		}
	}


	public function save_order() {
		$members = Input::get('members');

		$is_success = true;
		if (count($members) > 0) {
			foreach ($members as $member) {
				if (false === $this->_update_member($member['member_id'], $member)) {
					$is_success = false;
					$error = 'Member order was not saved.';
					break;
				}
			}
		}

		echo ($is_success == true) ? 'Member order has been saved.' : $error;
	}

	private function _update_member($member_id, $input) {
		$member = Personnel::find($member_id);

		$member->member_order = $input['member_order'];

		return $member->save();
	}

}
