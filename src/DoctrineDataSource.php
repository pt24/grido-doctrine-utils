<?php

namespace Esports\Grido;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Grido\DataSources\Doctrine;

class DoctrineDataSource extends Doctrine
{

	/**
	 * @var int
	 */
	private $hydratationMode = AbstractQuery::HYDRATE_SCALAR;

	public function getQuery()
	{
		return parent::getQuery()
				->setHydrationMode($this->hydratationMode);
	}

	/**
	 * @inheritdoc
	 */
	public function getData()
	{
		$usePaginator = $this->qb->getMaxResults() !== NULL || $this->qb->getFirstResult() !== NULL;
		$query = $this->getQuery();

		if ($usePaginator) {
			$paginator = new Paginator($query);
			return iterator_to_array($paginator);
		}

		return $query->getResult($query->getHydrationMode());
	}

	function setHydratationMode($hydratationMode)
	{
		$this->hydratationMode = $hydratationMode;
	}
}
