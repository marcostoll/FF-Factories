<?php
/**
 * Definition of ClassLocatorInterface
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Factories\ClassLocators;

/**
 * Interface ClassLocatorInterface
 *
 * @package FF\Factories\ClassLocators
 */
interface ClassLocatorInterface
{
    /**
     * Locates a full-qualified class name using the given identifier
     *
     * Returns null if no suitable class found.
     *
     * @param string $classIdentifier
     * @return string|null
     */
    public function locateClass(string $classIdentifier): ?string;
}
