<?php
/**
 * Definition of BaseNamespaceClassLocatorTest
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Tests\Factories\ClassLocators
{

    use FF\Factories\ClassLocators\BaseNamespaceClassLocator;
    use FF\Tests\Factories\ClassLocators\Sub\MyBaseSubObject;
    use PHPUnit\Framework\TestCase;

    /**
     * Test BaseNamespaceClassLocatorTest
     *
     * @package FF\Tests
     */
    class BaseNamespaceClassLocatorTest extends TestCase
    {
        /**
         * @var BaseNamespaceClassLocator
         */
        protected $uut;

        /**
         * {@inheritdoc}
         */
        protected function setUp(): void
        {
            $this->uut = new BaseNamespaceClassLocator('ClassLocators', 'FF\Tests\Factories');
        }

        /**
         * Tests the namesake method/feature
         */
        public function testLocateClass()
        {
            $result = $this->uut->locateClass('MyBaseObject');
            $this->assertEquals(MyBaseObject::class, $result);

            $result = $this->uut->locateClass('Sub\MyBaseSubObject');
            $this->assertEquals(MyBaseSubObject::class, $result);
        }

        /**
         * Tests the namesake method/feature
         */
        public function testLocateClassNotFound()
        {
            $result = $this->uut->locateClass('Foo');
            $this->assertNull($result);
        }

        /**
         * Tests the namesake method/feature
         */
        public function testLocateClassNotFoundUpFailure()
        {
            $result = $this->uut->locateClass('Sub\\..\\MyBaseObject');
            $this->assertNull($result);
        }
    }

    class MyBaseObject
    {

    }
}

namespace FF\Tests\Factories\ClassLocators\Sub {

    use FF\Tests\Factories\ClassLocators\MyBaseObject;

    class MyBaseSubObject extends MyBaseObject
    {

    }
}
