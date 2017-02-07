<?php
/**
 * File Attribute.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity;

use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Mixin\IdentifiableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class Attribute
 *
 * ORM\MappedSuperclass()
 *
 * @ORM\Entity()
 * @ORM\Table(name="attribute")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 *
 * @package Epfremme\Eav\Entity
 */
abstract class Attribute
{
    use IdentifiableEntity;
    use TimestampableEntity;

    /**
     * Return Attribute Value
     *
     * @return mixed
     */
    abstract public function getValue();
}
