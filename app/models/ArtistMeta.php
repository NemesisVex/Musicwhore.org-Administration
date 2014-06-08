<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/6/14
 * Time: 10:09 AM
 */

class ArtistMeta extends BaseMeta {

	protected $table = 'mw_artists_meta';
	protected $foreignMetaKey = 'meta_artist_id';

	public function __construct() {
		$this->fillable[] = 'meta_artist_id';
	}

}