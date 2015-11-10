<?php

namespace Esports\Grido;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\Exception\AccessException;

/**
 * Accessor pro entity hydratovane jako pole
 */
class EntityArrayAccessor implements PropertyAccessorInterface {

	public function getValue($objectOrArray, $propertyPath) {
		if (!is_array($objectOrArray)) {
			throw new AccessException("Expected array in property accessor!");
		}

		$pos = strpos($propertyPath, '.');

		if ($pos !== false) {
			$key = substr($propertyPath, 0, $pos);
			$this->assertKey($objectOrArray, $key);
			return $this->getValue($objectOrArray[$key], substr($propertyPath, $pos + 1));
		}

		$this->assertKey($objectOrArray, $propertyPath);
		return $objectOrArray[$propertyPath];
	}

	public function isReadable($objectOrArray, $propertyPath) {
		try {
			$this->getValue($objectOrArray, $propertyPath);
			return true;
		} catch (Exception $ex) {
			return false;
		}
	}

	public function isWritable($objectOrArray, $propertyPath) {
		return false;
	}

	public function setValue(&$objectOrArray, $propertyPath, $value) {
		throw new AccessException("Only reading is allowed!");
	}

	/**
	 * @param array $array
	 * @param string $key
	 * @throws PropertyAccessorException
	 */
	private function assertKey(array &$array, $key) {
		if (!array_key_exists($key, $array)) {
			throw new AccessException("Cannot get \"$key\" property. Allowed keys are " . implode(', ', array_keys($array)));
		}
	}

}
