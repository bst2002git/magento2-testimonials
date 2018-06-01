<?php
/**
 * @Copyright Ryan Fernandes
 */

namespace Ryan\Testimonials\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Testimony extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ryan_customer_testimonials', 'entity_id');
    }

}