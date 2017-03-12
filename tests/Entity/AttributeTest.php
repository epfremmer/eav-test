<?php
/**
 * File AttributeTest.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Tests\Entity;

use Doctrine\DBAL\Driver\AbstractSQLiteDriver;
use Doctrine\ORM\EntityManager;
use Epfremme\Eav\Entity\Attribute;
use Epfremme\Eav\Entity\Entity;
use Epfremme\Eav\Tests\EntityManagerFactory;
use PHPUnit_Framework_TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class AttributeTest
 *
 * @package Epfremme\Eav\Tests\Entity
 */
class AttributeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->em = EntityManagerFactory::build();

        parent::setUp();
    }

    /** @group attribute */
    public function testConstruct()
    {
        /** @var Attribute $attribute */
        $attribute = $this->getMockForAbstractClass(Attribute::class, ['foo']);

        $this->assertAttributeSame('foo', 'name', $attribute);
    }

    /** @group attribute */
    public function testGetName()
    {
        /** @var Attribute $attribute */
        $attribute = $this->getMockForAbstractClass(Attribute::class, ['foo']);

        $this->assertSame('foo', $attribute->getName());
    }

    /**
     * Test setting Attribute Value
     *
     * @group attribute
     * @dataProvider attributeTypeProvider
     *
     * @param string $attribute
     * @param mixed $value
     */
    public function testSetValue(string $attribute, $value)
    {
        /** @var Attribute $attribute */
        $attribute = new $attribute('foo');
        $attribute->setValue($value);

        $this->assertAttributeSame($value, 'value', $attribute);
        $this->assertAttributeSame('foo', 'name', $attribute);
    }

    /**
     * Test getting Attribute Value
     *
     * @group attribute
     * @dataProvider attributeTypeProvider
     *
     * @param string $attribute
     * @param mixed $value
     */
    public function testGetValue(string $attribute, $value)
    {
        /** @var Attribute $attribute */
        $attribute = new $attribute('foo');
        $attribute->setValue($value);

        $this->assertSame($value, $attribute->getValue());
        $this->assertSame($value, $attribute->getValue());
    }

    /**
     * Test Attribute DB Persist
     *
     * @group attribute
     * @dataProvider attributeTypeProvider
     *
     * @param string $attribute
     * @param mixed $value
     * @param mixed $expected
     */
    public function testPersist(string $attribute, $value, $expected)
    {
        /** @var Attribute $attribute */
        $attribute = new $attribute('foo');
        $attribute->setValue($value);

        $this->em->persist($attribute);
        $this->em->flush();
        $this->em->clear(Attribute::class);

        /** @var Attribute $freshAttribute */
        $freshAttribute = $this->em->getRepository(Attribute::class)->find($attribute->getId());

        $this->assertNotSame($attribute, $freshAttribute);
        $this->assertEquals($expected, $freshAttribute->getValue());
        $this->assertEquals('foo', $freshAttribute->getName());

        $this->assertAttributeInstanceOf(Uuid::class, 'id', $freshAttribute);
        $this->assertAttributeInstanceOf(\DateTime::class, 'createdAt', $freshAttribute);
        $this->assertAttributeInstanceOf(\DateTime::class, 'updatedAt', $freshAttribute);
    }

    /**
     * Test Attribute DB Persist on Cascade
     *
     * @group attribute
     * @dataProvider attributeTypeProvider
     *
     * @param string $attribute
     * @param mixed $value
     * @param mixed $expected
     */
    public function testCascadePersist(string $attribute, $value, $expected)
    {
        /** @var Attribute $attribute */
        $attribute = new $attribute('foo');
        $attribute->setValue($value);

        $entity = new Entity();
        $entity->set($attribute);

        $this->em->persist($entity);
        $this->em->flush();
        $this->em->clear(Entity::class);
        $this->em->clear(Attribute::class);

        /** @var Entity $freshEntity */
        $freshEntity = $this->em->getRepository(Entity::class)->find($entity->getId());
        $freshAttribute = $freshEntity->get('foo');

        $this->assertNotSame($attribute, $freshAttribute);
        $this->assertEquals($expected, $freshAttribute->getValue());
        $this->assertEquals('foo', $freshAttribute->getName());

        $this->assertAttributeInstanceOf(Uuid::class, 'id', $freshAttribute);
        $this->assertAttributeInstanceOf(\DateTime::class, 'createdAt', $freshAttribute);
        $this->assertAttributeInstanceOf(\DateTime::class, 'updatedAt', $freshAttribute);
    }

    /**
     * @return array
     */
    public function attributeTypeProvider() : array
    {
        $testDate = new \DateTime('2000-01-01 12:30:15', $this->getCompatibleTimezone());

        return [
            'bigint' => [Attribute\BigIntAttribute::class, 9223372036854775807, 9223372036854775807],
            'boolean' => [Attribute\BooleanAttribute::class, true, true],
            'date' => [Attribute\DateAttribute::class, $testDate, new \DateTime('2000-01-01')],
            'datetime' => [Attribute\DateTimeAttribute::class, $testDate, new \DateTime('2000-01-01 12:30:15')],
            'datetimetz' => [Attribute\DateTimeTzAttribute::class, $testDate, new \DateTime('2000-01-01 12:30:15', $this->getCompatibleTimezone())],
            'decimal' => [Attribute\DecimalAttribute::class, 100.55, 100.55],
            'float' => [Attribute\FloatAttribute::class, 100.55, 100.55],
            'integer' => [Attribute\IntegerAttribute::class, 2147483647, 2147483647],
            'smallint' => [Attribute\SmallIntAttribute::class, 32767, 32767],
            'string' => [Attribute\StringAttribute::class, 'foo', 'foo'],
            'text' => [Attribute\TextAttribute::class, 'bar', 'bar'],
            'time' => [Attribute\TimeAttribute::class, $testDate, new \DateTime('1970-01-01 12:30:15')],
        ];
    }

    /**
     * Return DateTimeZone that is compatible with the current DB driver
     *
     * Limited support for datetimetz date type in SQLLite and MySQL
     *
     * @see http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/known-vendor-issues.html#id1
     * @see http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/known-vendor-issues.html#datetimetz
     *
     * @return \DateTimeZone
     */
    private function getCompatibleTimezone()
    {
        $driver = EntityManagerFactory::build()->getConnection()->getDriver()->getName();

        return new \DateTimeZone(in_array($driver, ['pdo_mysql', 'pdo_sqlite']) ? 'UTC' : 'America/Chicago');
    }
}
