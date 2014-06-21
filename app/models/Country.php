<?php

/**
 * Country
 *
 * @author Greg Bueno
 */
class Country extends Eloquent {

	protected $table = 'mw_countries';
	protected $primaryKey = 'country_id';
	protected $softDelete = true;
	protected $fillable = array(
		'country_name',
	);
	protected $guarded = array(
		'country_id',
	);

	public function geocodes() {
		return $this->hasMany('Release', 'release_country_name', 'country_name');
	}
}
