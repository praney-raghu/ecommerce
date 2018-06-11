@extends('ecommerce::admin.layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-3">
                <div class="well">
                    <h4>Products</h4>
                    <p>{{$products}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection