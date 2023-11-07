<?php

declare(strict_types=1);

namespace Ryanl\MyDi\BuilderMapRequestHandler;

enum BuilderAddRequestType
{
    case MethodCallArray;

    case Builder;
    case Instance;
    case FunctionName;
    case Callable;
}
