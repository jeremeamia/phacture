<?php

namespace
{
    require file_exists($file = './vendor/autoload.php') ? $file : die('You need to do a Composer install first.');

    class Old_Foo_Bar_Lib {}
}

namespace Foo\Bar\Objects
{
    class Foo {}
    class Bar {}
}

namespace Foo\Bar\MoarObjects
{
    class Baz {}
    class PriorityTest {public $num = 1;}
}

namespace
{
    use Jeremeamia\Phacture\Factory\CallbackFactory;
    use Jeremeamia\Phacture\Factory\ClassMapFactory;
    use Jeremeamia\Phacture\Factory\CompositeFactory;
    use Jeremeamia\Phacture\FactoryDecorator\FlyweightFactoryDecorator;
    use Jeremeamia\Phacture\Factory\NamespaceFactory;

    $namespaceFactory = new NamespaceFactory();
    $namespaceFactory->addNamespace('Foo\\Bar\\Objects');
    $namespaceFactory->addNamespace('Foo\\Bar\\MoarObjects');

    $classMapFactory = new ClassMapFactory();
    $classMapFactory->addClass('fooBarLib', 'Old_Foo_Bar_Lib');

    $callbackFactory = new CallbackFactory();
    $callbackFactory->addCallback('fooBarObj', function () {
        $object = new stdClass;
        $object->foo = 'bar';
        return $object;
    });
    $callbackFactory->addCallback('priorityTest', function () {
        $test = new Foo\Bar\MoarObjects\PriorityTest;
        $test->num = 2;
        return $test;
    });

    $compositeFactory = new CompositeFactory();
    $compositeFactory->addFactory($namespaceFactory)
        ->addFactory($classMapFactory)
        ->addFactory($callbackFactory, 10);

    $flyweightFactory = new FlyweightFactoryDecorator($compositeFactory);

    // Test the flyweight
    $obj1 = $flyweightFactory->create('fooBarLib');
    $obj2 = $flyweightFactory->create('fooBarLib');
    assert('$obj1 instanceof Old_Foo_Bar_Lib');
    assert('$obj1 === $obj2');

    // Test composite behavior and each of the factory types
    $objFoo = $compositeFactory->create('foo');
    assert('$objFoo instanceof \Foo\Bar\Objects\Foo');
    $objBar = $compositeFactory->create('bar');
    assert('$objBar instanceof \Foo\Bar\Objects\Bar');
    $objBaz = $compositeFactory('baz');
    assert('$objBaz instanceof \Foo\Bar\MoarObjects\Baz');
    $objFooBar = $compositeFactory->create('fooBarObj');
    assert('$objFooBar->foo === "bar"');

    // Test that the factory prioritization is correct
    $objTest = $compositeFactory->create('priorityTest');
    assert('$objTest->num === 2');
}
