<?php

declare(strict_types=1);

namespace Flexer\Exception;

use Exception;

class BuilderException extends Exception
{
	public const TRYING_BIND_UNDEFINED_PROPERTY =
		'Cannot bind undefined object property';
	public const TRYING_BIND_UNDEFINED_PROPERTY_CODE =
		0;
	public const TRYING_TO_ASSIGN_A_NON_CALLABLE_TO_BUILDER =
		'Only callables could be assigned to Builders';
	public const TRYING_TO_ASSIGN_A_NON_CALLABLE_TO_BUILDER_CODE =
		1;
}
