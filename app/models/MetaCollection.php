<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 6/7/14
 * Time: 9:21 AM
 */

/**
 * Class MetaCollection
 *
 * MetaCollection makes an Eloquent Collection behave like a Model.
 * meta_field_name becomes the property of a "Meta Model", and its
 * properties are dynamically loaded.
 */
class MetaCollection extends \Illuminate\Database\Eloquent\Collection {

	public $metaClassId;
	public $metaClassName;
	public $metaId;

	public function __construct(array $models = Array(), array $metaObject = array()) {
		parent::__construct($models);

		if (!empty($metaObject)) {
			$this->metaClassName = $metaObject['metaClassName'];
			$this->metaClassId = $metaObject['metaClassId'];
			$this->metaId = $metaObject['metaId'];
		}
	}

	public function getMeta($name) {
		return $this->filter(function ($meta) use ($name) {
			if ($meta->meta_field_name == $name) {
				return $meta;
			}
		});
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
			echo '<pre>';
			echo intval( empty($this->metaId) );
			echo intval( empty($this->metaClassId) );
			echo intval( empty($this->metaClassName) );
			echo '</pre>';
			die();
			$new_item = new $this->metaClassName;

			$new_item->{$this->metaClassId} = $this->metaId;
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
		if ($meta->count() > 1) {
			return $meta;
		} else {
			return (!empty($meta->first()->meta_field_value)) ? $meta->first()->meta_field_value : null;
		}
	}

	public function __set($name, $value) {
		$this->setMeta($name, $value);
	}
}