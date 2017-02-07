<?php
/**
 * File IdentifiableEntityTest.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Tests\Entity\Mixin;

use Doctrine\ORM\EntityManager;
use Epfremme\Eav\Entity\Entity;
use Epfremme\Eav\Tests\EntityManagerFactory;
use PHPUnit_Framework_TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class IdentifiableEntityTest
 *
 * @package Epfremme\Eav\Tests\Entity\Mixin
 */
class IdentifiableEntityTest extends PHPUnit_Framework_TestCase
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
    public function testGetId()
    {
        $attribute = new Entity();
        $this->em->persist($attribute);

        $this->assertInstanceOf(Uuid::class, $attribute->getId());

        $this->em->flush();
        $this->em->clear(Entity::class);

        /** @var Entity $freshAttribute */
        $freshAttribute = $this->em->getRepository(Entity::class)->find($attribute->getId());

        $this->assertEquals($attribute->getId(), $freshAttribute->getId());
    }
}
