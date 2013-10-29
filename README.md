Phacture (PHP + Facture)
========================

> **fac·ture** *(noun) \ˈfak-chər\*
>
> 1. the act, process, or manner of making anything; construction.
> 2. the manner in which something, especially a work of art, is made.

**Phacture** is a PHP library that helps you or your code's consumers to instantiate objects through the factory design
pattern. Phacture has two parts:

1. A common interface for factory objects.
2. Implementations for a few boilerplate factory use cases.

Phacture was created by Jeremy Lindblom. This is version **0.2.0-preview**.

Examples
--------

### 1. Config Reader Factory

Let's say you have a set of objects responsible for reading configuration files in various formats (e.g.,
`MyLib\Config\Reader\XmlConfigReader`, `MyLib\Config\Reader\JsonConfigReader`, and
`MyLib\Config\Reader\YamlConfigReader`). Instead of writing and testing your own factory class code to instantiate these
*ConfigReader* classes, you can use the factory classes provided by Phacture to compose a factory object with the
behavior you need.

    use Jeremeamia\Phacture\Factory\ClassFactory;
    use Jeremeamia\Phacture\FactoryDecorator\NameTransformerDecorator;

    $configReaderFactory = new NameTransformerDecorator(new ClassFactory, function ($name) {
        return 'MyLib\\Config\\Reader\\' . ucfirst($name) . 'ConfigReader';
    });

    $configReader = $configReaderFactory->create('xml');  #> MyLib\Config\Reader\XmlConfigReader
    $configReader = $configReaderFactory->create('json'); #> MyLib\Config\Reader\JsonConfigReader
    $configReader = $configReaderFactory->create('yaml'); #> MyLib\Config\Reader\YamlConfigReader

### 2. Database Adapter Factory

You could do something similar if you had a set of database adapters.

    use Jeremeamia\Phacture\Factory\NamespaceFactory;
    use Jeremeamia\Phacture\FactoryDecorator\InflectionDecorator;
    use Jeremeamia\Phacture\FactoryDecorator\RequiredOptionsDecorator;

    $dbFactory = new NamespaceFactory('MyLib\Db\Adapter');
    $dbFactory->setSuffix('Adapter');
    $dbFactory = new InflectionDecorator($dbFactory);
    $dbFactory = new RequiredOptionsDecorator($dbFactory);
    $dbFactory->setRequiredKeys(array('db_host', 'db_user', 'db_pass', 'db_name'));

    $db = $dbFactory->create('mysql', array(
        'db_host' => 'localhost',
        'db_user' => 'admin',
        'db_pass' => 'Ch@ng3M3!',
        'db_name' => 'test',
    ));

### 3. Database Adapter Pooling via `FlyweightDecorator`

The factory decorator system allows you to modify and add to the behavior of the factory. For example, we could add the
`FlyweightDecorator` to the previous example to create a kind of database connection pooling.

    use Jeremeamia\Phacture\FactoryDecorator\FlyweightDecorator;

    $dbFactory = new FlyweightDecorator($dbFactory, function ($name, $options) {
        return md5($name . implode('|', $options));
    });

    $db1 = $dbFactory->create('mysql', array(
        'db_host' => 'localhost',
        'db_user' => 'admin',
        'db_pass' => 'Ch@ng3M3!',
        'db_name' => 'test',
    ));

    $db2 = $dbFactory->create('mysql', array(
        'db_host' => 'localhost',
        'db_user' => 'admin',
        'db_pass' => 'Ch@ng3M3!',
        'db_name' => 'test',
    ));

    var_dump($db1 === $db2); #> bool(true)

### Database Adapter Factory via `FactoryBuilder`

Instead of using the Phacture factory and decorator classes directly to compose your factory's behavior, you can use
the `FactoryBuilder`.

    $dbFactory = \Jeremeamia\Phacture\FactoryBuilder::newInstance()
        ->addNamespace('MyLib\Db\Adapter')
        ->addNameTransformer(function ($name) { return "{$name}Adapter"; })
        ->addNameInflection()
        ->addRequiredOptions(array('db_host', 'db_user', 'db_pass', 'db_name'))
        ->addFlyweightCaching(function ($name, $options) { return md5($name . implode('|', $options)); })
        ->build();

TODO
----

1. Gather feedback
2. Write tests
