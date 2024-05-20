<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/homepage.css') }}">
</head>

<body>
    @include('partials.header')
    <section id="products">
        <div class="wrapper">
            <div class="products-con">
                <div class="products-header">
                    <h2>Products</h2>
                    <div class="filter-con">
                        <select name="category" class="form-control" id="category">
                            <option value="" selected hidden disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->categoryID }}">{{ $category->categoryName }}</option>
                            @endforeach
                        </select>
                        <select name="price" class="form-control" id="price">
                            <option value="High">High to Low</option>
                            <option value="Low">Low to High</option>
                        </select>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addProducts">
                            Add
                        </button>
                    </div>
                </div>
                <div class="products-widget-con">
                </div>
                <div class="modal fade" id="addProducts" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Product Form</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('product.add') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="field-con">
                                        <select name="category" class="form-control">
                                            <option value="" disabled selected hidden>Select Category
                                            </option>
                                            <option value="1">Dresses</option>
                                            <option value="3">Bags</option>
                                            <option value="2">Shoes</option>
                                        </select>
                                    </div>
                                    <div class="field-con">
                                        <input type="file" name="image" class="form-control" required>
                                    </div>
                                    <div class="field-con">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Product Name" required>
                                    </div>
                                    <div class="field-con">
                                        <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Product Description"
                                            required></textarea>
                                    </div>
                                    <div class="field-con">
                                        <input type="text" name="price" class="form-control"
                                            placeholder="Product Name" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Product Form</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="number" name="productID" id="productID" hidden>
                                    <div class="field-con">
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                    <div class="field-con">
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Product Name" required>
                                    </div>
                                    <div class="field-con">
                                        <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                    <div class="field-con">
                                        <input type="number" name="productPrice" id="productPrice"
                                            class="form-control" placeholder="Product Price" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade modal-lg" id="viewModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="productImage" src="" alt="Image">
                                <div class="product-details-con">
                                    <div class="product-details">
                                        <h3 id="productName"></h3>
                                        <p id="productDescription"></p>
                                    </div>
                                    <p id="viewProductPrice"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.plugins')
    @include('partials.script')
    @include('partials.toastr')
    <script>
        $(document).ready(function() {
            initProducts();

            $("#category").change(function() {
                changeCategory();
            });

            $("#price").change(function() {
                getProductByPrice();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.viewModalBtn', function() {
                $('#productImage').attr('src', `/product_img/${$(this).data('img')}`);
                $('#productName').text($(this).data('name'));
                $('#productDescription').text($(this).data('description'));
                $('#viewProductPrice').text("₱ " + $(this).data('price'));
                $('#addProduct').attr('data-id', $(this).data('id'));
                $('#viewModal').modal('show');
            });

            $(document).on('click', '.removeProduct', function() {
                let widget = $(this).closest('.products-widget');

                $.ajax({
                    url: '{{ route('remove.product') }}',
                    type: 'DELETE',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function(response) {
                        if (response.status == "warning") {
                            showInfoMessage(response.message);
                        } else {
                            widget.remove();
                            showSuccessMessage('Product removed successfully.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $(document).on('click', '.updateProduct', function() {
                $('#productID').val($(this).data('id'));
                $('#name').val($(this).data('name'));
                $('#description').text($(this).data('description'));
                $('#productPrice').val($(this).data('price'));
                $('#updateModal').modal('show');
            });

            function getProductByPrice() {
                let selectedPrice = $("#price").val();

                $.ajax({
                    url: '{{ route('get.product.price') }}',
                    type: 'GET',
                    data: {
                        price_range: selectedPrice
                    },
                    success: function(response) {
                        $('.products-widget-con').empty();

                        response.products.forEach(product => {
                            $('.products-widget-con').append(`
                                <div class="products-widget">
                                    <button class="viewModalBtn" data-id="${product.productID}" data-img="${product.image}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}">
                                        View
                                    </button>
                                    <img src="{{ '/product_img/${product.image}' }}" alt="Image">
                                    <div class="widget-details">
                                        <h5>${product.name}</h5>
                                        <p>${product.description}</p>
                                        <p>₱ ${product.price}</p>
                                    </div>
                                    <div class="product-btn-con">
                                        <button class="updateProduct" data-id="${product.productID}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}">Update</button>
                                        <button class="removeProduct" data-id="${product.productID}">Remove</button>
                                    </div>
                                </div>
                            `);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function changeCategory() {
                let categoryId = $("#category").val();

                $.ajax({
                    url: '{{ route('get.product.category') }}',
                    type: 'GET',
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        $('.products-widget-con').empty();

                        response.products.forEach(product => {
                            $('.products-widget-con').append(`
                                <div class="products-widget">
                                    <button class="viewModalBtn" data-id="${product.productID}" data-img="${product.image}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}">
                                        View
                                    </button>
                                    <img src="{{ '/product_img/${product.image}' }}" alt="Image">
                                    <div class="widget-details">
                                        <h5>${product.name}</h5>
                                        <p>${product.description}</p>
                                        <p>₱ ${product.price}</p>
                                    </div>
                                    <div class="product-btn-con">
                                        <button class="updateProduct" data-id="${product.productID}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}">Update</button>
                                        <button class="removeProduct" data-id="${product.productID}">Remove</button>
                                    </div>
                                </div>
                            `);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function initProducts() {
                $.ajax({
                    url: '{{ route('get.products') }}',
                    method: "GET",
                    success(response) {
                        response.products.forEach(product => {
                            $('.products-widget-con').append(`
                                <div class="products-widget">
                                    <button class="viewModalBtn" data-id="${product.productID}" data-img="${product.image}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}">
                                        View
                                    </button>
                                    <img src="{{ '/product_img/${product.image}' }}" alt="Image">
                                    <div class="widget-details">
                                        <h5>${product.name}</h5>
                                        <p>${product.description}</p>
                                        <p>₱ ${product.price}</p>
                                    </div>
                                    <div class="product-btn-con">
                                        <button class="updateProduct" data-id="${product.productID}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}">Update</button>
                                        <button class="removeProduct" data-id="${product.productID}">Remove</button>
                                    </div>
                                </div>
                            `);
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>
