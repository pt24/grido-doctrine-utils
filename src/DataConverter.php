<?php

namespace Esports\Grido;

interface DataConverter
{

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data);
}
