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
		// If the property is not in the collection, a flag will let us know.
		$is_updated = false;

		foreach ($this->items as $i => $item) {
			if ($item->meta_field_name == $name) {
				$this->items[$i]->meta_field_value = $value;
				$is_updated = true;
			}
		}

		// If no update occurred, we need to create the setting.
		if ($is_updated === false) {
			$meta_class = get_class($this->items[0]);
			$new_item = new $meta_class;
			$foreign_meta_key = $new_item->getForeignMetaKey();

			$new_item->{$foreign_meta_key} = $this->items[0]->{$foreign_meta_key};
			$new_item->meta_field_name = $name;
			$new_item->meta_field_value = $value;

			$this->add($new_item);
		}
	}

	public function save() {
		$is_success = true;
		foreach ($this->items as $item) {
			$result = $item->save();

			// All settings must save successfully, so we change the flag on the first failure.
			if ($result === false) {
				$is_success = false;
			}
		}
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