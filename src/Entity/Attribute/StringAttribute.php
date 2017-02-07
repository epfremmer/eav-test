<?php
/**
 * File StringAttribute.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Attribute;

/**
 * Class StringAttribute
 *
 * @ORM\Entity()
 * @ORM\Table("string_attribute")
 *
 * @package Epfremme\Eav\Entity
 */
class StringAttribute extends Attribute
{
    /**
     * Attribute Value
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $value;

    /**
     * Attribute constructor
     *
     * @param string $value
     */
    public function __construct(string $value = null)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * Set Attribute Value
     *
     * @param string $value
     * @return $this|self
     */
    public function setValue(string $value) : self
    {
        $this->value = $value;

        return $this;
    }
}
