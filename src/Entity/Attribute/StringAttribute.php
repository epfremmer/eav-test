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
     * {@inheritdoc}
     */
    public function getValue() : ?string
    {
        return $this->value;
    }

    /**
     * Set Attribute Value
     *
     * @param string $value
     * @return $this|self
     */
    public function setValue(string $value = null) : self
    {
        $this->value = $value;

        return $this;
    }
}
