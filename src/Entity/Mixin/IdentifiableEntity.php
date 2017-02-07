<?php
/**
 * File IdentifiableEntity.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity\Mixin;

use Ramsey\Uuid\Uuid;

/**
 * Class IdentifiableEntity
 *
 * Package ramsey/uuid requires doctrine type to be registered
 *
 * Example:
 *
 * ```php
 * \Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
 * ```
 *
 * @package Epfremme\Eav\Entity\Mixin
 */
trait IdentifiableEntity
{
    /**
     * Entity ID
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @var Uuid
     */
    protected $id;

    /**
     * @return Uuid
     */
    public function getId() : Uuid
    {
        return $this->id;
    }
}
