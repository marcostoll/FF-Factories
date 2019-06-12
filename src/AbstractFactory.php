<?php
/**
 * Definition of AbstractFactory
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Factories;

use FF\Factories\Exceptions\ClassNotFoundException;
use FF\Factories\Exceptions\InstantiationException;
use FF\Factories\ClassLocators\ClassLocatorInterface;

/**
 * Class AbstractFactory
 *
 * @package FF\Factories
 */
abstract class AbstractFactory
{
    /**
     * @var ClassLocatorInterface
     */
    protected $classLocator;

    /**
     * @param ClassLocatorInterface $classLocator
     */
    public function __construct(ClassLocatorInterface $classLocator)
    {
        $this->classLocator = $classLocator;
    }

    /**
     * Creates an object instance of a suitable class
     *
     * Any arguments provided will be passed to the class's constructor.
     * The amount and order of the $args given must match the constructor signature of the class to instantiate.
     *
     * @param string $classIdentifier
     * @param array $args
     * @return object
     * @throws ClassNotFoundException no suitable class definition found
     * @throws InstantiationException error while trying to instantiate object
     */
    public function create(string $classIdentifier, ...$args)
    {
        $fqClassName = $this->classLocator->locateClass($classIdentifier);
        if (is_null($fqClassName)) {
            throw new ClassNotFoundException('no suitable class definition found for [' . $classIdentifier . ']');
        }

        try {
            return (new \ReflectionClass($fqClassName))->newInstance(...$args);
        } catch (\ReflectionException $e) {
            throw new InstantiationException(
                'error while trying to instantiate object of class [' . $fqClassName . ']',
                0,
                $e
            );
        }
    }

    /**
     * @return ClassLocatorInterface
     */
    public function getClassLocator(): ClassLocatorInterface
    {
        return $this->classLocator;
    }

    /**
     * @param ClassLocatorInterface $classLocator
     * @return AbstractFactory
     */
    public function setClassLocator(ClassLocatorInterface $classLocator)
    {
        $this->classLocator = $classLocator;
        return $this;
    }
}