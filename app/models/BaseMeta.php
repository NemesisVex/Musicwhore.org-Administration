<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 6/7/14
 * Time: 3:45 PM
 */

class BaseMeta extends Eloquent {

	protected $primaryKey = 'meta_id';
	protected $foreignMetaKey;
	protected $softDelete = true;
	protected $fillable = array(
		'meta_field_name',
		'meta_field_value',
	);
	protected $guarded = array(
		'meta_id',
	);
	protected $appends = array(
		'setting',
	);

	public function newCollection(array $models = Array()) {
		return new MetaCollection($models);
	}

	public function getSettingAttribute() {
		return array(
			$this->meta_field_name => $this->meta_field_value,
		);
	}

	public function getForeignMetaKey() {
		return $this->foreignMetaKey;
	}
}