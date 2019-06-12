<?php
/**
 * Definition of AbstractFactoryTest
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Tests\Factories
{
    use FF\Factories\AbstractFactory;
    use FF\Factories\ClassLocators\NamespaceClassLocator;
    use FF\Factories\Exceptions\ClassNotFoundException;
    use FF\Tests\Factories\Sub\MySubObject;
    use PHPUnit\Framework\TestCase;

    /**
     * Test AbstractFactoryTest
     *
     * @package FF\Tests
     */
    class AbstractFactoryTest extends TestCase
    {
        /**
         * @var MyFactory
         */
        protected $uut;

        /**
         * {@inheritdoc}
         */
        protected function setUp(): void
        {
            $this->uut = new MyFactory();
        }

        /**
         * Tests the namesake method/feature
         */
        public function testSetGetClassLocator()
        {
            $value = new NamespaceClassLocator();
            $same = $this->uut->setClassLocator($value);
            $this->assertSame($this->uut, $same);
            $this->assertEquals($value, $this->uut->getClassLocator());
        }

        /**
         * Tests the namesake method/feature
         */
        public function testCreate()
        {
            /** @var MyObject $obj */
            $obj = $this->uut->create('MyObject', 'foo', true);
            $this->assertInstanceOf(MyObject::class, $obj);
            $this->assertEquals('foo', $obj->arg1);
            $this->assertTrue($obj->arg2);
        }

        /**
         * Tests the namesake method/feature
         */
        public function testCreateSubNamespace()
        {
            /** @var MySubObject $obj */
            $obj = $this->uut->create('Sub\\MySubObject', 'foo', true);
            $this->assertInstanceOf(MySubObject::class, $obj);
        }

        /**
         * Tests the namesake method/feature
         */
        public function testCreateWithInsufficientArgs()
        {
            $this->expectException(\ArgumentCountError::class);

            $this->uut->create('MyObject', 'foo');
        }

        /**
         * Tests the namesake method/feature
         */
        public function testCreateUnknown()
        {
            $this->expectException(ClassNotFoundException::class);

            $this->uut->create('foo');
        }
    }

    class MyFactory extends AbstractFactory
    {
        /**
         * Set to protected to prevent client instantiation.
         */
        public function __construct()
        {
            parent::__construct(new NamespaceClassLocator(__NAMESPACE__));
        }
    }

    class MyObject
    {
        /**
         * @var string
         */
        public $arg1;

        /**
         * @var bool
         */
        public $arg2;

        /**
         * @param string $arg1
         * @param bool $arg2
         */
        public function __construct(string $arg1, bool $arg2)
        {
            $this->arg1 = $arg1;
            $this->arg2 = $arg2;
        }
    }
}

namespace FF\Tests\Factories\Sub {

    use FF\Tests\Factories\MyObject;

    class MySubObject extends MyObject
    {

    }
}