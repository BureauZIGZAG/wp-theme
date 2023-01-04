<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

abstract class AcfFieldOptionsBaseClass {
	/** @var mixed */
	private $value;

	protected function __construct($value) {
		$this->value = $value;
	}

	public function get() {
		return $this->value;
	}

	public static function get_all(): array {
		$reflection = new \ReflectionClass(self::class);
		// get public static methods
		$methods = array_filter($reflection->getMethods(), function($method) {
			$isPublic = $method->isPublic();
			$isStatic = $method->isStatic();
			$returnsThis = $method->getReturnType() === 'self';
			$notThisMethod = $method->getName() !== 'get_all';
			return $isPublic && $isStatic && $returnsThis && $notThisMethod;
		});

		// get all values
		$values = [];
		foreach($methods as $method) {
			$value = self::$method()->get();
			// check if string
			if (is_string($value)) {
				$values[$method->getName()] = $value;
			}
		}

		return $values;
	}
}
