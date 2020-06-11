@extends('layouts.master')

@section('page-title')
<title>Order</title>
@endsection

@section('page-sub-title')
<p>>>>Orders Table</p>
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
                            <botton  class="btn btn-brand btn-elevate btn-icon-sm" href = "#" data-toggle="modal" data-target="#createOrder">
                                <i class="la la-plus"></i>
                                Create New Order
                            </botton>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" >
                        <table class="table table-striped- table-bordered table-hover table-checkable" id = "order_table">
                            <thead>
                                <tr>
                                    <td>Order ID</td>
                                    <td>Customers</td>
                                    <td>Order Date</td>
                                    <td>Package</td>
                                    <td>Sevice Period</td>
                                    <td>Expiration Date</td>
                                    <td>Notes</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders)
                                    @foreach ($orders->all() as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order && $order->user->first_name ? $order->user->first_name: '' }}</td>
                                        <td>{{ $order->order_date }}</td>
                                        <td>{{ $order && $order->package->package_name ? $order->package->package_name: '' }}</td>
                                        <td>{{ $order->service_period}}</td>
                                        <td>{{ $order->expiration_date}}</td>
                                        <td>{{ $order->notes }}</td>
                                        <td>
                                            <button class="btn-sm btn btn-label-danger btn-bold order_delete_button" 
                                                data-id = "{{ $order->id ? $order->id : '' }}"
                                                data-toggle="modal" data-target="#deleteOrder"><i class="fa fa-trash"></i></button>
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
        <div class="modal fade" id="createOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action = "{{ url('orders') }}"  enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>User</label>
                                    <select class="form-control" name="user_id" id="exampleSelect1">
                                    @if($users && count($users) > 0 ) 
                                        @foreach($users as $user) 
                                        <option value = "{{ $user && $user->id ? $user->id : ''}}" > {{ $user && $user->first_name ? $user->first_name : ''}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Order Date</label>
                                    <input type="text" class="form-control" name="order_date" id="order_datetimepicker"  placeholder="Enter Order Date" autocomplete = "off" disabled/>
                                </div>
                                <div class="form-group">
                                    <label>Package</label>
                                    <select class="form-control" name="package_id" id="exampleSelect1">
                                    @if($packages && count($packages) > 0 ) 
                                        @foreach($packages as $package) 
                                        <option value = "{{ $package && $package->id ? $package->id : ''}}" > {{ $package && $package->package_name ? $package->package_name : ''}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Service Period</label>
                                    <select class="form-control" name="service_period" id="period">
                                        <option>-select period-</option>
                                        <option value = "30" >1 month</option>
                                        <option value = "90" >3 months</option>
                                        <option value = "180" >6 months</option>
                                        <option value = "365" >1 year</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Expiration Date</label>
                                    <input type="text" class="form-control" name="expiration_date" id="expiration_datetimepicker"  placeholder="Enter Expiration Date" autocomplete = "off"/>
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea col="50" row="5"  class="form-control" name="notes" placeholder="Enter notes"></textarea>
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
        <div class="modal fade" id="deleteOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Really want to delete?</h5>
                    </div>
                    <form method="POST"   id = "order_delete_form" >
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
    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }
    function formatDate(date)
    {
        var yy = date.getFullYear();
        var mm = date.getMonth() + 1;
        var dd = date.getDate();
        var hh = date.getHours();
        var min =  date.getMinutes();
        var ss = date.getSeconds();
        if(mm < 10) mm = '0' + mm;
        if(dd < 10) dd = '0' + dd;
        if(hh < 10) hh = '0' + hh;
        if(min < 10)min= '0' + min;
        if(ss < 10) ss = '0' + ss;
        var _date = `${yy}-${mm}-${dd} ${hh}:${min}:${ss}`;
        return _date;
    }
    function setFromAndTo(dateStr)
    { 
        var from = "";
        var to   = "";
        var today = new Date();
        if(dateStr == "30")
        {
            to = addDays(today, 30)
            to = formatDate(to);
            from   = formatDate(today);
        } else if (dateStr == "90")
        {
            to = addDays(today, 90);
            to = formatDate(to);
            from   = formatDate(today);
        } else if(dateStr == "180")
        {
            to = addDays(today, 180);
            to = formatDate(to);
            from   = formatDate(today);
        } else if (dateStr == "365")
        {
            to = addDays(today, 365);
            to = formatDate(to);
            from   = formatDate(today);
        } 
        $('#order_datetimepicker').val(from);
        $('#expiration_datetimepicker').val(to);
    }
    $(document).ready(function(){
        $('.order_delete_button').on('click', function(){
            var order_id = $(this).data('id');
            $('#order_delete_form').attr('action', "/orders/" + order_id);
         })
         $('#packages_table').DataTable({
             "responsive": true,
         })
         $('#order_datetimepicker').datetimepicker({
             todayHighlight:true,
             autoclose:true,
             format: 'yyyy-mm-dd hh:ii'
         });
         $('#order_datetimepicker').val(formatDate(new Date()));
         $('#expiration_datetimepicker').datetimepicker({
             todayHighlight:true,
             autoclose:true,
             format: 'yyyy-mm-dd hh:ii'
         });
         $('#period').change(function(){
             var select_period = $(this).children("option:selected").val();
             setFromAndTo(select_period);
         })
    })
</script>
@endsection
