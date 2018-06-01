<?php
/**
 * @Copyright Ryan Fernandes
 */

namespace Ryan\Testimonials\Model;

use Ryan\Testimonials\Api\TestimonyRepositoryInterface;
use Ryan\Testimonials\Api\Data\TestimonyInterfaceFactory;
use Ryan\Testimonials\Model\TestimonyFactory;
use Ryan\Testimonials\Model\Testimony;
use Ryan\Testimonials\Model\ResourceModel\Testimony as TestimonyResource;
use Ryan\Testimonials\Model\ResourceModel\Testimony\CollectionFactory;
use Ryan\Testimonials\Model\ResourceModel\Testimony\Collection;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Ryan\Testimonials\Api\Data\TestimonySearchResultInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Customer\Api\CustomerRepositoryInterface;

class TestimonyRepository implements TestimonyRepositoryInterface
{

    /**
     * @var TestimonyFactory
     */
    protected $_testimonyFactory;

    /**
     * @var TestimonyInterfaceFactory
     */
    protected $_testimonyInterfaceFactory;

    /**
     * @var TestimonyResource
     */
    protected $_resource;

    /**
     * @var CollectionFactory
     */
    protected $_testimonyCollectionFactory;

    /**
     * @var TestimonySearchResultInterfaceFactory
     */
    protected $_searchResultsFactory;

    /**
     * @var array
     */
    protected $_instancesById = [];

    /**
     * @var DataObjectHelper
     */
    protected $_dataObjectHelper;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepositoryInterface;

    /**
     * @var DataObjectProcessor
     */
    protected $_dataObjectProcessor;

    public function __construct(
        TestimonyFactory $testimonyFactory,
        TestimonyInterfaceFactory $testimonyInterfaceFactory,
        TestimonyResource $resource,
        CollectionFactory $testimonyCollectionFactory,
        TestimonySearchResultInterfaceFactory $testimonySearchResultFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_testimonyFactory = $testimonyFactory;
        $this->_resource = $resource;
        $this->_testimonyCollectionFactory = $testimonyCollectionFactory;
        $this->_searchResultsFactory = $testimonySearchResultFactory;
        $this->_dataObjectHelper = $dataObjectHelper;
        $this->_dataObjectProcessor = $dataObjectProcessor;
        $this->_testimonyInterfaceFactory = $testimonyInterfaceFactory;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * @param  int $customerId
     * @return null|string
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getCustomerNameById($customerId)
    {
        $name = null;

        if ($customerId) {
            $customerId = (int) $customerId;
            $customer = $this->_customerRepositoryInterface->getById($customerId);

            if ($customer && $customer->getId()) {
                $name = $customer->getFirstname();
            }
        }

        return $name;
    }

    /**
     * @param \Ryan\Testimonials\Api\Data\TestimonyInterface $testimony
     * @return \Ryan\Testimonials\Api\Data\TestimonyInterface
     * @throws CouldNotSaveException
     */
    public function save(\Ryan\Testimonials\Api\Data\TestimonyInterface $testimony)
    {
        $name = null;

        try {
            $name = $testimony->getName();
            if (!strlen($name)) {
                $name = ($customerId = $testimony->getCustomerId()) ? $this->_getCustomerNameById($customerId) : null;
            }
            $testimony->setName($name);
            $this->_resource->save($testimony);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save your testimony: %1',
                $exception->getMessage()
            ));
        }
        return $testimony;
    }

    /**
     * @param int $customerId
     * @param \Ryan\Testimonials\Api\Data\TestimonyInterface $testimony
     * @return \Ryan\Testimonials\Api\Data\TestimonyInterface
     * @throws CouldNotSaveException
     */
    public function saveTestimony($customerId, \Ryan\Testimonials\Api\Data\TestimonyInterface $testimony)
    {
        $name = null;

        try {
            if ($customerId) {
                $customerId = (int) $customerId;
                $name = $testimony->getName();
                if (!strlen($name)) {
                    $name = $this->_getCustomerNameById($customerId);
                    $testimony->setName($name);
                }
                $testimony->setCustomerId($customerId);
            }
            $this->_resource->save($testimony);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save your testimony: %1',
                $exception->getMessage()
            ));
        }

        return $this->_testimonyFactory->create()->load($testimony->getId());
    }

    /**
     * @param int $id
     * @param bool $editMode
     * @param bool $forceReload
     * @return \Ryan\Testimonials\Api\Data\TestimonyInterface
     * @throws NoSuchEntityException
     */
    public function getById($id, $editMode = false, $forceReload = false)
    {
        $cacheKey = $this->getCacheKey([$editMode]);
        if (!isset($this->_instancesById[$id][$cacheKey]) || $forceReload) {
            $testimony = $this->_testimonyFactory->create();
            $testimony->load($id);
            if (!$testimony->getId()) {
                throw new NoSuchEntityException(__('Testimony with id "%1" does not exist.', $id));
            }
            $this->_instancesById[$id][$cacheKey] = $testimony;
        }

        return $this->_instancesById[$id][$cacheKey];
    }

    /**
     * @param int $id
     * @return \Ryan\Testimonials\Api\Data\TestimonyInterface
     * @throws NoSuchEntityException
     */
    public function get($id)
    {
        return $this->getById($id);
    }

    /**
     * Get key for cache
     *
     * @param array $data
     * @return string
     */
    protected function getCacheKey($data)
    {
        $serializeData = [];
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $serializeData[$key] = $value->getId();
            } else {
                $serializeData[$key] = $value;
            }
        }

        return md5(serialize($serializeData));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Ryan\Testimonials\Api\Data\TestimonySearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->_searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        /** @var Collection $collection */
        $collection = $this->_testimonyCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrdersData = $criteria->getSortOrders();

        if ($sortOrdersData) {
            foreach ($sortOrdersData as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setCurPage($criteria->getCurrentPage());

        $collection->setPageSize($criteria->getPageSize());

        $testimonyItems = [];
        /** @var Testimony $testimonyModel */
        foreach ($collection as $testimonyModel) {
            $testimonyData = $this->_testimonyInterfaceFactory->create();
            $this->_dataObjectHelper->populateWithArray(
                $testimonyData,
                $testimonyModel->getData(),
                'Ryan\Testimonials\Api\Data\TestimonyInterface'
            );
            $testimonyItems[] = $this->_dataObjectProcessor->buildOutputDataArray(
                $testimonyData,
                'Ryan\Testimonials\Api\Data\TestimonyInterface'
            );
        }
        $searchResults->setItems($testimonyItems);
        return $searchResults;
    }

    /**
     * @param \Ryan\Testimonials\Api\Data\testimonyInterface $testimony
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Ryan\Testimonials\Api\Data\testimonyInterface $testimony)
    {
        try {
            $this->_resource->delete($testimony);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete testimony: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

}