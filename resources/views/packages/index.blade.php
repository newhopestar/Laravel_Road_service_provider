@extends('layouts.master')

@section('page-title')
<title>Package</title>
@endsection

@section('page-sub-title')
<p>>>>Packages Table</p>
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
                            <botton  class="btn btn-brand btn-elevate btn-icon-sm" href = "#" data-toggle="modal" data-target="#createPackage">
                                <i class="la la-plus"></i>
                                Add
                            </botton>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" >
                        <table class="table table-striped- table-bordered table-hover table-checkable" id = "package_table">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Packages Name</td>
                                    <td>Packages Cost</td>
                                    <td>Packages Description</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($packages)
                                    @foreach ($packages->all() as $package)
                                    <tr>
                                        <td>{{ $package->id }}</td>
                                        <td>{{ $package->package_name }}</td>
                                        <td>{{ $package->package_cost }}</td>
                                        <td>{{ $package->package_description }}</td>
                                        <td>
                                            <button class="btn-sm btn btn-label-info btn-bold package_edit_button"  
                                                data-id = "{{$package->id ? $package->id : '' }}"
                                                data-name = "{{ $package->package_name ? $package->package_name : '' }}"
                                                data-cost = "{{$package->package_cost ? $package->package_cost : ''}}"
                                                data-description = "{{$package->package_description ? $package->package_description : ''}}"
                                            ><i class="fa fa-edit"></i></button>
                                            <button class="btn-sm btn btn-label-danger btn-bold package_delete_button" 
                                                data-id = "{{ $package->id ? $package->id : '' }}"
                                                data-toggle="modal" data-target="#deletePackage"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Portlet-->

        <!--create modal-->
        <div class="modal fade" id="createPackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action = "{{ url('packages') }}"  enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Package Name</label>
                                    <input type="text" class="form-control" name="package_name" placeholder="Enter Package name" required/>
                                </div>
                                <div class="form-group">
                                    <label>Package Cost</label>
                                    <input type="text" class="form-control" name="package_cost" placeholder="Enter Package Cost" />
                                </div>
                                <div class="form-group">
                                    <label>Package Description</label>
                                    <textarea rows="5" cols="50" class="form-control" name="package_description" placeholder="Enter Package Description"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
             </div>
        </div>

        <!--Edit Modal-->     
        <div class="modal fade" id="editPackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Package</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST"  id = "package_update_form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PUT">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Package Name</label>
                                    <input type="text" class="form-control" id = "package_name_input" name="package_name" placeholder="Enter package name"/>
                                </div>
                                <div class="form-group">
                                    <label>Package Cost</label>
                                    <input type="text" class="form-control" id = "package_cost_input" name="package_cost" placeholder="Enter package cost"/>
                                </div>
                                <div class="form-group">
                                    <label>Package Description</label>
                                    <textarea  rows="5" cols="50" class="form-control" id ="package_description_input" name="package_description" placeholder="Enter package description"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>
        <!--Delete Modal-->     
        <div class="modal fade" id="deletePackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Package</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Really want to delete?</h5>
                    </div>
                    <form method="POST"   id = "package_delete_form" >
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Delete</button>
                        </div>
                    </form>
                </div>
             </div>
        </div>
    </div>
</div>


@endsection

@section('page-js')
<script src="{{ asset('plugins/datatable/datatable.bundle.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.package_edit_button').on('click', function(){
            var package_id = $(this).data('id');
            var package_name = $(this).data('name');
            var package_cost = $(this).data('cost');
            var package_description = $(this).data('description');
            $('#package_name_input').val(package_name);
            $('#package_cost_input').val(package_cost);
            $('#package_description_input').val(package_description);
            $('#package_update_form').attr('action', "/packages/" + package_id);
            $('#editPackage').modal('show');
        })
        $('.package_delete_button').on('click', function(){
            var package_id = $(this).data('id');
            $('#package_delete_form').attr('action', "/packages/" + package_id);
         })
         $('#packages_table').DataTable({
             "responsive": true,
         })
    })
</script>
@endsection
