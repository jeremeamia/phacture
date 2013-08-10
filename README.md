Phacture (PHP + Facture)
========================

**fac·ture** *(noun) \ˈfak-chər\*

1. the act, process, or manner of making anything; construction.
2. the manner in which something, especially a work of art, is made.

Phacture is a PHP library containing a common interface for factory objects and implementations for a few boilerplate
factory scenarios.

By Jeremy Lindblom

Version: **0.1.0-preview**

Example
-------

Given the following related classes that your application may need to instantiate:

```php
namespace SomeVendor\SomeLib {
    class ThingOne {}
    class ThingTwo {}
    class ThingThree {}
}

namespace {
    class AnotherVendor_OldSchoolLib_ThingFour {}
}

namespace YetAnotherVendor\SomeOtherLib {
    class ThingFive {}
}
```

You can use Phacture to compose a factory object that is capable of instantiating all of them.

```php
// Create a fairly complex factory object using the Phacture FactoryBuilder
$factory = (new \Jeremeamia\Phacture\FactoryBuilder)
    ->addNamespace('SomeVendor\SomeLib')
    ->addClass('ThingFour', 'AnotherVendor_OldSchoolLib_Four')
    ->addCallback('ThingFive', function ($identifier) {
        return new YetAnotherVendor\SomeOtherLib\Five;
    })
    ->addIdentifierInflection()
    ->addFlyweightCaching()
    ->build();

$one = $factory->create('thing_one');
echo get_class($one);
//> SomeVendor\SomeLib\One

$two = $factory->create('thing_two');
echo get_class($two);
//> SomeVendor\SomeLib\Two

$three = $factory->create('thing_three');
echo get_class($three);
//> SomeVendor\SomeLib\Three

$four = $factory->create('thing_four');
echo get_class($four);
//> AnotherVendor_OldSchoolLib_Four

$five = $factory->create('thing_five');
echo get_class($five);
//> YetAnotherVendor\SomeOtherLib\Five

$oneAgain = $factory->create('thing_one');
var_dump($one === $oneAgain);
//> bool(true)
```

TODO
----

1. Gather and apply feedback
2. Unit tests
3. Documentation
