<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/10/14
 * Time: 1:45 PM
 */

use \Guzzle\Http\Client;
use \MusicBrainz\Filters\ArtistFilter;
use \MusicBrainz\Filters\RecordingFilter;
use \MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use \MusicBrainz\MusicBrainz;

class MusicbrainzController extends BaseController {

	private $layout_variables = array();

	public function __construct() {
		global $config_url_base;

		$this->layout_variables = array(
			'config_url_base' => $config_url_base,
		);

		$this->beforeFilter('auth');
	}

	public function release_group_lookup($id) {
		$method_variables = array(
			'album' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('musicbrainz.release_group_lookup', $data);
	}

	public function release_group_search() {

		$search = Input::get('musicbrainz-q');

		$brainz = new MusicBrainz( new GuzzleHttpAdapter( new Client() ) );

		try {
			$release_groups = $brainz->search( new RecordingFilter($search) );
			echo json_encode($release_groups);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

} 