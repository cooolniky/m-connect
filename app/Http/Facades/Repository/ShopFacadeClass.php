<?php

namespace App\Http\Facades\Repository;
use App\Repositories\Contract\ProductInterface;
use App\Repositories\Contract\ShopInterface;
use Carbon\Carbon;
/**
 * Class ShopFacadeClass
 *
 */
class ShopFacadeClass
{

    protected $shop, $product;
    /**
     * Shop constructor.
     *
     * @param ShopInterface $blockedAdjRepo
     */
    public function __construct(ShopInterface $repo, ProductInterface $productInterface)
    {
        $this->shop = $repo;
        $this->product = $productInterface;
    }

    /**
     * @return mixed
     * @author Nikhil.Jain
     */
    public function view() {
        $data['shopData'] = $this->shop->getCollection();
        $data['masterManagementTab'] = "active open";
        $data['shopTab'] = "active";
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

        // get the fields for shop list
        $shopData = $this->shop->getDatatableCollection();

        // get the filtered data of shop list
        $shopFilteredData = $this->shop->getFilteredData($shopData,$request);

        //  Sorting shop data base on requested sort order
        $shopCount = $this->shop->getCount($shopFilteredData);

        // Sorting shop data base on requested sort order
        if (isset(config('constant.shopDataTableFieldArray')[$request->order['0']['column']])) {
            $shopSortData = $this->shop->getSortData($shopFilteredData,$request);
        } else {
            $shopSortData = $this->shop->getSortDefaultDataByRaw($shopFilteredData,'shop.id', 'desc');
        }

        // get collection of shop
        $shopData = $this->shop->getData($shopSortData,$request);

        $appData = array();
        foreach ($shopData as $shopData) {
            $row = array();
            $row[] = $shopData->name;
            $row[] = $shopData->email;
            if(!empty($shopData->logo)) {
                $row[] = '<img src="'.url('img/logos',[$shopData->logo]).'" class="bm_image" width="100px" height="100px" />';
            } else {
                $row[] = '---';
            }
            $row[] = $shopData->website;
            $row[] = $this->product->getShopCount($shopData->id,'shops');
            $row[] = view('datatable.switch', ['module' => "shop",'status' => $shopData->status, 'id' => $shopData->id])->render();
            $row[] = view('datatable.action', ['module' => "shop",'type' => '2', 'id' => $shopData->id])->render();
            $appData[] = $row;
        }

        return [
            'draw' => $request->draw,
            'recordsTotal' => $shopCount,
            'recordsFiltered' => $shopCount,
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
        $data['shopTab'] = "active";
        $data['shopData'] = $this->shop->getCollection();
        return $data;
    }

    /**
     * Display the specified shop.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     * @author Nikhil.Jain
     */
    public function edit($id)
    {
        $data['details'] = $this->shop->getShopByField($id, 'id');
        $data['shopData'] = $this->shop->getCollection();
        $data['masterManagementTab'] = "active open";
        $data['shopTab'] = "active";
        return $data;
    }

    /**
     * Store and Update shop in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @author Nikhil.Jain
     */
    public function insertAndUpdateShop($requestData) {
        return $this->shop->addShop($requestData);
    }

    /**
     * @param $requestData
     * @return bool
     * @author Nikhil.Jain
     */
    public function updateStatus($requestData) {
        return $this->shop->updateStatus($requestData);
    }

    /**
     * @param $id
     * @return bool
     * @author Nikhil.Jain
     */
    public function deleteShop($id) {
        return $this->shop->deleteShop($id);
    }
}