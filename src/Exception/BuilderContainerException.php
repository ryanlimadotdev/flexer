<?php

declare(strict_types=1);

namespace Flexer\Exception;

use Exception;

class BuilderContainerException extends Exception
{
	public const TRYING_TO_ADD_A_NON_BUILDER_INSTANCE =
		'Cannot bind undefined object property';
	public const TRYING_TO_ADD_A_NON_BUILDER_INSTANCE_CODE = 0;

	public const TRYING_TO_USE_A_NON_STRING_AS_OFFSET =
		'Cannot bind undefined object property';
	public const TRYING_TO_USE_A_NON_STRING_AS_OFFSET_CODE = 1;
}
