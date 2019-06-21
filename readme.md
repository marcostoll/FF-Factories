FF\Factories | Fast Forward Family
========================================================================================================================

by Marco Stoll

- <marco.stoll@rocketmail.com>
- <http://marcostoll.de>
- <https://github.com/marcostoll>
- <https://github.com/marcostoll/FF>
- <https://github.com/marcostoll/FF-Factories>
------------------------------------------------------------------------------------------------------------------------

# What is the Fast Forward Family?
Fast Forward, in short **FF**, is a template for building web applications. The **FF Family** is a series of basic
repositories on which **FF** depends on but may also be used independently if desired.

**FF** is not a framework in and of itself and therefore should not be called so. But you may orchestrate multiple 
**FF** components to build an web application skeleton that provides the most common tasks.

# Introduction - What if FF\Factories?

**FF\Factories** provides an factory pattern implementation for generic object instantiation.

# Installation

## via Composer

@todo

## manual Installation

@todo

# The Factories

The `AbstractFactory` provides logic to introduce factory-style object instantiation. By configuring it with a 
designated class locator you may invoke its `create()` method with a class identifier  and the necessary constructor 
arguments to get a fresh instance of this class.

The factory will instruct the its class locator to detect a suitable class definition and after that will invoke the
class's constructor and return the object.

An example:

    namespace MyProject\Views\Helpers;
    
    use FF\Factories\AbstractFactory;
    use FF\Factories\ClassLocators\NamespaceClassLocator;
    
    /**
     * Definition of Helpers Factory
     */
    class MyHelpersFactory extends AbstractFactory
    {
        public function __construct()
        {
            // configure the factory with its own namespace
            // to search for Helper class
            parent::__construct(new NamespaceClassLocator(__NAMESPACE__));
        }
    }
    
    ...
    
    // Will get a MyViewHelper instance assumed the a MyProject\Views\Helpers\MyViewHelper class exists.
    // In this example $arg1 and $arg2 will be passed to the MyViewHelper class's constructor in the given order.
    $myHelper = $myHelpersFactory->create('MyViewHelper', $arg1, $arg2);
    
The `AbstractSingletonFactory` extends this behaviour by adding a singleton pattern to its implementation that will 
ensure that an instance of a class identified by its identifier will only be instantiated a single time.    
So any additional call to its `create()` method will return the same instance as the first time.

**Beware**: Only the class identifier will be taken into account for identifying already instantiated objects. Varying 
any constructor arguments will not lead to generating new object instances.

# The Class Locators

Class locators implement various strategies to derive full-qualified class names based on a shorter class identifier.
Each class locator defines a different convention for specifying class identifiers and the logic to detect suitable
class definitions based on this.

## The Namespace Class Locator

This class locator can be configured with a list of base namespaces ro search for class definitions with a class 
identifier relative to one of its base namespaces.
The base namespaces wil be search in the give order. So the locator will return the first match of an existing class.

An example:

    use FF\Factories\ClassLocators\NamespaceClassLocator;

    $myLocator = new NamespaceClassLocator('MyProject\Sub1', 'MyProject\Sub2');
    
    // This will find MyProject\Sub1\MyClass or MyProject\Sub2\MyClass in this order.
    // If none of the above exist, $class will be null.
    $class = $myLocator->locateClass('MyClass');
    
    // This will find MyProject\Sub1\Foo\MyClass or MyProject\Sub2\Foo\MyClass in this order.
    // If none of the above exist, $class will be null.
    $class = $myLocator->locateClass('Foo\MyClass');
    
## The Base Namespace Class Locator

This class locator can be configured with a list of base namespaces and a common suffix ro search for class definitions 
with a class identifier relative to one of its base namespaces.
The base namespaces wil be search in the give order. So the locator will return the first match of an existing class.

An example:

    use FF\Factories\ClassLocators\BaseNamespaceClassLocator;

    $commonSuffix = 'Some\Suffix';
    $myLocator = new NamespaceClassLocator($commonSuffix, MyProject\Sub1', 'MyProject\Sub2');
    
    // This will find MyProject\Sub1\Some\Suffix\MyClass or MyProject\Sub2\Some\Suffix\MyClass in this order.
    // If none of the above exist, $class will be null.
    $class = $myLocator->locateClass('MyClass');
    
    // This will find MyProject\Sub1\Some\Suffix\Foo\MyClass or MyProject\Sub2\Some\Suffix\Foo\MyClass in this order.
    // If none of the above exist, $class will be null.
    $class = $myLocator->locateClass('Foo\MyClass');    
    
## The Namespace Prefixed Class Locator

Sometimes you want to distribute class definitions of a certain kind (say Event classes) over various packages. To
provide a factory capable of creating this events objects you  may use the `NamespacePrefixedClassLocator`. This 
locator enforces you to place your various class definitions within a common class namespace prefix.

An example:

        use FF\Factories\ClassLocators\NamespacePrefixedClassLocator;
        
        // The first argumens ('Events') is the common class namespace prefix.
        // The following argumentgs are the base namespaces to inspect.
        $myLocator = new NamespaceClassLocator('Events', MyProject\Sub1', 'MyProject\Sub2');
        
        // This will find MyProject\Sub1\Events\MyEvent or MyProject\Sub2\Events\MyEven in this order.
        // If none of the above exist, $class will be null.
        $class = $myLocator->locateClass('MyEvent');
        
        // This will find MyProject\Sub1\Foo\Events\MyEvent or MyProject\Sub2\Foo\Events\MyEvent in this order.
        // If none of the above exist, $class will be null.
        $class = $myLocator->locateClass('Foo\MyEvent');

# Road map

The extend of the **Factories** component is mainly driven by the needs of other **FF** components, so not concrete 
features are planned at this time. The component surely will grow as other **FF** components require additional logic 
that is not part of their domain.