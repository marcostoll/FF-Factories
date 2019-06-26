<?php
/**
 * Definition of ClassIdentifierAwareInterface
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Factories\ClassLocators;

/**
 * Interface ClassIdentifierAwareInterface
 *
 * @package FF\Factories\ClassLocators
 */
interface ClassIdentifierAwareInterface
{
    /**
     * Retrieves the class identifier of this class
     *
     * @return string
     */
    public static function getClassIdentifier(): string;
}
