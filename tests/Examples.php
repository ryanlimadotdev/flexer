<?php

/**
 * This file provides classes for the lib tests
 * */

declare(strict_types=1);

namespace Examples {

	class DependencyOfEmptyClass
	{
		public function __construct(
			private EmptyClass $emptyClass,
		) {
		}
	}

	class EmptyClass
	{
	}

	class EmptyConstructor
	{
		public function __construct()
		{
		}
	}

	class FactoryMethodClass
	{
		public static function create(): FactoryMethodClass
		{
			return new FactoryMethodClass();
		}
	}

	class NLevelDependency
	{
		public function __construct(
			private SimpleDependency $dependency,
		) {
		}
	}

	class NormalClass
	{
		public function __construct(
			public string $name,
			public string $lastname,
		) {
		}

		public static function create()
		{
			return new NormalClass('Ryan', 'Lima');
		}
	}

	class OptionalConstructor
	{
		public string $name;
		public string $lastname;
		public function __construct(
			$name = 'Jessie',
			$lastname = 'James',
		) {
			$this->name = $name;
			$this->lastname = $lastname;
		}
	}

	class SimpleDependency
	{
		public function __construct(
			private NormalClass $dependency,
		) {
		}
	}

	class WithoutConstructor
	{
		private string $string;
		private \DateTime $dateTime;
    }
}
