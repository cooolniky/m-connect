<?php namespace App\Repositories\Eloquent;

use App\Repositories\Contract\ProductInterface;
use App\Models\Product;
use Auth;
use App\Traits\CommonModelTrait;
use App\Helpers\LaraHelpers;
use DB;


/**
 * Class ProductRepository
 *
 * @package App\Repositories\Eloquent
 */
class ProductRepository implements ProductInterface
{

    use CommonModelTrait;
    /**
     * Get all Product getCollection
     *
     * @return mixed
     */
    public function getCollection()
    {
        return Product::where('status',1)->orderBy('name','asc')->get();
    }

    /**
     * Get all Product with role and ParentProduct relationship
     *
     * @return mixed
     */
    public function getDatatableCollection()
    {
        return Product::select('product.*',\DB::raw("GROUP_CONCAT(shop.name) as shop_names"))->leftjoin("shop",\DB::raw("FIND_IN_SET(shop.id,product.shops)"),">",\DB::raw("'0'"))->groupBy("product.id");
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
            "sku",
            "",
            "",
            "qty",
            "",
            "status",
            ""
        ];

        return $sortableFields[ $index ];
    }

    /**
     * get Product By fieldname getProductByField
     *
     * @param mixed $id
     * @param string $field_name
     * @return mixed
     */
    public function getProductByField($id, $field_name)
    {
        return Product::where($field_name, $id)->first();
    }

    /**
     * Add & update Product addProduct
     *
     * @param array $models
     * @return boolean true | false
     */
    public function addProduct($models)
    {
        $filepath = public_path() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;

        if (isset($models['id'])) {
            $product = Product::find($models['id']);

            if(!empty($models['image'])) {
                $product->image = LaraHelpers::upload_image($filepath, $models['image'], $models['old_image']);
            }
        } else {
            $product = new Product;
            if(!empty($models['image'])) {
                $product->image = LaraHelpers::upload_image($filepath, $models['image'], '');
            }
            $product->created_date = date('Y-m-d H:i:s');
            $product->created_by = Auth::user()->id;
        }

        $product->name = $models['name'];
        $product->sku = $models['sku'];
        $product->description = $models['description'];
        $product->qty = $models['qty'];
        $product->shops = !empty($models['shops']) ? implode(",",$models['shops']) : '';
        if (isset($models['status'])) {
            $product->status = $models['status'];
        } else {
            $product->status = 0;
        }

        $product->last_modified_by = Auth::user()->id;
        $product->last_modified_date = date('Y-m-d H:i:s');
        $productId = $product->save();

        if ($productId) {
            return $product;
        } else {
            return false;
        }
    }

    /**
     * update Product Status
     *
     * @param array $models
     * @return boolean true | false
     */
    public function updateStatus($models)
    {
        $product = Product::find($models['id']);
        $product->status = $models['status'];
        $product->last_modified_by = Auth::user()->id;
        $product->last_modified_date = date('Y-m-d H:i:s');
        $productId = $product->save();
        if ($productId)
            return true;
        else
            return false;

    }

    /**
     * Delete Product
     *
     * @param int $id
     * @return boolean true | false
     */
    public function deleteProduct($id)
    {
        $delete = Product::where('id', $id)->delete();
        if ($delete)
            return true;
        else
            return false;

    }

    /**
     * @param $id
     * @param $field
     * @return int
     * @author Nikhil.Jain
     */
    public function getShopCount($id,$field) {
        return Product::whereRaw('FIND_IN_SET(' . trim($id) . ',' . $field . ')')->count();
    }
}
