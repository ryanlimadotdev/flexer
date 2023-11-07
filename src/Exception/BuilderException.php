<?php

declare(strict_types=1);

namespace Ryanl\MyDi\Exception;

use Exception;

class BuilderException extends Exception
{
	public const TRYING_BIND_UNDEFINED_PROPERTY =
		'Cannot bind undefined object property';
	public const TRYING_BIND_UNDEFINED_PROPERTY_CODE =
		0;
}
