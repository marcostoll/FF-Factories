<?php
/**
 * Definition of NamespacePrefixedClassLocator
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Factories\ClassLocators;

use FF\Utils\ClassUtils;

/**
 * Class NamespacePrefixedClassLocator
 *
 * Expects a class name prefixed by a specific path relative to any of the registered namespaces as class identifier.
 *
 * Example 1:
 *      Registered namespace: 'FF\Runtime'
 *      $prefix: 'Events'
 *      valid $classIdentifiers:
 *          - 'OnError'           => finds FF\Runtime\Events\OnError
 *
 * Example 2:
 *      Registered namespace: 'FF'
 *      $prefix: 'Events'
 *      valid $classIdentifiers:
 *          - 'Runtime\OnError'    => finds FF\Runtime\Events\OnError
 *
 * "Going up" in the namespace path by using '..\\' will not work.
 *
 * @package FF\Factories\ClassLocators
 */
class NamespacePrefixedClassLocator extends NamespaceClassLocator
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @param string $prefix
     * @param string[] $namespaces
     */
    public function __construct(string $prefix, string ...$namespaces)
    {
        parent::__construct(...$namespaces);
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = ClassUtils::normalizeNamespace($prefix);
        return $this;
    }

    /**
     * @param string $ns
     * @param string $classIdentifier
     * @return string
     */
    protected function buildFqClassName(string $ns, string $classIdentifier): string
    {
        $classPath = explode('\\', ClassUtils::normalizeNamespace($classIdentifier));
        $localClassName = array_pop($classPath);
        $subNs = !empty($classPath) ? implode('\\', $classPath) . '\\' : '';

        return $ns . '\\' . $subNs . $this->prefix . '\\' . $localClassName;
    }
}