<?php
/**
 * @Copyright Ryan Fernandes
 */

namespace Ryan\Testimonials\Model;

use Magento\Framework\Model\AbstractModel;
use Ryan\Testimonials\Api\Data\TestimonyInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Testimony extends AbstractModel implements IdentityInterface, TestimonyInterface
{

    protected $_cacheTag = 'ryan_testimonials_testimony';
    protected $_eventPrefix = 'ryan_testimonials_testimony';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Ryan\Testimonials\Model\ResourceModel\Testimony::class);
    }

    /**
     * Identifier getter
     *
     * @return int
     */
    public function getId()
    {
        return $this->_getData(self::ID);
    }

    /**
     * Set entity Id
     *
     * @param int $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setData('entity_id', $value);
    }

    /**
     * Customer Name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * Set Customer Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set Customer ID
     *
     * @return int
     */
    public function getCustomerId()
    {
        return (int) $this->_getData(self::CUSTOMER_ID);
    }

    /**
     * Set entity Id
     *
     * @param int $value
     * @return $this
     */
    public function setCustomerId($value)
    {
        return $this->setData(self::CUSTOMER_ID, $value);
    }

    /**
     * Get Testimony Content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->_getData(self::CONTENT);
    }

    /**
     * Set Testimony Content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set Testimony created date
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set Testimony updated date
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function getIdentities()
    {
        return [$this->_cacheTag . '_' . $this->getId()];
    }

    /**
     * Get Testimony creation date
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * Get previous Testimony update date
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->_getData(self::UPDATED_AT);
    }

}