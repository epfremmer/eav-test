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
 * @ORM\Entity()
 * @ORM\Table(name="attribute")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 *
 * @method $this setValue($value = null) - Subclasses *must* implement this method (allow value type hinting)
 *
 * @package Epfremme\Eav\Entity
 */
abstract class Attribute
{
    use IdentifiableEntity;
    use TimestampableEntity;

    /**
     * Attribute Name
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     *
     * @var string
     */
    private $name;

    /**
     * Attribute Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Return Attribute Value
     *
     * Details:
     *
     *  - Type hint implemented on subclass
     *  - No abstract setter to allow type hinting on subclass
     *
     * @return mixed
     */
    abstract public function getValue();

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
