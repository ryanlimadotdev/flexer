<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

use Flexer\Container;

it(
	Container::class . '::__construct [line: '. currentLine() .'] => Create container without providing parameters.',
	function () {
		$container = new Container();
	}
)->throwsNoExceptions();

it(
	Container::class . '::__construct [line: '. currentLine() .'] => Create container providing array of builders.',
	function () {
		$container = new Container([
			DateTime::class => fn() => new DateTime(),
		]);
	}
)->throwsNoExceptions();
