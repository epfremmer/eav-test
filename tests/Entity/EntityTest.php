<?php
/**
 * File EntityTest.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Tests\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Epfremme\Eav\Entity\Attribute;
use Epfremme\Eav\Entity\Attribute\StringAttribute;
use Epfremme\Eav\Entity\Entity;
use Epfremme\Eav\Tests\EntityManagerFactory;
use PHPUnit_Framework_TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EntityTest
 *
 * @package Epfremme\Eav\Tests\Entity
 */
class EntityTest extends PHPUnit_Framework_TestCase
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

    /** @group entity */
    public function testConstruct()
    {
        $entity = new Entity();

        $this->assertAttributeEquals(null, 'id', $entity);
        $this->assertAttributeEquals(null, 'createdAt', $entity);
        $this->assertAttributeEquals(null, 'updatedAt', $entity);
        $this->assertAttributeInstanceOf(Collection::class, 'attributes', $entity);
        $this->assertAttributeEmpty('attributes', $entity);
    }

    /** @group entity */
    public function testConstructWithArgs()
    {
        $entity = new Entity([
            $attribute = new StringAttribute(),
        ]);

        $this->assertAttributeEquals(null, 'id', $entity);
        $this->assertAttributeEquals(null, 'createdAt', $entity);
        $this->assertAttributeEquals(null, 'updatedAt', $entity);
        $this->assertAttributeInstanceOf(Collection::class, 'attributes', $entity);
        $this->assertAttributeCount(1, 'attributes', $entity);
        $this->assertAttributeContains($attribute, 'attributes', $entity);
    }

    /** @group entity */
    public function testPersist()
    {
        $entity = new Entity();

        $this->em->persist($entity);

        $this->assertAttributeInstanceOf(Uuid::class, 'id', $entity);

        $this->em->flush();
        $this->em->clear(Entity::class);

        $freshEntity = $this->em->getRepository(Entity::class)->find($entity->getId());

        $this->assertNotSame($entity, $freshEntity);
        $this->assertAttributeInstanceOf(\DateTime::class, 'createdAt', $freshEntity);
        $this->assertAttributeInstanceOf(\DateTime::class, 'updatedAt', $freshEntity);
    }

    /** @group entity */
    public function testGetAttributes()
    {
        $entity = new Entity([
            $attribute = new StringAttribute(),
        ]);

        $this->assertInstanceOf(Collection::class, $entity->getAttributes());
        $this->assertCount(1, $entity->getAttributes());
        $this->assertContains($attribute, $entity->getAttributes());
    }

    /** @group entity */
    public function testPersistWithAttribute()
    {
        $entity = new Entity([
            $attribute = new StringAttribute(),
        ]);

        $this->em->persist($entity);
        $this->em->flush();
        $this->em->clear(Entity::class);
        $this->em->clear(Attribute::class);

        $freshEntity = $this->em->getRepository(Entity::class)->find($entity->getId());

        $this->assertNotSame($entity, $freshEntity);
        $this->assertAttributeContainsOnly(StringAttribute::class, 'attributes', $freshEntity);
        $this->assertAttributeCount(1, 'attributes', $freshEntity);

        $this->assertAttributeInstanceOf(Uuid::class, 'id', $attribute);
        $this->assertAttributeInstanceOf(\DateTime::class, 'createdAt', $attribute);
        $this->assertAttributeInstanceOf(\DateTime::class, 'updatedAt', $attribute);
    }

    /** @group entity */
    public function testPersistWithAttributes()
    {
        $entity = new Entity([
            $attribute1 = new StringAttribute('foo'),
            $attribute2 = new StringAttribute('bar'),
        ]);

        $this->em->persist($entity);
        $this->em->flush();
        $this->em->clear(Entity::class);
        $this->em->clear(Attribute::class);

        $freshEntity = $this->em->getRepository(Entity::class)->find($entity->getId());

        $this->assertNotSame($entity, $freshEntity);
        $this->assertAttributeContainsOnly(StringAttribute::class, 'attributes', $freshEntity);
        $this->assertAttributeCount(2, 'attributes', $freshEntity);

        $this->assertAttributeInstanceOf(Uuid::class, 'id', $attribute1);
        $this->assertAttributeInstanceOf(\DateTime::class, 'createdAt', $attribute1);
        $this->assertAttributeInstanceOf(\DateTime::class, 'updatedAt', $attribute1);

        $this->assertAttributeInstanceOf(Uuid::class, 'id', $attribute2);
        $this->assertAttributeInstanceOf(\DateTime::class, 'createdAt', $attribute2);
        $this->assertAttributeInstanceOf(\DateTime::class, 'updatedAt', $attribute2);
    }
}
