<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:29 PM
 */

class AlbumFormat extends Eloquent {

	protected $table = 'mw_albums_formats';
	protected $primaryKey = 'format_id';
	protected $softDelete = true;

	public function albums() {
		return $this->hasMany('Album', 'album_format_id', 'format_id');
	}

}