<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

use Flexer\Container;

$container = new Container();

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
    Container::class . '::get [line: '. currentLine() .'] => Assert tha a instance of id could be resolved',
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
