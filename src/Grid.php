<?php

namespace Esports\Grido;

use Grido\Grid as BaseGrid;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class Grid extends BaseGrid {

	/**
	 * @var string
	 */
	protected $templateFileName;

	/**
	 * @param PropertyAccessorInterface $propertyAccessor
	 * @return Grid
	 */
	public function setPropertyAccessor(PropertyAccessorInterface $propertyAccessor) {
		$this->propertyAccessor = $propertyAccessor;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getProperty($object, $name) {
		$propertyAccessor = $this->getPropertyAccessor();

		if ($propertyAccessor instanceof EntityArrayAccessor) {
			return $propertyAccessor->getValue($object, $name);
		}

		return parent::getProperty($object, $name);
	}

	/**
	 * Nastavi cestu k sablone
	 * @param type $templateFileName
	 * @return Grid
	 */
	function setTemplateFileName($templateFileName) {
		$this->templateFileName = $templateFileName;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function setRememberState($state = TRUE, $sectionName = NULL) {
		$this->rememberState = (bool) $state;
		$this->rememberStateSectionName = $sectionName;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getRememberSession($forceStart = FALSE) {
		return parent::getRememberSession(FALSE);
	}

	/**
	 * @inheritdoc
	 */
	public function createTemplate($class = NULL) {
		$template = parent::createTemplate($class);

		if ($this->templateFileName) {
			$template->setFile($this->templateFileName);
		}

		return $template;
	}

}
