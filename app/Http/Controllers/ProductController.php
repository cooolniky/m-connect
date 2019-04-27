<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Product;
use DB;

class ProductController extends Controller
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
     * Display a listing of the product.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = Product::view();
        return view('product.list', $viewData);
    }

    /**
     * @param Request $request
     * @return mixed
     * @author Nikhil.Jain
     */
    public function datatable(Request $request)
    {
        return Product::getDataTable($request);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formData = Product::create();
        return view('product.add', $formData);
    }

    /**
     * Display the specified product.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editFormData = Product::edit($id);
        return view('product.edit', $editFormData);
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
            'name' => 'required',
            'description' => 'required',
            'sku' => 'required|unique:product,sku|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100'
        ];
        if ($mode == "edit") {
            $rules['sku'] = 'required|unique:product,sku,'.$data['id'].',id|max:100';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errorRedirectUrl = "product/add";
            if ($mode == "edit") {
                $errorRedirectUrl = "product/edit/" . $data['id'];
            }
            return redirect($errorRedirectUrl)->withInput()->withErrors($validator);
        }
        return false;
    }

    /**
     * Store a newly created product in storage.
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
            $addproduct = Product::insertAndUpdateProduct($request->all());
            DB::commit();
        } catch (\Exception $e) {
            //exception handling
            DB::rollback();
            $errorMessage = $e->getMessage();
            $request->session()->flash('alert-danger', $errorMessage);
            return redirect('product/add')->withInput();

        }
        if ($addproduct) {
            $request->session()->flash('alert-success', __('app.default_add_success',["module" => __('app.product')]));
            return redirect('product/list');
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.product'),"action"=>__('app.add')]));
            return redirect('product/add')->withInput();
        }
    }

    /**
     * Update the specified product in storage.
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
            $updateproduct = Product::insertAndUpdateProduct($request->all());
            DB::commit();
        } catch (\Exception $e) {
            //exception handling
            DB::rollback();
            $errorMessage = $e->getMessage();
            $request->session()->flash('alert-danger', $errorMessage);
            return redirect('product/edit/' . $request->get('id'))->withInput();

        }

        if ($updateproduct) {

            //  if change_redirect_state  exists then product redirect to product profile
            if(!empty($request->change_redirect_state) && $request->change_redirect_state == 1){
                $request->session()->flash('alert-success', trans('app.product_profile_update_success'));
                return redirect('product/profile');
            }
            $request->session()->flash('alert-success', __('app.default_edit_success',["module" => __('app.product')]));
            return redirect('product/list');
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.product'),"action"=>__('app.update')]));
            return redirect('product/edit/' . $request->get('id'))->withInput();
        }
    }

    /**
     * Update status to the specified product in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(request $request)
    {
        // Start Communicate with database
        DB::beginTransaction();
        try{
            $updateProduct = Product::updateStatus($request->all());
            DB::commit();
        } catch (\Exception $e) {
            //exception handling
            DB::rollback();
        }

        if ($updateProduct) {
            $request->session()->flash('alert-success', __('app.default_status_success',["module" => __('app.product')]));
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.product'),"action"=>__('app.change_status')]));
        }
        echo 1;
    }

    /**
     * Delete the specified product in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function delete(request $request)
    {
        $deleteProduct = Product::deleteProduct($request->id);
        if ($deleteProduct) {
            $request->session()->flash('alert-success', __('app.default_delete_success',["module" => __('app.product')]));
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.product'),"action"=>__('app.delete')]));
        }
        echo 1;
    }
}
