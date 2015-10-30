<?php

namespace Test;

use Esports\Grido\EntityArrayAccessor;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class PropertyAccessorTest extends Tester\TestCase {

	function setUp() {

	}

	function testFetchValue() {
		$array = [
			'name' => 'John',
			'surname' => 'Connor'
		];

		$accessor = new EntityArrayAccessor;
		Assert::same('John', $accessor->getProperty($array, 'name'));
		Assert::same('Connor', $accessor->getProperty($array, 'surname'));
	}

	function testFetchInnerValue() {
		$array = [
			'name' => 'John',
			'surname' => 'Connor',
			'user' => [
				'email' => 'john@connor.org',
				'account' => [
					'id' => 58
				]
			]
		];

		$accessor = new EntityArrayAccessor;

		Assert::same('John', $accessor->getProperty($array, 'name'));
		Assert::same('Connor', $accessor->getProperty($array, 'surname'));
		Assert::same('john@connor.org', $accessor->getProperty($array, 'user.email'));
		Assert::same(58, $accessor->getProperty($array, 'user.account.id'));
	}

	function testAccessToUndeclaredValue() {
		$array = [
			'name' => 'John',
			'surname' => 'Connor',
			'user' => [
				'id' => 58
			]
		];

		$accessor = new EntityArrayAccessor;

		Assert::throws(function () use ($array, $accessor) {
			$accessor->getProperty($array, 'email');
		}, 'Grido\PropertyAccessors\PropertyAccessorException');

		Assert::throws(function () use ($array, $accessor) {
			$accessor->getProperty($array, 'user.name');
		}, 'Grido\PropertyAccessors\PropertyAccessorException');
	}

	function testFetchOnStdClassValue() {
		$class = new \stdClass;
		$class->name = "John";

		$accessor = new EntityArrayAccessor;

		Assert::throws(function () use ($class, $accessor) {
			$accessor->getProperty($class, 'name');
		}, 'Grido\PropertyAccessors\PropertyAccessorException');
	}

}

$test = new PropertyAccessorTest();
$test->run();
