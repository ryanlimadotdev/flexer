<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';

use Flexer\Container;
use Test\Sample\EmptyClass;
use Test\Sample\FactoryMethodClass;
use Test\Sample\NormalClass;

$container = new Container();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert that closure could be used as builder',
	function () use ($container) {
		$container->add([EmptyClass::class => fn () => new EmptyClass()]);
		$container->add(EmptyClass::class, fn () => new EmptyClass());
	}
)->throwsNoExceptions();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert that function name could be used as builder',
	function () use ($container) {
		$container->add([NormalClass::class => 'getNormalClass']);
		$container->add(EmptyClass::class, 'emptyClassFactory');
	}
)->throwsNoExceptions();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert that Class Closure Object is allowed as builder builder',
	function () use ($container) {
		$container->add([FactoryMethodClass::class => FactoryMethodClass::create(...)]);
		$container->add(FactoryMethodClass::class, FactoryMethodClass::create(...));
	}
)->throwsNoExceptions();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert tha a instance of id could be used as definition',
	function () use ($container) {
		$container->add(NormalClass::class, new NormalClass('Ryan', 'Lima'));
	}
)->throwsNoExceptions();
