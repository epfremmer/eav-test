<?php
/**
 * File IntegerAttribute.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Attribute;

/**
 * Class IntegerAttribute
 *
 * @ORM\Entity()
 * @ORM\Table("integer_attribute")
 *
 * @package Epfremme\Eav\Entity
 */
class IntegerAttribute extends Attribute
{
    /**
     * Attribute Value
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    private $value;

    /**
     * {@inheritdoc}
     */
    public function getValue() : ?int
    {
        return $this->value;
    }

    /**
     * Set Attribute Value
     *
     * @param int $value
     * @return $this|self
     */
    public function setValue(int $value = null) : self
    {
        $this->value = $value;

        return $this;
    }
}
