<?php

declare(strict_types=1);

namespace Flexer\Exception;

use Exception;

class BuildAddHandlerException extends Exception
{
    public const UNIMPLEMENTED = 'Unimplemented handler.';
    public const UNIMPLEMENTED_CODE = 0;
}
