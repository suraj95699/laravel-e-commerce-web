@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/6.0.0-beta.2/dropzone.min.css" integrity="sha512-qkeymXyips4Xo5rbFhX+IDuWMDEmSn7Qo7KpPMmZ1BmuIA95IPVYsVZNn8n4NH/N30EY7PUZS3gTeTPoAGo1mA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-shopping-bag"></i> {{ $pageTitle }} - {{ $subTitle }}</h1>
    </div>
</div>
@include('admin.partials.flash')
<div class="row user">
    <div class="col-md-3">
        <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
                <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                <li class="nav-item"><a class="nav-link" href="#images" data-toggle="tab">Images</a></li>
                <li class="nav-item"><a class="nav-link" href="#attribute" data-toggle="tab">Attribute</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content">


            <div class="tab-pane active" id="general">
                <div class="tile">
                    <form action="{{ route('admin.products.update') }}" method="POST" role="form">
                        @csrf
                        <h3 class="tile-title">Product Information</h3>
                        <hr>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="name">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Enter attribute name" id="name" name="name" value="{{ old('name', $product->name) }}" />
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="invalid-feedback active">
                                    <i class="fa fa-exclamation-circle fa-fw"></i> @error('name') <span>{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="sku">SKU</label>
                                        <input class="form-control @error('sku') is-invalid @enderror" type="text" placeholder="Enter product sku" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" />
                                        <div class="invalid-feedback active">
                                            <i class="fa fa-exclamation-circle fa-fw"></i> @error('sku') <span>{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="brand_id">Brand</label>
                                        <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                            <option value="0">Select a brand</option>
                                            @foreach($brands as $brand)
                                            @if ($product->brand_id == $brand->id)
                                            <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                                            @else
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback active">
                                            <i class="fa fa-exclamation-circle fa-fw"></i> @error('brand_id') <span>{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="categories">Categories</label>
                                        <select name="categories[]" id="categories" class="form-control" multiple>
                                            @foreach($categories as $category)
                                            @php $check = in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : ''@endphp
                                            <option value="{{ $category->id }}" {{ $check }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="price">Price</label>
                                        <input class="form-control @error('price') is-invalid @enderror" type="text" placeholder="Enter product price" id="price" name="price" value="{{ old('price', $product->price) }}" />
                                        <div class="invalid-feedback active">
                                            <i class="fa fa-exclamation-circle fa-fw"></i> @error('price') <span>{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="special_price">Special Price</label>
                                        <input class="form-control" type="text" placeholder="Enter product special price" id="special_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">Quantity</label>
                                        <input class="form-control @error('quantity') is-invalid @enderror" type="number" placeholder="Enter product quantity" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" />
                                        <div class="invalid-feedback active">
                                            <i class="fa fa-exclamation-circle fa-fw"></i> @error('quantity') <span>{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="weight">Weight</label>
                                        <input class="form-control" type="text" placeholder="Enter product weight" id="weight" name="weight" value="{{ old('weight', $product->weight) }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="description">Description</label>
                                <textarea name="description" id="description" rows="8" class="form-control">{{ old('description', $product->description) }}</textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="status" name="status" {{ $product->status == 1 ? 'checked' : '' }} />Status
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="featured" name="featured" {{ $product->featured == 1 ? 'checked' : '' }} />Featured
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="row d-print-none mt-2">
                                <div class="col-12 text-right">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Product</button>
                                    <a class="btn btn-danger" href="{{ route('admin.products.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Starts of image section -->
            <div class="tab-pane" id="images">
                <div class="tile">
                    <h3 class="tile-title">Upload Image</h3>
                    <hr>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" class="dropzone" id="dropzone" style="border: 2px dashed rgba(0,0,0,0.3)">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                        <div class="row d-print-none mt-2">
                            <div class="col-12 text-right">
                                <button class="btn btn-success" type="button" id="uploadButton">
                                    <i class="fa fa-fw fa-lg fa-upload"></i>Upload Images
                                </button>
                            </div>
                        </div>
                        @if ($product->images)
                        <hr>
                        <div class="row">
                            @foreach($product->images as $image)
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{ asset('storage/'.$image->full) }}" id="brandLogo" class="img-fluid" alt="img">
                                        <a class="card-link float-right text-danger" href="{{ route('admin.products.images.delete', $image->id) }}">
                                            <i class="fa fa-fw fa-lg fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- end of image section -->



            <!-- Starts of Attribute section -->
            <div class="tab-pane" id="attribute">
                <div class="tile">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="value">Value <sup class="required_sign">*</sup></label>
                            <select class="select2dropdown" id="attributeDropdown" style="width: 100%;">
                                <option value="">--Select--</option>
                                @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="tile selectAddAttributes" style="display:none;">
                    <form action="{{ route('admin.products.addAttribute') }}" method="POST" role="form">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" id="product_id" name="product_id" />
                        <input type="hidden" value="" id="attribute_id" name="attribute_id" />
                        <div class="tile-body">
                            <div class="form-group selectAddAttributes">
                                <label class="control-label" for="value">Select value<sup class="required_sign">*</sup></label>
                                <select class="select2dropdown" id="addAttribute" style="width: 100%;" name="value">
                                </select>
                            </div>
                            <div class="row quantityPrice" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">Quantity</label>
                                        <input class="form-control" type="number" placeholder="Enter product quantity" id="quantity" name="quantity" value="" min="0" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="price">Price</label>
                                        <input class="form-control" type="number" placeholder="Enter product price" id="price" name="price" value="" min="0" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-plus"></i>Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- product attribute template starts  -->
                <div class="tile">
                    <h3 class="tile-title">Product Attributes</h3>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>Value</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $productAttributes as $productAttribute)
                                    <tr>
                                        <td style="width: 25%" class="text-center">{{ $productValues[$productAttribute->value] }}</td>
                                        <td style="width: 25%" class="text-center">{{ $productAttribute->quantity }}</td>
                                        <td style="width: 25%" class="text-center">{{ $productAttribute->price }}</td>
                                        <td style="width: 25%" class="text-center">
                                            <a class="btn btn-sm btn-danger" onClick="return confirm('Are you Sure?')" href="{{ route('admin.products.deleteAttribute',$productAttribute->id); }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- product attribute template ends  -->

            </div>


        </div>
        <!-- End of Attribute section -->





    </div>
</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('backend/js/plugins/select2.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('backend/js/plugins/dropzone/dist/min/dropzone.min.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/6.0.0-beta.2/dropzone-min.js" integrity="sha512-FFyHlfr2vLvm0wwfHTNluDFFhHaorucvwbpr0sZYmxciUj3NoW1lYpveAQcx2B+MnbXbSrRasqp43ldP9BKJcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ asset('backend/js/plugins/bootstrap-notify.min.js') }}"></script>
<script>
    $(document).ready(function() {

            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('a[href="' + activeTab + '"]').tab('show');
            }
        Dropzone.autoDiscover = false;
        $('#categories').select2();

        let myDropzone = new Dropzone("#dropzone", {
            paramName: "image",
            addRemoveLinks: false,
            maxFilesize: 100, //byte
            parallelUploads: 20,
            uploadMultiple: false,
            url: "{{ route('admin.products.images.upload') }}",
            autoProcessQueue: false,
        });
        myDropzone.on("queuecomplete", function(file) {
            window.location.reload();
            showNotification('Completed', 'All product images uploaded', 'success', 'fa-check');
        });

        $('#uploadButton').click(function() {
            if (myDropzone.files.length === 0) {
                showNotification('Error', 'Please select files to upload.', 'danger', 'fa-close');
            } else {
                myDropzone.processQueue();
            }
        });

        function showNotification(title, message, type, icon) {
            $.notify({
                title: title + ' : ',
                message: message,
                icon: 'fa ' + icon
            }, {
                type: type,
                allow_dismiss: true,
                placement: {
                    from: "top",
                    align: "right"
                },
            });
        }


        $('.select2dropdown').select2();
        $('#attributeDropdown').change(function() {
            $('.selectAddAttributes').css("display", "block");
            let attrId = $(this).val();
            $('#attribute_id').val(attrId);
            let route = "{{ route('admin.products.getAttibuteOptionsJson') }}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: route,
                data: {
                    'id': attrId
                },
                type: 'get',
                success: function(reponse) {
                    $('#addAttribute').html("");
                    $('#addAttribute').append('<option value="">--Select--</option>');
                    for (let i = 0; i < reponse.length; i++) {
                        console.log(reponse[i]['value']);
                        var option = document.createElement("option");
                        option.text = reponse[i]['value'];
                        option.value = reponse[i]['id'];
                        option.setAttribute("attributeid", reponse[i]['attribute_id']);

                        $('#addAttribute').append(option);

                    }
                    $(".select2dropdown").select2();
                }
            });
            return false;
        });

        $('.selectAddAttributes').change(function() {
            $('.quantityPrice').css("display", "flex");
        })

    });
</script>

@endsection