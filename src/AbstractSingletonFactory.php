<?php
/**
 * Definition of AbstractSingletonFactory
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Factories;

/**
 * Class AbstractSingletonFactory
 *
 * @package FF\Factories
 */
abstract class AbstractSingletonFactory extends AbstractFactory
{
    /**
     * @var array
     */
    protected array $instanceCache = [];

    /**
     * {@inheritdoc}
     *
     * Successfully created instances will be stored within the instance cache using their $classIdentifier as key.
     * Retrieves the object from the instance cache if already present. If not, attempts to create it.
     */
    public function create(string $classIdentifier, ...$args): object
    {
        // check instance cache first
        if (isset($this->instanceCache[$classIdentifier])) {
            return $this->instanceCache[$classIdentifier];
        }

        $instance = parent::create($classIdentifier, ...$args);
        $this->instanceCache[$classIdentifier] = $instance;

        return $instance;
    }

    /**
     * Clears all created instances from the cache
     *
     * @return $this
     */
    public function clearInstanceCache(): self
    {
        $this->instanceCache = [];
        return $this;
    }
}
