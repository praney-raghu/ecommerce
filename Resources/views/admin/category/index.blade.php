@extends('ecommerce::admin.layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-3">
                <div class="well">
                    <h4>Category</h4>
                    <p>{{$categories}}</p>
                </div>
            </div>
            <div class="col-sm-6 pull-right">
                <div class="panel panel-primary">
                    <div class="panel-heading">Add new Category</div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="/action_page.php">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="name">Name:</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="Enter Category Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="description">Description:</label>
                                <div class="col-sm-10"> 
                                <input type="text" class="form-control" id="description" placeholder="Enter Category Description">
                                </div>
                            </div>
                            <div class="form-group"> 
                                <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row">
            
        </div>
    </div>
</div>
@endsection