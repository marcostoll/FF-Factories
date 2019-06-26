<?php
/**
 * Definition of AbstractSingletonFactoryTest
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Tests\Factories;

use FF\Factories\AbstractSingletonFactory;
use FF\Factories\ClassLocators\NamespaceClassLocator;
use PHPUnit\Framework\TestCase;

/**
 * Test AbstractSingletonFactoryTest
 *
 * @package FF\Tests
 */
class AbstractSingletonFactoryTest extends TestCase
{
    /**
     * @var MySingletonFactory
     */
    protected $uut;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->uut = new MySingletonFactory();
    }

    /**
     * Tests the namesake method/feature
     */
    public function testCreateSingleton()
    {
        /** @var MySingletonObject $obj1 */
        $obj1 = $this->uut->create('MySingletonObject');
        /** @var MySingletonObject $obj2 */
        $obj2 = $this->uut->create('MySingletonObject');
        $this->assertSame($obj1, $obj2);
    }

    /**
     * Tests the namesake method/feature
     */
    public function testClearInstanceCache()
    {
        /** @var MySingletonObject $obj1 */
        $obj1 = $this->uut->create('MySingletonObject');

        $same = $this->uut->clearInstanceCache();
        $this->assertSame($this->uut, $same);

        /** @var MySingletonObject $obj2 */
        $obj2 = $this->uut->create('MySingletonObject');
        $this->assertNotSame($obj1, $obj2);
    }
}

class MySingletonFactory extends AbstractSingletonFactory
{
    /**
     * Set to protected to prevent client instantiation.
     */
    public function __construct()
    {
        parent::__construct(new NamespaceClassLocator(__NAMESPACE__));
    }
}

class MySingletonObject
{

}
