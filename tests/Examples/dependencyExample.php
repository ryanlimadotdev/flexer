<?php

use Examples\NormalClass;

return [
	NormalClass::class, fn() => new NormalClass::class(),
];
