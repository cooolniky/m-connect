<?php namespace App\Repositories\Contract;

/**
 * Interface ProductInterface
 * @package App\Repositories\Contract
 */
interface ProductInterface
{
    /**
     *  Get the fields for product list
     *
     * @return mixed
     */
    public function getCollection();

    /**
     *  Get the fields for product list
     *
     * @return mixed
     */
    public function getDatatableCollection();

    /**
     * get Product By fieldname getProductByField
     *
     * @param mixed $id
     * @param string $field_name
     * @return mixed
     */
    public function getProductByField($id, $field_name);

    /**
     * Add & update Product addProduct
     *
     * @param array $models
     * @return boolean true | false
     */
    public function addProduct($models);

    /**
     * update Product Status
     *
     * @param array $models
     * @return boolean true | false
     */
    public function updateStatus($models);

    /**
     * Delete Product
     *
     * @param int $id
     * @return boolean true | false
     */
    public function deleteProduct($id);
}
