<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

use Flexer\Container;

it(
	Container::class .'::has [line: '. currentLine() .'] => Assert that "has" return true for defined entry',
	function () {
		$container = new Container([
			DateTime::class => fn() => new DateTime(),
		]);
		$result = $container->has(\DateTime::class);
		expect($result)->toBe(true);
	}
);

it(
	Container::class .'::has [line: '. currentLine() .'] => Assert that has return false to unknown entry.',
	function () {
		$container = new Container();
		$result = $container->has(\PDO::class);
		expect($result)->toBe(false);
	}
);
