<?php

declare(strict_types=1);

use Examples\EmptyClass;
use Examples\NormalClass;

require_once __DIR__ . '/Examples.php';

function currentLine(): int
{
	$bt = debug_backtrace();
	$caller = array_shift($bt);
	return $caller['line'];
}

function getNormalClass(): NormalClass
{
	return new NormalClass('Ryan', 'Lima');
}

function emptyClassFactory(): EmptyClass
{
	return new EmptyClass();
}
