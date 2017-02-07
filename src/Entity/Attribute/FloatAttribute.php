<?php
/**
 * File FloatAttribute.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Attribute;

/**
 * Class FloatAttribute
 *
 * @ORM\Entity()
 * @ORM\Table("float_attribute")
 *
 * @package Epfremme\Eav\Entity
 */
class FloatAttribute extends Attribute
{
    /**
     * Attribute Value
     *
     * @ORM\Column(type="decimal", nullable=true)
     *
     * @var float
     */
    private $value;

    /**
     * Attribute constructor
     *
     * @param float $value
     */
    public function __construct(float $value = null)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue() : float
    {
        return $this->value;
    }

    /**
     * Set Attribute Value
     *
     * @param float $value
     * @return $this|self
     */
    public function setValue(float $value) : self
    {
        $this->value = $value;

        return $this;
    }
}
