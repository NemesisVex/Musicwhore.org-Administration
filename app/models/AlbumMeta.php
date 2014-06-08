<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/6/14
 * Time: 10:09 AM
 */

class AlbumMeta extends BaseMeta {

	protected $table = 'mw_albums_meta';

	public function __construct() {
		$this->fillable[] = 'meta_album_id';
	}

}