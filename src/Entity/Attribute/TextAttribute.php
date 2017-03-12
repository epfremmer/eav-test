<?php
/**
 * File TextAttribute.php
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
 * @ORM\Table("text_attribute")
 *
 * @package Epfremme\Eav\Entity
 */
class TextAttribute extends Attribute
{
    /**
     * Attribute Value
     *
     * @ORM\Column(type="text", nullable=true)
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
