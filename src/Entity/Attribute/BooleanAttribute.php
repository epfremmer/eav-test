<?php
/**
 * File BooleanAttribute.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Attribute;

/**
 * Class BooleanAttribute
 *
 * @ORM\Entity()
 * @ORM\Table("boolean_attribute")
 *
 * @package Epfremme\Eav\Entity
 */
class BooleanAttribute extends Attribute
{
    /**
     * Attribute Value
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var int
     */
    private $value;

    /**
     * {@inheritdoc}
     */
    public function getValue() : bool
    {
        return $this->value;
    }

    /**
     * Set Attribute Value
     *
     * @param bool $value
     * @return $this|self
     */
    public function setValue(bool $value = null) : self
    {
        $this->value = $value;

        return $this;
    }
}
