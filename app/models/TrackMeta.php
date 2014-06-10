<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/6/14
 * Time: 10:09 AM
 */

class TrackMeta extends BaseMeta {

	protected $table = 'mw_albums_tracks_meta';

	public function __construct() {
		parent::__construct('meta_track_id');
	}

	public function newCollection(array $models = Array()) {
		return new TrackMetaCollection($models);
	}

}