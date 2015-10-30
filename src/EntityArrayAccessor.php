<?php

namespace Esports\Grido;

use Grido\PropertyAccessors\IPropertyAccessor;
use Grido\PropertyAccessors\PropertyAccessorException;

/**
 * Accessor pro entity hydratovane jako pole
 */
class EntityArrayAccessor implements IPropertyAccessor {

	/**
	 * @inheritdoc
	 */
	public function getProperty($array, $name) {
		if (!is_array($array)) {
			throw new PropertyAccessorException("Expected array in property accessor!");
		}

		$pos = strpos($name, '.');

		if ($pos !== false) {
			$key = substr($name, 0, $pos);
			$this->assertKey($array, $key);
			return $this->getProperty($array[$key], substr($name, $pos + 1));
		}

		$this->assertKey($array, $name);
		return $array[$name];
	}

	/**
	 * @inheritdoc
	 */
	public function setProperty($object, $name, $value) {
		throw new PropertyAccessorException("Only reading is allowed!");
	}

	/**
	 * @param array $array
	 * @param string $key
	 * @throws PropertyAccessorException
	 */
	private function assertKey(array &$array, $key) {
		if (!array_key_exists($key, $array)) {
			throw new PropertyAccessorException("Cannot get \"$key\" property. Allowed keys are " . implode(', ', array_keys($array)));
		}
	}

}
