@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-cogs"></i> {{ $pageTitle }}</h1>
    </div>
</div>
@include('admin.partials.flash')

<div class="row user">
    <div class="col-md-3">
        <div class="tile p-0">

            <div class="" role="" aria-label="">
                <a href="{{route('admin.attributes.edit',$attribute_arr[0]['attribute_id']) }}" class="nav-link ">General</i></a>
                <a href="{{ route('admin.attributes.getvalues',$attribute_arr[0]['attribute_id'])  }}" class="nav-link ">Attribute Values</a>
            </div>
        </div>

    </div>
    
    <div class="col-md-9">
        <div class="tab-content">
            <div class="tab-pane active" id="attributeValue">
                <div class="tile">
                
                    @if($editDataById["id"])
                    <form action="{{route('admin.attributes.updateValues') }}" method="POST" role="form">
                    @else  
                    <form action="{{route('admin.attributes.addValues') }}" method="POST" role="form">
                    @endif
                    
                        @csrf
                        <h3 class="tile-title">Attribute Values</h3>
                        <hr>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="value">Value</label>
                                <input class="form-control" type="text" placeholder="Enter Attribute Value " id="value" value="{{$editDataById['value']}}" name="value" />
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="price">Price</label>
                                <input class="form-control" type="text" placeholder="Enter Attribute Value Price" id="price" value="{{$editDataById['price']}}" name="price" />
                            </div>
                            <input type="hidden" value="{{$attribute_arr[0]['attribute_id']}}" name="attribute_id" />
                            <input type="hidden" value="{{$editDataById['id']}}" name="editid" />
                            
                        </div>
                        <div class="tile-footer">
                            <div class="row d-print-none mt-2">
                                <div class="col-12 text-right">
                                    @if($editDataById["id"])
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>update</button>
                                    <a class="btn btn-danger" href="{{route('admin.attributes.getvalues',$attribute_arr[0]['attribute_id']) }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>Reset</a>
                                    @else
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-3"></div>
    <div class="col-md-9">
        <div class="tab-content">
            <div class="tab-pane active" id="attributeValue">
                <div class="tile">
                    <!--  options html starts  -->
                    <h3 class="tile-title">Option Values</h3>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Value</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attribute_arr as $value)
                                    <tr v-for="value in values">
                                        <td style="width: 25%" class="text-center">{{ $value["id"]}}</td>
                                        <td style="width: 25%" class="text-center">{{ $value["value"]}}</td>
                                        <td style="width: 25%" class="text-center">{{ $value["price"]}}</td>
                                        <td style="width: 25%" class="text-center">

                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.attributes.getvalues',[$value['attribute_id'],$value['id']])  }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger" onClick="return confirm('Are you sure?');" href="{{ route('admin.attributes.deleteValues',[$value['id'],$value['attribute_id'] ])  }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- ENDS -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection