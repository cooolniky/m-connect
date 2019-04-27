<?php namespace App\Repositories\Eloquent;

use App\Repositories\Contract\ShopInterface;
use App\Models\Shop;
use Auth;
use App\Traits\CommonModelTrait;
use App\Helpers\LaraHelpers;


/**
 * Class ShopRepository
 *
 * @package App\Repositories\Eloquent
 */
class ShopRepository implements ShopInterface
{

    use CommonModelTrait;
    /**
     * Get all Shop getCollection
     *
     * @return mixed
     */
    public function getCollection()
    {
        return Shop::where('status',1)->orderBy('name','asc')->get();
    }

    /**
     * Get all Shop with role and ParentShop relationship
     *
     * @return mixed
     */
    public function getDatatableCollection()
    {
        return Shop::select('*');
    }

    /**
     * use for sorting
     *
     * @return array
     */
    public function getSortFields($index)
    {
        $sortableFields = [
            "name",
            "email",
            "",
            "",
            "",
            "status",
            ""
        ];

        return $sortableFields[ $index ];
    }

    /**
     * get Shop By fieldname getShopByField
     *
     * @param mixed $id
     * @param string $field_name
     * @return mixed
     */
    public function getShopByField($id, $field_name)
    {
        return Shop::where($field_name, $id)->first();
    }

    /**
     * Add & update Shop addShop
     *
     * @param array $models
     * @return boolean true | false
     */
    public function addShop($models)
    {
        $filepath = public_path() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'logos' . DIRECTORY_SEPARATOR;

        if (isset($models['id'])) {
            $shop = Shop::find($models['id']);

            if(!empty($models['logo'])) {
                $shop->logo = LaraHelpers::upload_image($filepath, $models['logo'], $models['old_logo']);
            }
        } else {
            $shop = new Shop;
            if(!empty($models['logo'])) {
                $shop->logo = LaraHelpers::upload_image($filepath, $models['logo'], '');
            }
            $shop->created_date = date('Y-m-d H:i:s');
            $shop->created_by = Auth::user()->id;
        }

        $shop->name = $models['name'];
        $shop->email = $models['email'];
        $shop->website = $models['website'];
        if (isset($models['status'])) {
            $shop->status = $models['status'];
        } else {
            $shop->status = 0;
        }

        $shop->last_modified_by = Auth::user()->id;
        $shop->last_modified_date = date('Y-m-d H:i:s');
        $shopId = $shop->save();

        if ($shopId) {
            return $shop;
        } else {
            return false;
        }
    }

    /**
     * update Shop Status
     *
     * @param array $models
     * @return boolean true | false
     */
    public function updateStatus($models)
    {
        $shop = Shop::find($models['id']);
        $shop->status = $models['status'];
        $shop->last_modified_by = Auth::user()->id;
        $shop->last_modified_date = date('Y-m-d H:i:s');
        $shopId = $shop->save();
        if ($shopId)
            return true;
        else
            return false;

    }

    /**
     * Delete Shop
     *
     * @param int $id
     * @return boolean true | false
     */
    public function deleteShop($id)
    {
        $delete = Shop::where('id', $id)->delete();
        if ($delete)
            return true;
        else
            return false;

    }
}
