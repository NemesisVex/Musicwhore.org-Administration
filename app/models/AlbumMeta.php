<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/6/14
 * Time: 10:09 AM
 */

class AlbumMeta extends Eloquent {

	protected $table = 'mw_albums_meta';
	protected $primaryKey = 'meta_id';
	protected $softDelete = true;
	protected $fillable = array(
		'meta_album_id',
		'meta_field_name',
		'meta_field_value',
	);
	protected $guarded = array(
		'meta_id',
	);

}