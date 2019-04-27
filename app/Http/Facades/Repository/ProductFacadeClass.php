<?php

namespace App\Http\Facades\Repository;
use App\Repositories\Contract\ProductInterface;
use App\Repositories\Contract\ShopInterface;
use Carbon\Carbon;
/**
 * Class ProductFacadeClass
 *
 */
class ProductFacadeClass
{

    protected $product,$shop;
    /**
     * Product constructor.
     *
     * @param ProductInterface $blockedAdjRepo
     */
    public function __construct(ProductInterface $repo, ShopInterface $shopInterface)
    {
        $this->product = $repo;
        $this->shop = $shopInterface;
    }

    /**
     * @return mixed
     * @author Nikhil.Jain
     */
    public function view() {
        $data['shopData'] = $this->shop->getCollection();
        $data['masterManagementTab'] = "active open";
        $data['productTab'] = "active";
        return $data;
    }

    /**
     * @param $request
     * @return array
     * @throws \Exception
     * @throws \Throwable
     * @author Nikhil.Jain
     */
    public function getDataTable($request) {

        // get the fields for product list
        $productData = $this->product->getDatatableCollection();

        // get the filtered data of product list
        $productFilteredData = $this->product->getFilteredData($productData,$request);

        //  Sorting product data base on requested sort order
        $productCount = $this->product->getCount($productFilteredData);

        // Sorting product data base on requested sort order
        if (isset(config('constant.productDataTableFieldArray')[$request->order['0']['column']])) {
            $productSortData = $this->product->getSortData($productFilteredData,$request);
        } else {
            $productSortData = $this->product->getSortDefaultDataByRaw($productFilteredData,'product.id', 'desc');
        }

        // get collection of product
        $productData = $this->product->getData($productSortData,$request);

        $appData = array();
        foreach ($productData as $productData) {
            $row = array();
            $row[] = $productData->name;
            $row[] = $productData->sku;
            $row[] = $productData->description;
            $row[] = $productData->shop_names;
            $row[] = $productData->qty;
            if(!empty($productData->image)) {
                $row[] = '<img src="'.url('img/image',[$productData->image]).'" class="bm_image" width="100px" height="100px" />';
            } else {
                $row[] = '---';
            }
            $row[] = view('datatable.switch', ['module' => "product",'status' => $productData->status, 'id' => $productData->id])->render();
            $row[] = view('datatable.action', ['module' => "product",'type' => '2', 'id' => $productData->id])->render();
            $appData[] = $row;
        }

        return [
            'draw' => $request->draw,
            'recordsTotal' => $productCount,
            'recordsFiltered' => $productCount,
            'data' => $appData,
        ];
    }

    /**
     * @param $dob
     * @return string
     * @author Nikhil.Jain
     */
    public function getAge($dob) {
        $years = Carbon::parse($dob)->age. " year old";
        return $years;
    }

    /**
     * @return mixed
     * @author Nikhil.Jain
     */
    public function create() {
        $data['masterManagementTab'] = "active open";
        $data['productTab'] = "active";
        $data['shopData'] = $this->shop->getCollection();
        return $data;
    }

    /**
     * Display the specified product.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     * @author Nikhil.Jain
     */
    public function edit($id)
    {
        $data['details'] = $this->product->getProductByField($id, 'id');
        $data['shopData'] = $this->shop->getCollection();
        $data['masterManagementTab'] = "active open";
        $data['productTab'] = "active";
        return $data;
    }

    /**
     * Store and Update product in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @author Nikhil.Jain
     */
    public function insertAndUpdateProduct($requestData) {
        return $this->product->addProduct($requestData);
    }

    /**
     * @param $requestData
     * @return bool
     * @author Nikhil.Jain
     */
    public function updateStatus($requestData) {
        return $this->product->updateStatus($requestData);
    }

    /**
     * @param $id
     * @return bool
     * @author Nikhil.Jain
     */
    public function deleteProduct($id) {
        return $this->product->deleteProduct($id);
    }
}