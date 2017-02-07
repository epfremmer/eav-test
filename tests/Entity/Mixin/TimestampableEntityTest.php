<?php
/**
 * File TimestampableEntityTest.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Tests\Entity\Mixin;

use Doctrine\ORM\EntityManager;
use Epfremme\Eav\Entity\Attribute\StringAttribute;
use Epfremme\Eav\Entity\Entity;
use Epfremme\Eav\Tests\EntityManagerFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class TimestampableEntityTest
 *
 * @package Epfremme\Eav\Tests\Entity\Mixin
 */
class TimestampableEntityTest extends PHPUnit_Framework_TestCase
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
    public function testCreatedAt()
    {
        $entity = new Entity();

        $this->assertEmpty($entity->getCreatedAt());

        $entity->setCreatedAt($epoch = new \DateTime('@0'));

        // create attribute
        $this->em->persist($entity);
        $this->em->flush();

        $this->assertInstanceOf(\DateTime::class, $entity->getCreatedAt());
        $this->assertEquals($epoch, $entity->getCreatedAt());

        // modify entity
        $entity->getAttributes()->add(new StringAttribute('foo'));

        // update attribute
        $this->em->persist($entity);
        $this->em->flush();
        $this->em->clear(Entity::class);

        /** @var Entity $freshEntity */
        $freshEntity = $this->em->getRepository(Entity::class)->find($entity->getId());

        $this->assertNotSame($epoch, $freshEntity->getCreatedAt());
        $this->assertEquals($epoch, $freshEntity->getCreatedAt());
    }

    /** @group attribute */
    public function testUpdatedAt()
    {
        $entity = new Entity();

        $this->assertEmpty($entity->getUpdatedAt());

        $entity->setUpdatedAt($epoch = new \DateTime('@0'));

        // create entity
        $this->em->persist($entity);
        $this->em->flush();

        $this->assertInstanceOf(\DateTime::class, $entity->getUpdatedAt());
        $this->assertEquals($epoch, $entity->getUpdatedAt());

        // modify entity
        $entity->getAttributes()->add(new StringAttribute('foo'));

        // update entity
        $this->em->persist($entity);
        $this->em->flush();
        $this->em->clear(Entity::class);

        /** @var Entity $freshEntity */
        $freshEntity = $this->em->getRepository(Entity::class)->find($entity->getId());

        $this->assertNotSame($epoch, $freshEntity->getUpdatedAt());
        $this->assertEquals(new \DateTime(), $freshEntity->getUpdatedAt(), '', 1.0);
    }
}
