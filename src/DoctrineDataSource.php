<?php

namespace Esports\Grido;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Grido\DataSources\Doctrine;

class DoctrineDataSource extends Doctrine {

	public function getQuery() {
		return parent::getQuery()
						->setHydrationMode(AbstractQuery::HYDRATE_ARRAY);
	}

	/**
	 * @inheritdoc
	 */
	public function getData() {
		$usePaginator = $this->qb->getMaxResults() !== NULL || $this->qb->getFirstResult() !== NULL;
		$query = $this->getQuery();

		if ($usePaginator) {
			$paginator = new Paginator($query);
			return iterator_to_array($paginator);
		}

		return $query->getResult($query->getHydrationMode());
	}

}
