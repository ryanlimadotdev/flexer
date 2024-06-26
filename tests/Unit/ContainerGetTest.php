<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';

use Flexer\Container;
use Test\Sample\FactoryMethodClass;
use Test\Sample\NLevelDependency;
use Test\Sample\NormalClass;
use Test\Sample\OptionalConstructor;
use Test\Sample\SimpleDependency;

$container = new Container();

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that closure builder could be resolved',
    function () {
        $container = new Container([NormalClass::class => fn () => new NormalClass('Ryan', 'Lima')]);
        expect($container->get(NormalClass::class))->toBeInstanceOf(NormalClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that function name builder could be resolved',
    function () {
        $container = new Container([NormalClass::class => 'getNormalClass']);
        expect($container->get(NormalClass::class))->toBeInstanceOf(NormalClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that Class Clojure Object name builder could be resolved',
    function () {
        $container = new Container([NormalClass::class => NormalClass::create(...)]);
        expect($container->get(NormalClass::class))->toBeInstanceOf(NormalClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert tha a instance of id could be resolved',
    function () use ($container) {
        $container->add(NormalClass::class, new NormalClass('Ryan', 'Lima'));
        $result = $container->get(NormalClass::class);
        expect($result)->toBeInstanceOf(NormalClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Test if fully optional constructor is replaced by the the custom build result',
    function () {
        $container = new Container([OptionalConstructor::class => fn () => new OptionalConstructor('Ryan', 'Lima')]);
        $optional = $container->get(OptionalConstructor::class);

        expect([$optional->name, $optional->lastname])->toBe(['Ryan', 'Lima']);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Try to resolve a first level dependency injection',
    function () {
        $container = new Container();
        $simpleDependency = $container->get(Test\Sample\DependencyOfEmptyClass::class);

        expect($simpleDependency)->toBeInstanceOf(Test\Sample\DependencyOfEmptyClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Try to resolve dependency for a non defined definition',
    function () {
        $container = new Container();
        $container->add(NormalClass::class, fn () => new NormalClass('Ryan', 'Lima'));
        $simpleDependency = $container->get(SimpleDependency::class);

        expect($simpleDependency)->toBeInstanceOf(SimpleDependency::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Try to resolve a N level dependency',
    function () {
        $container = new Container();
        $container->add(NormalClass::class, fn() => new NormalClass('Ryan', 'Lima'));
        $simpleDependency = $container->get(NLevelDependency::class);

        expect($simpleDependency)->toBeInstanceOf(NLevelDependency::class);
    }
);
it(
	Container::class . '::get [line: '. currentLine() .'] => Try to resolve a N lvel dependency',
	function () {
		$container = new Container();
		$container->add(FactoryMethodClass::class, [FactoryMethodClass::class, 'create']);
		$return = $container->get(FactoryMethodClass::class);
		expect($return)->toBeInstanceOf(FactoryMethodClass::class);
	}
);