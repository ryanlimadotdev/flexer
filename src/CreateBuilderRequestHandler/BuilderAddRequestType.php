<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

enum BuilderAddRequestType
{
    case MethodCallArray;
    case Builder;
    case Instance;
    case FunctionName;
    case Callable;
}
