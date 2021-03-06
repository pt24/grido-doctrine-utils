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
		Assert::same('John', $accessor->getValue($array, 'name'));
		Assert::same('Connor', $accessor->getValue($array, 'surname'));
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

		Assert::same('John', $accessor->getValue($array, 'name'));
		Assert::same('Connor', $accessor->getValue($array, 'surname'));
		Assert::same('john@connor.org', $accessor->getValue($array, 'user.email'));
		Assert::same(58, $accessor->getValue($array, 'user.account.id'));
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
			$accessor->getValue($array, 'email');
		}, 'Symfony\Component\PropertyAccess\Exception\AccessException');

		Assert::throws(function () use ($array, $accessor) {
			$accessor->getValue($array, 'user.name');
		}, 'Symfony\Component\PropertyAccess\Exception\AccessException');
	}

	function testFetchOnStdClassValue() {
		$class = new \stdClass;
		$class->name = "John";

		$accessor = new EntityArrayAccessor;

		Assert::throws(function () use ($class, $accessor) {
			$accessor->getValue($class, 'name');
		}, 'Symfony\Component\PropertyAccess\Exception\AccessException');
	}

	function testPropertyWithDot() {
		$array = [ 'user.id' => 5];

		$accessor = new EntityArrayAccessor;

		Assert::same(5, $accessor->getValue($array, 'user.id'));
	}

	function testWithDotInner() {
		$array = [
			'user' => [
				'name' => 'John',
				'user.id' => 58
			]
		];

		$accessor = new EntityArrayAccessor;

		Assert::same('John', $accessor->getValue($array, 'user.name'));
		Assert::same(58, $accessor->getValue($array, 'user.user.id'));
	}

	function testWithDotNotUniquePath() {
		$array = [
			'user' => [
				'id' => 7
			],
			'user.id' => 666
		];

		$accessor = new EntityArrayAccessor;

		Assert::same(666, $accessor->getValue($array, 'user.id'));
	}

}

$test = new PropertyAccessorTest();
$test->run();
