<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/6/14
 * Time: 10:09 AM
 */

class TrackMeta extends Eloquent {

	protected $table = 'mw_albums_tracks_meta';
	protected $primaryKey = 'meta_id';
	protected $softDelete = true;
	protected $fillable = array(
		'meta_track_id',
		'meta_field_name',
		'meta_field_value',
	);
	protected $guarded = array(
		'meta_id',
	);

}