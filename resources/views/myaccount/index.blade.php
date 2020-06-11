@extends('layouts.master')

@section('page-title')
<title>myaccount</title>
@endsection

@section('page-sub-title')
<p>>>>My Account</p>
@endsection

@section('page-css')
     <link href="{{ asset('plugins/datatable/datatable.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('message'))
    <div class="alert alert-success">
        {{  session('message') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger">
        {{  session('error') }}
    </div>
@endif
<div class="row">
    <input type = "hidden">
    <div class="col-md-12" style = "margin:auto">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <h5>please edit and submit</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" >
                        <form class="form" method="POST" id = "myaccount_update_form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PUT">
                            <div class="card-body">
                                <div class="mb-15">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">First Name:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="first_name" value="<?php echo auth()->user()->first_name; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Last Name:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="last_name" value="<?php echo auth()->user()->last_name; ?>"  />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Phone Mobile:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="phone_mobile" value="<?php echo auth()->user()->phone_mobile; ?>"  />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Phone Home:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="phone_home" value="<?php echo auth()->user()->phone_home; ?>"  />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Phone Work:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="phone_work" value="<?php echo auth()->user()->phone_work; ?>"  />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Type:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="type" readOnly value="<?php echo auth()->user()->type; ?>"  />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Email:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="email" value="<?php echo auth()->user()->email; ?>"  />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Password:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="password" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Confirm Password:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="c_password" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.location='{{ url("users") }}'" >Close</button>
                                <button type="submit" class="btn btn-primary font-weight-bold account_update"  data-id = "<?php echo auth()->user()->id; ?>">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Portlet--> 
    </div>
</div>


@endsection

@section('page-js')
<script src="{{ asset('plugins/datatable/datatable.bundle.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.account_update').on('click', function(){
            var account_id = $(this).data('id');
            $('#myaccount_update_form').attr('action', "/users/" + account_id);
        })
       
    })
</script>
@endsection
