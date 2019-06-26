<?php
/**
 * Definition of NamespaceClassLocatorTest
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Tests\Factories\ClassLocators
{
    use FF\Factories\ClassLocators\NamespaceClassLocator;
    use FF\Tests\Factories\ClassLocators\Sub\MySubObject;
    use PHPUnit\Framework\TestCase;

    /**
     * Test NamespaceClassLocatorTest
     *
     * @package FF\Tests
     */
    class NamespaceClassLocatorTest extends TestCase
    {
        /**
         * @var NamespaceClassLocator
         */
        protected $uut;

        /**
         * @var string[]
         */
        protected $namespaceCache = [];

        /**
         * {@inheritdoc}
         */
        protected function setUp(): void
        {
            $this->uut = new NamespaceClassLocator(__NAMESPACE__);
            $this->namespaceCache = $this->uut->getNamespaces();
        }

        /**
         * {@inheritdoc}
         */
        protected function tearDown(): void
        {
            $this->uut->setNamespaces($this->namespaceCache);
        }

        /**
         * Tests the namesake method/feature
         */
        public function testSetGetNamespaces()
        {
            $value = ['foo', 'bar'];
            $same = $this->uut->setNamespaces($value);
            $this->assertSame($this->uut, $same);
            $this->assertEquals($value, $this->uut->getNamespaces());
        }

        /**
         * Tests the namesake method/feature
         */
        public function testPrependNamespaces()
        {
            $same = $this->uut->setNamespaces(['foo', 'bar'])->prependNamespaces('baz');
            $this->assertSame($this->uut, $same);
            $this->assertEquals('baz', $this->uut->getNamespaces()[0]);
            $this->assertEquals(3, count($this->uut->getNamespaces()));
        }

        /**
         * Tests the namesake method/feature
         */
        public function testLocateClass()
        {
            $result = $this->uut->locateClass('MyObject');
            $this->assertEquals(MyObject::class, $result);

            $result = $this->uut->locateClass('Sub\MySubObject');
            $this->assertEquals(MySubObject::class, $result);
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
            $result = $this->uut->locateClass('Sub\\..\\MyObject');
            $this->assertNull($result);
        }
    }

    class MyObject
    {

    }
}

namespace FF\Tests\Factories\ClassLocators\Sub {

    use FF\Tests\Factories\ClassLocators\MyObject;

    class MySubObject extends MyObject
    {

    }
}
