<?php

namespace Esports\Grido;

use Grido\DataSources\IDataSource;

class WrappedDataSource implements IDataSource
{

	/**
	 * @var IDataSource
	 */
	private $dataSource;

	public function __construct(IDataSource $dataSource)
	{
		$this->dataSource = $dataSource;
	}

	public function filter(array $condition)
	{
		$this->dataSource->filter($condition);
	}

	public function getCount()
	{
		return $this->dataSource->getCount();
	}

	public function getData()
	{
		return $this->dataSource->getData();
	}

	public function limit($offset, $limit)
	{
		$this->dataSource->limit($offset, $limit);
	}

	public function sort(array $sorting)
	{
		$this->dataSource->sort($sorting);
	}

	public function suggest($column, array $conditions, $limit)
	{
		$this->dataSource->suggest($column, $conditions, $limit);
	}
}
