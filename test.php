<?php

// FIXTURES

namespace {
    use Jeremeamia\Phacture\Factory\OptionsFactoryInterface as OFI;
    require file_exists($file = './vendor/autoload.php') ? $file : die('You need to do a Composer install first.');
    class Old_Foo_Bar_Lib {}
    class Old_Foo_Bar_Lib_Factory implements OFI {public function create($options = []) {
        $instance = new Old_Foo_Bar_Lib;
        $instance->message = $options['message'];
        return $instance;
    }}
    class SpecificClassFactory implements Jeremeamia\Phacture\Factory\OptionsFactoryInterface
    {
        public function create($options = []) {
            $fqcn = $this->determineFcqn($options);
            if (!$fqcn) throw new Jeremeamia\Phacture\Factory\FactoryException('Could not do it!');
            return new $fqcn;
        }
        public function canCreate($options = []) {
            return (bool) $this->determineFcqn($options);
        }
        protected function determineFcqn(array $options) {
            $options = (new Jeremeamia\Phacture\Resolver\RequiredOptionsResolver)
                ->setRequiredKeys(array('vendor', 'package', 'class'))
                ->resolveOptions($options);
            $fqcn = implode('\\', $options);
            return class_exists($fqcn) ? $fqcn : null;
        }
    }
}

namespace Foo\Bar\Objects {
    class Foo {}
    class Bar {}
}

namespace Foo\Bar\MoarObjects {
    class Baz {}
    class PriorityTest {public $num = 1;}
}

namespace The\Specific {
    class ClassName {}
}

// TEST CODE

namespace {
    use Jeremeamia\Phacture\FactoryDecorator\FlyweightFactoryDecorator;
    use Jeremeamia\Phacture\Factory\CallbackFactory;
    use Jeremeamia\Phacture\Factory\ClassMapFactory;
    use Jeremeamia\Phacture\Factory\CompositeFactory;
    use Jeremeamia\Phacture\Factory\NamespaceFactory;
    use Jeremeamia\Phacture\Instantiator\FactoryMapInstantiator;

    // Create factory instances
    $namespaceFactory = (new NamespaceFactory)
        ->addNamespace('Foo\\Bar\\Objects')
        ->addNamespace('Foo\\Bar\\MoarObjects');
    $classMapFactory = (new ClassMapFactory)
        ->addClass('fooBarLib', 'Old_Foo_Bar_Lib')
        ->setInstantiator((new FactoryMapInstantiator)->addFactory('Old_Foo_Bar_Lib', 'Old_Foo_Bar_Lib_Factory'));
    $callbackFactory = (new CallbackFactory)
        ->addCallback('fooBarObj', function () {
            $object = new stdClass;
            $object->foo = 'bar';
            return $object;
        })
        ->addCallback('priorityTest', function () {
            $test = new Foo\Bar\MoarObjects\PriorityTest;
            $test->num = 2;
            return $test;
        });
    $compositeFactory = (new CompositeFactory)
        ->addFactory($namespaceFactory)
        ->addFactory($classMapFactory)
        ->addFactory($callbackFactory, 10);
    $flyweightFactory = new FlyweightFactoryDecorator($compositeFactory);

    // Test the flyweight
    $obj1 = $flyweightFactory->create('fooBarLib', ['message' => 'HELLO_FROM_FACTORY']);
    $obj2 = $flyweightFactory->create('fooBarLib', ['message' => 'HELLO_FROM_FACTORY']);
    assert('$obj1 instanceof Old_Foo_Bar_Lib');
    assert('$obj1 === $obj2');
    assert('$obj1->message === "HELLO_FROM_FACTORY"');

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

    // Test the specific class factory
    $specificClass = (new SpecificClassFactory)->create([
        'vendor'  => 'The',
        'package' => 'Specific',
        'class'   => 'ClassName',
    ]);
    assert('$specificClass instanceof \The\Specific\ClassName');
}
