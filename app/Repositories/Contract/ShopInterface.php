<?php namespace App\Repositories\Contract;

/**
 * Interface ShopInterface
 * @package App\Repositories\Contract
 */
interface ShopInterface
{
    /**
     *  Get the fields for shop list
     *
     * @return mixed
     */
    public function getCollection();

    /**
     *  Get the fields for shop list
     *
     * @return mixed
     */
    public function getDatatableCollection();

    /**
     * get Shop By fieldname getShopByField
     *
     * @param mixed $id
     * @param string $field_name
     * @return mixed
     */
    public function getShopByField($id, $field_name);

    /**
     * Add & update Shop addShop
     *
     * @param array $models
     * @return boolean true | false
     */
    public function addShop($models);

    /**
     * update Shop Status
     *
     * @param array $models
     * @return boolean true | false
     */
    public function updateStatus($models);

    /**
     * Delete Shop
     *
     * @param int $id
     * @return boolean true | false
     */
    public function deleteShop($id);
}
