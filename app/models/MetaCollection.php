<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 6/7/14
 * Time: 9:21 AM
 */

class MetaCollection extends \Illuminate\Database\Eloquent\Collection {

	public function __construct($models) {
		parent::__construct($models);
	}

	public function getMeta($name) {
		return $this->filter(function ($meta) use ($name) {
			if ($meta->meta_field_name == $name) {
				return $meta;
			}
		})->first();
	}

	public function setMeta($name, $value) {
		foreach ($this->items as $i => $item) {
			if ($item->meta_field_name == $name) {
				$this->items[$i]->meta_field_value = $value;
			}
		}
	}

	public function save() {
		$is_success = true;
		$this->each(function ($meta) use (&$is_success) {
			$result = $meta->save();

			// All settings must save successfully, so we change the flag on the first failure.
			if ($result === false) {
				$is_success = false;
			}
		});
		return $is_success;
	}

	public function __get($name) {
		$meta = $this->getMeta($name);
		return (!empty($meta->meta_field_value)) ? $meta->meta_field_value : null;
	}

	public function __set($name, $value) {
		$this->setMeta($name, $value);
	}
}