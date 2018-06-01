<?php
/**
 * @Copyright Ryan Fernandes
 */

namespace Ryan\Testimonials\Model\ResourceModel\Testimony;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ryan\Testimonials\Model\Testimony', 'Ryan\Testimonials\Model\ResourceModel\Testimony');
    }
}