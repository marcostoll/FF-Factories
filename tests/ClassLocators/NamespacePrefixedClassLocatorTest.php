<?php
/**
 * Definition of NamespacePrefixedClassLocatorTest
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Tests\Factories\ClassLocators
{
    use FF\Factories\ClassLocators\NamespacePrefixedClassLocator;
    use FF\Tests\Factories\ClassLocators\Foo\MyFooObject;
    use FF\Tests\Factories\ClassLocators\Sub\Foo\MySubFooObject;
    use PHPUnit\Framework\TestCase;

    /**
     * Test NamespacePrefixedClassLocatorTest
     *
     * @package FF\Tests
     */
    class NamespacePrefixedClassLocatorTest extends TestCase
    {
        /**
         * @var NamespacePrefixedClassLocator
         */
        protected $uut;

        /**
         * {@inheritdoc}
         */
        protected function setUp(): void
        {
            $this->uut = new NamespacePrefixedClassLocator('Foo', __NAMESPACE__);
        }

        /**
         * Tests the namesake method/feature
         */
        public function testSetGetPrefix()
        {
            $value = 'foo';
            $same = $this->uut->setPrefix($value);
            $this->assertSame($this->uut, $same);
            $this->assertEquals($value, $this->uut->getPrefix());
        }

        /**
         * Tests the namesake method/feature
         */
        public function testLocateClass()
        {
            $result = $this->uut->locateClass('MyFooObject');
            $this->assertEquals(MyFooObject::class, $result);

            $result = $this->uut->locateClass('Sub\MySubFooObject');
            $this->assertEquals(MySubFooObject::class, $result);
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
            $result = $this->uut->locateClass('Sub\\..\\MyFooObject');
            $this->assertNull($result);
        }
    }
}

namespace FF\Tests\Factories\ClassLocators\Foo {

    class MyFooObject
    {

    }
}

namespace FF\Tests\Factories\ClassLocators\Sub\Foo {

    class MySubFooObject
    {

    }
}
