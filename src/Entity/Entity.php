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
     * @ORM\ManyToMany(targetEntity="Attribute", indexBy="name", cascade={"persist"}, fetch="EAGER")
     *
     * @var Attribute[]|Collection
     */
    private $attributes;

    /**
     * Entity Constructor
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    /**
     * Get Attribute
     *
     * Details:
     *
     *  - Returns null if attribute does not exist
     *  - Update existing attribute value directly on attribute
     *
     * Examples:
     *
     * ```php
     * $attribute = $entity->get('field_name'); // if null then field_name is not set
     * $attribute->setValue('new value'); // attribute value updated
     *
     * $entity->get('field_name')->setValue('new value'); // field_name attribute updated
     * ```
     *
     * @param string $name
     * @return Attribute|null
     */
    public function get(string $name) : ?Attribute
    {
        return $this->attributes->get($name);
    }

    /**
     * Set Attribute
     *
     * Details:
     *
     *  - Enforces indexBy="name" in attributes collection
     *  - Replaces existing attribute if set
     *
     * Example:
     *
     * ```php
     * use Epfremme\Eav\Entity\Attribute\StringAttribute;
     * use Epfremme\Eav\Entity\Attribute\IntegerAttribute;
     *
     * $entity->add(new StringAttribute('field_name')); // field_name attribute added
     * $entity->add(new IntegerAttribute('field_name')); // field_name attribute replaced
     * ```
     *
     * @param Attribute $attribute
     * @return Attribute
     */
    public function set(Attribute $attribute) : Attribute
    {
        $this->attributes->set($attribute->getName(), $attribute);

        return $attribute;
    }

    /**
     * Test is Attribute exists
     *
     * Details:
     *
     *  - Returns false if attribute key does not exist
     *
     * Examples:
     *
     * ```php
     * if (!$entity->has('field_name')) {
     *     // handle missing attribute
     * }
     *
     * if ($entity->has('field_name')) {
     *     $attribute = $entity->get('field_name');
     *
     *     // do something with attribute
     * }
     * ```
     *
     * @param string $name
     * @return bool
     */
    public function has($name) : bool
    {
        return $this->attributes->containsKey($name);
    }
}
