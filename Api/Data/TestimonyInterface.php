<?php
/**
 * @Copyright Ryan Fernandes
 */
namespace Ryan\Testimonials\Api\Data;

use \Magento\Framework\Api\ExtensibleDataInterface;

interface TestimonyInterface extends ExtensibleDataInterface
{
    /**#@+
     * Constants defined for keys of  data array
     */

    const ID = 'entity_id';

    const CONTENT = 'content';

    const CUSTOMER_ID = 'customer_id';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    const NAME = 'name';

    /**
     * Identifier getter
     *
     * @return int
     */
    public function getId();

    /**
     * Testimony Content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Set Testimony Content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Customer Name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set Customer Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Set Testimony created date
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Testimony updated date
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Testimony Created date
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Testimony Set Customer Id
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Testimony Get Customer Id
     *
     * @return int
     */
    public function getCustomerId();
}