<?php

declare(strict_types=1);

namespace Flexer\Exception;

use Psr\Container\ContainerExceptionInterface;

class ContainerException extends \Exception implements ContainerExceptionInterface
{
	public const FORBIDDEN_DEFINITION_OFFSET =
		'The provided offset could not be used as $id as a container entry identifier: ';
	public const FORBIDDEN_DEFINITION_OFFSET_CODE = 0;
	public const TRYING_BIND_UNDEFINED_ENTRY =
		'You cannot bind a entry that are not solvable';
	public const TRYING_BIND_UNDEFINED_ENTRY_CODE = 1;
	public const TRYING_TO_SET_AS_SHARED_UNDEFINED_ENTRY =
		'You cannot set an undefined entry as shared';
	public const TRYING_TO_SET_AS_SHARED_UNDEFINED_ENTRY_CODE = 0;
}
