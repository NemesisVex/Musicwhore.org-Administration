<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/10/14
 * Time: 8:58 AM
 */

class Personnel extends Eloquent {

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
		'artist_id',
	);

	public function band() {
		return $this->belongsTo('Artist', 'member_parent_id', 'artist_id');
	}

	public function artist() {
		return $this->hasOne('Artist', 'artist_id', 'member_artist_id');
	}

	public function getMemberDisplayNameAttribute() {
		if (empty($this->attributes['member_display_name'])) {
			if (empty($this->attributes['member_first_name'])) {
				return (!empty($this->attributes['member_last_name'])) ? $this->attributes['member_last_name'] : null;
			} else {
				return $this->attributes['member_first_name'] . ' ' . $this->attributes['member_last_name'];
			}
		} else {
			return (!empty($this->attributes['member_display_name'])) ? $this->attributes['member_display_name'] : null;
		}
	}
}