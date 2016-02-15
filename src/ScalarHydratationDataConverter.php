<?php

namespace Esports\Grido;

class FromScalarHydratationDataConverter implements DataConverter
{
	
	/**
	 * @var array
	 */
	private $configuration;

	function __construct($configuration)
	{
		$this->configuration = $configuration;
	}
	
	public function convert(array $data)
	{
		return array_map(function ($row) {
			$converted = [];
			
			foreach ($this->configuration as $originalKey => $convertedKey) {
				$converted[$convertedKey] = $row[$originalKey];
			}
			
			return $converted;
		}, $data);
	}
}
