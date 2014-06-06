<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/6/14
 * Time: 10:13 AM
 */

class ArtistPersonnel extends Eloquent {

	protected $table = 'mw_artists_personnel';
	protected $primaryKey = 'member_id';
	protected $softDelete = true;
	protected $fillable = array(
		'member_parent_id',
		'member_artist_id',
		'member_order',
		'member_last_name',
		'member_first_name',
		'member_display_name',
		'member_instruments',
	);
	protected $guarded = array(
		'member_id',
	);

	public function band() {
		return $this->belongsTo('Artist', 'member_parent_id', 'artist_id');
	}

	public function _artist() {
		return $this->hasOne('Artist', 'member_artist_id', 'artist_id');
	}

}