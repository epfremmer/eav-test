<?php
/**
 * File DateAttribute.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace Epfremme\Eav\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Epfremme\Eav\Entity\Attribute;

/**
 * Class DateAttribute
 *
 * @ORM\Entity()
 * @ORM\Table("date_attribute")
 *
 * @package Epfremme\Eav\Entity
 */
class DateAttribute extends Attribute
{
    /**
     * Attribute Value
     *
     * @ORM\Column(type="date", nullable=true)
     *
     * @var \DateTime
     */
    private $value;

    /**
     * Attribute constructor
     *
     * @param \DateTime $value
     */
    public function __construct(\DateTime $value = null)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue() : \DateTime
    {
        return $this->value;
    }

    /**
     * Set Attribute Value
     *
     * @param \DateTime $value
     * @return $this|self
     */
    public function setValue(\DateTime $value) : self
    {
        $this->value = $value;

        return $this;
    }
}
