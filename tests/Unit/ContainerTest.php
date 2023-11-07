<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

use Ryanl\MyDi\Container;
use Ryanl\MyDi\Exception\ContainerException;

$container = new Container();
it(
    Container::class . '::__construct [line: '. currentLine() .'] => Create container without providing parameters.',
    function () {
        $container = new Container();
    }
)->throwsNoExceptions();

it(
    Container::class . '::__construct [line: '. currentLine() .'] => Create container providing array of builders.',
    function () {
        $container = new Container([
            DateTime::class => fn() => new DateTime(),
        ]);
    }
)->throwsNoExceptions();

it(Container::class .'::has [line: '. currentLine() .'] => Test true.', function () {

    $container = new Container([
        DateTime::class => fn() => new DateTime(),
    ]);

    $result = $container->has(\DateTime::class);

    expect($result)->toBe(true);
});

it(Container::class .'::has [line: '. currentLine() .'] => Test false.', function () {

    $container = new Container();

    $result = $container->has(\PDO::class);

    expect($result)->toBe(false);
});

it(
    Container::class . '::has [line: '. currentLine() .'] => Test if null constructor could be resolved w- a callable.',
    function () use ($container) {
        expect($container->has(\Examples\WithoutConstructor::class))->toBe(true);
    }
);

it(
    Container::class . '::has [line: '. currentLine() .'] => Empty constructor must have has true.',
    function () use ($container) {
        expect($container->has(\Examples\EmptyConstructor::class))->toBe(true);
    }
);

it(
    Container::class . '::has [line: '. currentLine() .'] => Optional constructor must have has true.',
    function () use ($container) {
        expect($container->has(\Examples\OptionalConstructor::class))->toBe(true);
    }
);

it(
    Container::class . '::add [line: '. currentLine() .'] => Assert that closure could be used as builder',
    function () use ($container) {
        $container->add([\Examples\EmptyClass::class => fn () => new \Examples\EmptyClass()]);
        $container->add(\Examples\EmptyClass::class, fn () => new \Examples\EmptyClass());
    }
)->throwsNoExceptions();

it(
    Container::class . '::add [line: '. currentLine() .'] => Assert that function name could be used as builder',
    function () use ($container) {
        $container->add([\Examples\EmptyClass::class => 'getNormalClass']);
        $container->add(\Examples\EmptyClass::class, 'emptyClassFactory');
    }
)->throwsNoExceptions();

it(
    Container::class . '::add [line: '. currentLine() .'] => Assert that Class Closure Object is allowed as builder builder',
    function () use ($container) {
        $container->add([\Examples\FactoryMethodClass::class => \Examples\FactoryMethodClass::create(...)]);
        $container->add(\Examples\FactoryMethodClass::class, \Examples\FactoryMethodClass::create(...));
    }
)->throwsNoExceptions();

it(
    Container::class . '::add [line: '. currentLine() .'] => Assert that when using a non string offset in array as add parameter throws.',
    function () use ($container) {
         $container->add([0 => fn () => new \Examples\EmptyClass()]);
    }
)->throws(ContainerException::class);

it(
    Container::class . '::add [line: '. currentLine() .'] => Assert tha a instance of id could be used as definition',
    function () use ($container) {
        $container->add(\Examples\NormalClass::class, new \Examples\NormalClass('Ryan', 'Lima'));
    }
)->throwsNoExceptions();

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that object without constructor is returned on get.',
    function () use ($container) {
        expect($container->get(\Examples\WithoutConstructor::class))->toBeInstanceOf(\Examples\WithoutConstructor::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that object with empty constructor is returned on get.',
    function () use ($container) {
        expect($container->get(\Examples\EmptyConstructor::class))->toBeInstanceOf(\Examples\EmptyConstructor::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that object with optional constructor is returned on get.',
    function () use ($container) {
        expect($container->get(\Examples\OptionalConstructor::class))->toBeInstanceOf(\Examples\OptionalConstructor::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that closure builder could be resolved',
    function () {
        $container = new Container([\Examples\NormalClass::class => fn () => new \Examples\NormalClass('Ryan', 'Lima')]);
        expect($container->get(\Examples\NormalClass::class))->toBeInstanceOf(\Examples\NormalClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that function name builder could be resolved',
    function () {
        $container = new Container([\Examples\NormalClass::class => 'getNormalClass']);
        expect($container->get(\Examples\NormalClass::class))->toBeInstanceOf(\Examples\NormalClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Assert that Class Clojure Object name builder could be resolved',
    function () {
        $container = new Container([\Examples\NormalClass::class => \Examples\NormalClass::create(...)]);
        expect($container->get(\Examples\NormalClass::class))->toBeInstanceOf(\Examples\NormalClass::class);
    }
);

it(
    Container::class . '::add [line: '. currentLine() .'] => Assert tha a instance of id could be resolved',
    function () use ($container) {
        $container->add(\Examples\NormalClass::class, new \Examples\NormalClass('Ryan', 'Lima'));
        $result = $container->get(\Examples\NormalClass::class);
        expect($result)->toBeInstanceOf(\Examples\NormalClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Test if fully optional constructor is replaced by the the custom build result',
    function () {
        $container = new Container([\Examples\OptionalConstructor::class => fn () => new \Examples\OptionalConstructor('Ryan', 'Lima')]);
        $optional = $container->get(\Examples\OptionalConstructor::class);

        expect([$optional->name, $optional->lastname])->toBe(['Ryan', 'Lima']);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Try to resolve a first level dependency injection',
    function () {
        $container = new Container();
        $simpleDependency = $container->get(\Examples\DependencyOfEmptyClass::class);

        expect($simpleDependency)->toBeInstanceOf(\Examples\DependencyOfEmptyClass::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Try to resolve dependency for a non defined definition',
    function () {
        $container = new Container();
        $container->add(\Examples\NormalClass::class, fn () => new \Examples\NormalClass('Ryan', 'Lima'));
        $simpleDependency = $container->get(\Examples\SimpleDependency::class);

        expect($simpleDependency)->toBeInstanceOf(\Examples\SimpleDependency::class);
    }
);

it(
    Container::class . '::get [line: '. currentLine() .'] => Try to resolve a N level dependency',
    function () {
        $container = new Container();
        $container->add(\Examples\NormalClass::class, fn() => new \Examples\NormalClass('Ryan', 'Lima'));
        $simpleDependency = $container->get(\Examples\NLevelDependency::class);

        expect($simpleDependency)->toBeInstanceOf(\Examples\NLevelDependency::class);
    }
);

it(
    Container::class . '::bind [line: '. currentLine() .'] => Assert that bind properties could be resolved',
	function () use ($container) {
		$container->add(\Examples\OptionalConstructor::class, fn() => new \Examples\OptionalConstructor())
			->bind(\Examples\OptionalConstructor::class, name: 'New name', lastname: 'New lastname');
		/** @var \Examples\OptionalConstructor $result*/
		$result = $container->get(\Examples\OptionalConstructor::class);
		expect([$result->name, $result->lastname])->toBe(['New name', 'New lastname']);
	}
);
