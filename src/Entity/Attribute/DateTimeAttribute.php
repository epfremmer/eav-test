<?php
/**
 * File DateTimeAttribute.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Attribute;

/**
 * Class DateTimeAttribute
 *
 * @ORM\Entity()
 * @ORM\Table("datetime_attribute")
 *
 * @package Epfremme\Eav\Entity
 */
class DateTimeAttribute extends Attribute
{
    /**
     * Attribute Value
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $value;

    /**
     * {@inheritdoc}
     */
    public function getValue() : ?\DateTime
    {
        return $this->value;
    }

    /**
     * Set Attribute Value
     *
     * @param \DateTime $value
     * @return $this|self
     */
    public function setValue(\DateTime $value = null) : self
    {
        $this->value = $value;

        return $this;
    }
}
