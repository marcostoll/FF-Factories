<?php
/**
 * Definition of BaseNamespaceClassLocator
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Factories\ClassLocators;

use FF\Utils\ClassUtils;

/**
 * Class BaseNamespaceClassLocator
 *
 * Expects a class name relative to any of the registered namespaces followed bei the common suffix as class identifier.
 *
 * Example 1:
 *      Registered namespace: 'MyProject'
 *      $commonSuffix: 'Events'
 *      valid $classIdentifiers:
 *          - 'Error'           => finds MyProject\Events\Error
 *
 * Example 2:
 *      Registered namespace: 'FF'
 *      $prefix: 'Events'
 *      valid $classIdentifiers:
 *          - 'Runtime\Error'    => finds FF\Events\Runtime\Error
 *
 * "Going up" in the namespace path by using '..\\' will not work.
 *
 * @package FF\Factories\ClassLocators
 */
class BaseNamespaceClassLocator extends NamespaceClassLocator
{
    /**
     * @var string
     */
    protected $commonSuffix;

    /**
     * @param string $commonSuffix
     * @param string[] $namespaces
     */
    public function __construct(string $commonSuffix, string ...$namespaces)
    {
        parent::__construct(...$namespaces);
        $this->commonSuffix = $commonSuffix;
    }

    /**
     * @return string
     */
    public function getCommonSuffix(): string
    {
        return $this->commonSuffix;
    }

    /**
     * @param string $commonSuffix
     * @return $this
     */
    public function setCommonSuffix(string $commonSuffix)
    {
        $this->commonSuffix = ClassUtils::normalizeNamespace($commonSuffix);
        return $this;
    }

    /**
     * @param string $ns
     * @param string $classIdentifier
     * @return string
     */
    protected function buildFqClassName(string $ns, string $classIdentifier): string
    {
        return parent::buildFqClassName($ns . '\\' . $this->commonSuffix, $classIdentifier);
    }
}