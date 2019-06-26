<?php
/**
 * Definition of NamespaceClassLocator
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Factories\ClassLocators;

use FF\Utils\ClassUtils;

/**
 * Class NamespaceClassLocator
 *
 * Expects a class name relative to any of the registered namespaces as class identifier.
 *
 * Example 1:
 *      Registered namespace: 'FF\Forms\Fields'
 *      valid $classIdentifiers:
 *          - 'TextField'           => finds FF\Forms\Fields\TextField
 *          - 'RadioField'          => finds FF\Forms\Fields\RadioField
 *
 * Example 2:
 *      Registered namespace: 'FF\Forms'
 *      valid $classIdentifiers:
 *          - 'Fields\TextField'    => finds FF\Forms\Fields\TextField
 *          - 'Fields\RadioField'   => finds FF\Forms\Fields\RadioField
 *
 * "Going up" in the namespace path by using '..\\' will not work.
 *
 * @package FF\Factories\ClassLocators
 */
class NamespaceClassLocator implements ClassLocatorInterface
{
    /**
     * @var string[]
     */
    protected $namespaces = [];

    /**
     * @param string[] $namespaces
     */
    public function __construct(string ...$namespaces)
    {
        $this->setNamespaces($namespaces);
    }

    /**
     * Locates a full-qualified class name using the given identifier
     *
     * Returns null if no suitable class found.
     *
     * @param string $classIdentifier
     * @return string|null
     */
    public function locateClass(string $classIdentifier): ?string
    {
        foreach ($this->namespaces as $ns) {
            $fqClassname = $this->buildFqClassName($ns, $classIdentifier);
            if (!class_exists($fqClassname)) {
                continue;
            }

            return $fqClassname;
        }

        return null;
    }

    /**
     * @return string[]
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * @param array $namespaces
     * @return $this
     */
    public function setNamespaces(array $namespaces)
    {
        $this->normalizeNamespaces($namespaces);
        $this->namespaces = $namespaces;
        return $this;
    }

    /**
     * @param string[] $namespaces
     * @return $this
     */
    public function prependNamespaces(string ...$namespaces)
    {
        $this->normalizeNamespaces($namespaces);
        $this->namespaces = array_merge($namespaces, $this->namespaces);
        return $this;
    }

    /**
     * @param string $ns
     * @param string $classIdentifier
     * @return string
     */
    protected function buildFqClassName(string $ns, string $classIdentifier): string
    {
        return $ns . '\\' . $classIdentifier;
    }

    /**
     * @param array $namespaces
     */
    protected function normalizeNamespaces(array &$namespaces)
    {
        array_walk($namespaces, [ClassUtils::class, 'normalizeNamespace']);
    }
}
