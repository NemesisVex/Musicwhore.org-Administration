<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/6/14
 * Time: 10:09 AM
 */

class ArtistMeta extends BaseMeta {

	protected $table = 'mw_artists_meta';

	public function __construct() {
		parent::__construct('meta_artist_id');
	}

	public function newCollection(array $models = Array()) {
		return new ArtistMetaCollection($models);
	}

}