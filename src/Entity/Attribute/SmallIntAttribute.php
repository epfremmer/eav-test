<?php
/**
 * File SmallIntAttribute.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Attribute;

/**
 * Class SmallIntAttribute
 *
 * @ORM\Entity()
 * @ORM\Table("smallint_attribute")
 *
 * @package Epfremme\Eav\Entity
 */
class SmallIntAttribute extends Attribute
{
    /**
     * Attribute Value
     *
     * @ORM\Column(type="smallint", nullable=true)
     *
     * @var int
     */
    private $value;

    /**
     * Attribute constructor
     *
     * @param int $value
     */
    public function __construct(int $value = null)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue() : int
    {
        return $this->value;
    }

    /**
     * Set Attribute Value
     *
     * @param int $value
     * @return $this|self
     */
    public function setValue(int $value) : self
    {
        $this->value = $value;

        return $this;
    }
}
