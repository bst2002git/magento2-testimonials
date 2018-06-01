<?php
/**
 * @Copyright Ryan Fernandes
 */
namespace Ryan\Testimonials\Api;

interface TestimonyRepositoryInterface
{
    /**
     * @param \Ryan\Testimonials\Api\Data\TestimonyInterface $testimony
     * @return \Ryan\Testimonials\Api\Data\TestimonyInterface
     */
    public function save(\Ryan\Testimonials\Api\Data\TestimonyInterface $testimony);

    /**
     * @param int $customerId
     * @param \Ryan\Testimonials\Api\Data\TestimonyInterface $testimony
     * @return \Ryan\Testimonials\Api\Data\TestimonyInterface
     */
    public function saveTestimony($customerId, \Ryan\Testimonials\Api\Data\TestimonyInterface $testimony);

    /**
     * @param int $id
     * @return \Ryan\Testimonials\Api\Data\TestimonyInterface
     */
    public function getById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Ryan\Testimonials\Api\Data\TestimonySearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param \Ryan\Testimonials\Api\Data\TestimonyInterface $testimonial
     * @return bool
     */
    public function delete(\Ryan\Testimonials\Api\Data\TestimonyInterface $testimonial);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

}