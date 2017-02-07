<?php
/**
 * File Entity.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Mixin\IdentifiableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="entity")
 *
 * @package Epfremme\Eav\Entity
 */
class Entity
{
    use IdentifiableEntity;
    use TimestampableEntity;

    /**
     * Entity attributes
     *
     * @ORM\ManyToMany(targetEntity="Attribute", cascade={"persist"}, fetch="EAGER")
     *
     * @var Attribute[]|Collection
     */
    private $attributes;

    /**
     * Entity constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = new ArrayCollection($attributes);
    }

    /**
     * @return Attribute[]|Collection
     */
    public function getAttributes() : Collection
    {
        return $this->attributes;
    }
}
