<?php

namespace Esports\Grido;

class CustomDataSource extends WrappedDataSource
{
	
	/**
	 * @var DataConverter
	 */
	private $dataConverter;

	public function __construct(\Grido\DataSources\IDataSource $dataSource, DataConverter $dataConverter)
	{
		parent::__construct($dataSource);
		$this->dataConverter = $dataConverter;
	}

	public function getData()
	{
		$data = parent::getData();
		return $this->dataConverter->convert($data);
	}	
	
}
