@extends('layouts.common')
@section('pageTitle')
    {{__('app.default_edit_title',["app_name" => __('app.app_name'),"module"=> __('app.product')])}}
@endsection
@push('externalCssLoad')
<link rel="stylesheet" href="{{url('css/plugins/bootstrap-multiselect.css')}}" type="text/css"/>
@endpush
@push('internalCssLoad')
<style>
    .shop_div .btn-group{width: 100% !important;}
    .shop_div .btn-group .multiselect.dropdown-toggle{width: 100%;}
    .shop_div .btn-group .multiselect.dropdown-toggle .multiselect-selected-text{text-align: left;}
</style>
@endpush
@section('content')
    <div class="be-content">
            <div class="page-head">
            <h2>{{trans('app.product')}} {{trans('app.management')}}</h2>
            <ol class="breadcrumb">
                <li><a href="{{url('/dashboard')}}">{{trans('app.admin_home')}}</a></li>
                <li><a href="{{url('/product/list')}}">{{trans('app.product')}} {{trans('app.management')}}</a></li>
                <li class="active">{{trans('app.edit')}} {{trans('app.product')}}</li>
            </ol>
        </div>
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                        <div class="panel-heading panel-heading-divider">{{trans('app.edit')}} {{trans('app.product')}}</div>
                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{url('/product/update')}}" name="app_edit_form" id="app_form" style="border-radius: 0px;" enctype="multipart/form-data" method="post" class="form-horizontal group-border-dashed">

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Name <span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="name" id="name" placeholder="Name" class="form-control input-sm required" value="{{$details->name}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">SKU <span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="sku" id="sku" placeholder="SKU" class="form-control input-sm required" value="{{$details->sku}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Description <span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <textarea name="description" id="description" placeholder="Description" class="form-control input-sm required">{{$details->description}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group shop_div">
                                    <label class="col-sm-4 control-label">{{trans('app.select')}} {{trans('app.shop')}}</label>
                                    <div class="col-sm-6 col-md-4">
                                        <select class="form-control input-sm" name="shops[]" multiple id="shops">
                                            @if(count($shopData) > 0)
                                                @foreach($shopData as $row)
                                                    <option value="{{$row->id}}" @if(in_array($row->id,explode(",",$details->shops))) {{"selected"}} @endif>{{$row->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Quantity </label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="qty" id="qty" placeholder="qty" class="form-control input-sm number" value="{{$details->qty}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Image </label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="file" name="image" id="image" placeholder="Image" class="form-control input-sm" value="" />
                                        <span style="margin-top: 10px;">Note: Minimum dimension of Image (100x100)</span>
                                        <input type="hidden" name="old_image" value="{{$details->image}}" id="old_image" />
                                        @if(!empty($details->image))
                                            <img src="{{url('img/image',[$details->image])}}" class="bm_image" width="100px" height="100px" />
                                        @endif
                                    </div>
                                </div>

                                <?php
                                    $status_check = "";
                                    if ($details->status == '1') {
                                        $status_check = "checked";
                                    }
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Status<span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="switch-button switch-button-lg">
                                            <input name="status" id="swt1" {{$status_check}} type="checkbox" value="1" />
                                            <span>
                                                 <label for="swt1"></label>
                                             </span>
                                        </div>
                                    </div>
                                </div>

                                {{ csrf_field() }}
                                <input type="hidden" name="id" id="id" value="{{$details->id}}" />
                                <div class="col-sm-6 col-md-8 savebtn">
                                    <p class="text-right">
                                        <button type="submit" class="btn btn-space btn-info btn-lg">Update {{trans('app.product')}}</button>
                                        <a href="{{url('/product/list')}}" class="btn btn-space btn-danger btn-lg">Cancel</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('externalJsLoad')
<script src="{{url('js/plugins/bootstrap-multiselect.js')}}"></script>
@endpush
@push('internalJsLoad')
<script>
    app.validate.init();
    $("#shops").multiselect({
        allSelectedText: 'All',
        includeSelectAllOption: true,
        maxHeight: 400,
        disableIfEmpty: true,
        enableFiltering: true,
        nonSelectedText: "- None -",
        enableCaseInsensitiveFiltering: true
    });
</script>
@endpush