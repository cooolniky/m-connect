@extends('layouts.common')
@section('pageTitle')
    {{__('app.default_edit_title',["app_name" => __('app.app_name'),"module"=> __('app.shop')])}}
@endsection
@push('externalCssLoad')
@endpush
@push('internalCssLoad')
@endpush
@section('content')
    <div class="be-content">
            <div class="page-head">
            <h2>{{trans('app.shop')}} {{trans('app.management')}}</h2>
            <ol class="breadcrumb">
                <li><a href="{{url('/dashboard')}}">{{trans('app.admin_home')}}</a></li>
                <li><a href="{{url('/shop/list')}}">{{trans('app.shop')}} {{trans('app.management')}}</a></li>
                <li class="active">{{trans('app.edit')}} {{trans('app.shop')}}</li>
            </ol>
        </div>
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                        <div class="panel-heading panel-heading-divider">{{trans('app.edit')}} {{trans('app.shop')}}</div>
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
                            <form action="{{url('/shop/update')}}" name="app_edit_form" id="app_form" style="border-radius: 0px;" enctype="multipart/form-data" method="post" class="form-horizontal group-border-dashed">

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Name <span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="name" id="name" placeholder="Name" class="form-control input-sm required" value="{{$details->name}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="email" id="email" placeholder="Email Address" class="form-control input-sm email" value="{{$details->email}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Logo</label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="file" name="logo" id="logo" placeholder="Logo" class="form-control input-sm" value="" />
                                        <span style="margin-top: 10px;">Note: Minimum dimension of Logo (100x100)</span>

                                        <input type="hidden" name="old_logo" value="{{$details->logo}}" id="old_logo" />
                                        @if(!empty($details->logo))
                                            <img src="{{url('img/logos',[$details->logo])}}" class="bm_image" width="100px" height="100px" />
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Website </label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="website" id="website" placeholder="Website" class="form-control input-sm url" value="{{$details->website}}" />
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
                                        <button type="submit" class="btn btn-space btn-info btn-lg">Update {{trans('app.shop')}}</button>
                                        <a href="{{url('/shop/list')}}" class="btn btn-space btn-danger btn-lg">Cancel</a>
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
@endpush
@push('internalJsLoad')
<script type="text/javascript">
        app.validate.init();
</script>
@endpush