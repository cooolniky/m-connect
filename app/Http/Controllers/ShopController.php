<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Shop;
use DB;

class ShopController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the shop.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = Shop::view();
        return view('shop.list', $viewData);
    }

    /**
     * @param Request $request
     * @return mixed
     * @author Nikhil.Jain
     */
    public function datatable(Request $request)
    {
        return Shop::getDataTable($request);
    }

    /**
     * Show the form for creating a new shop.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formData = Shop::create();
        return view('shop.add', $formData);
    }

    /**
     * Display the specified shop.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editFormData = Shop::edit($id);
        return view('shop.edit', $editFormData);
    }

    /**
     * Validation of add and edit action customeValidate
     *
     * @param array $data
     * @param string $mode
     * @return mixed
     */
    public function customeValidate($data, $mode)
    {
        $rules = [
            'name' => 'required|unique:shop,name|max:100',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100'
        ];
        if ($mode == "edit") {
            $rules['name'] = 'required|unique:shop,name,'.$data['id'].',id|max:100';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errorRedirectUrl = "shop/add";
            if ($mode == "edit") {
                $errorRedirectUrl = "shop/edit/" . $data['id'];
            }
            return redirect($errorRedirectUrl)->withInput()->withErrors($validator);
        }
        return false;
    }

    /**
     * Store a newly created shop in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {

        $validations = $this->customeValidate($request->all(), 'add');
        if ($validations) {
            return $validations;
        }

        // Start Communicate with database
        DB::beginTransaction();
        try{
            $addshop = Shop::insertAndUpdateShop($request->all());
            DB::commit();
        } catch (\Exception $e) {
            //exception handling
            DB::rollback();
            $errorMessage = $e->getMessage();
            $request->session()->flash('alert-danger', $errorMessage);
            return redirect('shop/add')->withInput();

        }
        if ($addshop) {
            $request->session()->flash('alert-success', __('app.default_add_success',["module" => __('app.shop')]));
            return redirect('shop/list');
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.shop'),"action"=>__('app.add')]));
            return redirect('shop/add')->withInput();
        }
    }

    /**
     * Update the specified shop in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(request $request)
    {
        $validations = $this->customeValidate($request->all(), 'edit');
        if ($validations) {
            return $validations;
        }

        // Start Communicate with database
        DB::beginTransaction();
        try{
            $updateshop = Shop::insertAndUpdateShop($request->all());
            DB::commit();
        } catch (\Exception $e) {
            //exception handling
            DB::rollback();
            $errorMessage = $e->getMessage();
            $request->session()->flash('alert-danger', $errorMessage);
            return redirect('shop/edit/' . $request->get('id'))->withInput();

        }

        if ($updateshop) {

            //  if change_redirect_state  exists then shop redirect to shop profile
            if(!empty($request->change_redirect_state) && $request->change_redirect_state == 1){
                $request->session()->flash('alert-success', trans('app.shop_profile_update_success'));
                return redirect('shop/profile');
            }
            $request->session()->flash('alert-success', __('app.default_edit_success',["module" => __('app.shop')]));
            return redirect('shop/list');
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.shop'),"action"=>__('app.update')]));
            return redirect('shop/edit/' . $request->get('id'))->withInput();
        }
    }

    /**
     * Update status to the specified shop in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(request $request)
    {
        // Start Communicate with database
        DB::beginTransaction();
        try{
            $updateShop = Shop::updateStatus($request->all());
            DB::commit();
        } catch (\Exception $e) {
            //exception handling
            DB::rollback();
        }

        if ($updateShop) {
            $request->session()->flash('alert-success', __('app.default_status_success',["module" => __('app.shop')]));
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.shop'),"action"=>__('app.change_status')]));
        }
        echo 1;
    }

    /**
     * Delete the specified shop in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function delete(request $request)
    {
        $deleteShop = Shop::deleteShop($request->id);
        if ($deleteShop) {
            $request->session()->flash('alert-success', __('app.default_delete_success',["module" => __('app.shop')]));
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.shop'),"action"=>__('app.delete')]));
        }
        echo 1;
    }
}
