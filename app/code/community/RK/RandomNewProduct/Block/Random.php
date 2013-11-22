<?php

class RK_RandomNewProduct_Block_Random extends Mage_Core_Block_Template
{

    protected function _construct()
    {
        $this->addData(array(
            'cache_lifetime'    => Mage::getStoreConfig('catalog/randomnewproduct/cache_lifetime'),
            'cache_tags'        => array(Mage_Catalog_Model_Product::CACHE_TAG),
        ));
    }

    /**
     * @var Mage_Catalog_Model_Product
     */
    protected $_product;

    /**
     * @param bool $forceReload
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct($forceReload = false)
    {
        if (!$this->_product || $forceReload) {
            $_items = Mage::getResourceModel('catalog/product_collection')
                ->addOrder('created_at', Varien_Data_Collection::SORT_ORDER_DESC)
                ->setPageSize(Mage::getStoreConfig('catalog/randomnewproduct/max_new_products_pool'))
                ->getItems();

            $_product = $_items[array_rand($_items)];
            $this->_product = Mage::getModel('catalog/product')->load($_product->getId());
        }

        return $this->_product;
    }

}