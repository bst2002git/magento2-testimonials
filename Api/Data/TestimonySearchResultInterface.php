<?php
/**
 * @Copyright Ryan Fernandes
 */
namespace Ryan\Testimonials\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TestimonySearchResultInterface extends SearchResultsInterface
{
    /**
     * Get test Complete list.
     *
     * @return \Ryan\Testimonials\Api\Data\TestimonyInterface[]
     */
    public function getItems();

    /**
     * Set test Complete list.
     *
     * @param \Ryan\Testimonials\Api\Data\TestimonyInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}