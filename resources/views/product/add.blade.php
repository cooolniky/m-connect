@extends('layouts.common')
@section('pageTitle')
    {{__('app.default_add_title',["app_name" => __('app.app_name'),"module"=> __('app.product')])}}
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
                <li class="active">{{trans('app.add')}} {{trans('app.product')}}</li>
            </ol>
        </div>
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                        <div class="panel-heading panel-heading-divider">{{trans('app.add')}} {{trans('app.product')}}</div>
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
                            <form action="{{url('/product/store')}}" name="app_add_form" id="app_form" enctype="multipart/form-data" style="border-radius: 0px;" method="post" class="form-horizontal group-border-dashed">

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Name <span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="name" id="name" placeholder="Name" class="form-control input-sm required" value="{{old('name')}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">SKU <span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="sku" id="sku" placeholder="SKU" class="form-control input-sm required" value="{{old('sku')}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Description <span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <textarea name="description" id="description" placeholder="Description" class="form-control input-sm required">{{old('description')}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group shop_div">
                                    <label class="col-sm-4 control-label">{{trans('app.select')}} {{trans('app.shop')}} </label>
                                    <div class="col-sm-6 col-md-4">
                                        <select class="form-control input-sm" name="shops[]" multiple id="shops">
                                            @if(count($shopData) > 0)
                                                @foreach($shopData as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Quantity </label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="qty" id="qty" placeholder="Quantity" class="form-control input-sm number" value="{{old('qty')}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Image </label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="file" name="image" id="image" placeholder="Image" class="form-control input-sm" value="{{old('image')}}" />
                                        <span style="margin-top: 10px;">Note: Minimum dimension of Image (100x100)</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Status<span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">

                                        <div class="switch-button switch-button-lg">
                                             <input name="status" id="swt1" checked type="checkbox" value="1" />
                                             <span>
                                                 <label for="swt1"></label>
                                             </span>
                                         </div>
                                    </div>
                                </div>

                                {{ csrf_field() }}

                                <div class="col-sm-6 col-md-8 savebtn">
                                    <p class="text-right">
                                        <button type="submit" class="btn btn-space btn-info btn-lg">{{trans('app.add')}} {{trans('app.product')}}</button>
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
<script type="text/javascript">
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