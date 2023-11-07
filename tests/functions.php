<?php

declare(strict_types=1);

use Examples\NormalClass;

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
