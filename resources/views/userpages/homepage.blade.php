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
                    </div>
                </div>
                <div class="products-widget-con">
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
                                    <p id="productPrice"></p>
                                    <button id="addProduct">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Purchase Form</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('add.order') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="number" name="productID" id="productID" hidden>
                                    <div class="field-con">
                                        <input type="number" name="quantity" class="form-control" min="1"
                                            placeholder="Quantity" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Order</button>
                                </div>
                            </form>
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

            $(document).on('click', '.addOrder', function() {
                let productId = $(this).data('id');

                $('#productID').val(productId);
                $('#orderModal').modal('show');
            });

            $(document).on('click', '#addProduct', function() {
                let productId = $(this).data('id');

                $('#productID').val(productId);
                $('#viewModal').modal('hide');
                $('#orderModal').modal('show');
            });

            $(document).on('click', '.viewModalBtn', function() {
                $('#productImage').attr('src', `/product_img/${$(this).data('img')}`);
                $('#productName').text($(this).data('name'));
                $('#productDescription').text($(this).data('description'));
                $('#productPrice').text("₱ " + $(this).data('price'));
                $('#addProduct').attr('data-id', $(this).data('id'));
                $('#viewModal').modal('show');
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
                                    <button class="addOrder" data-id="${product.productID}">Order now</button>
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
                                    <button type="button" class="viewModalBtn" data-id="${product.productID}" data-img="${product.image}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}" data-bs-toggle="modal" data-bs-target="#viewModal">
                                        View
                                    </button>
                                    <img src="{{ '/product_img/${product.image}' }}" alt="Image">
                                    <div class="widget-details">
                                        <h5>${product.name}</h5>
                                        <p>${product.description}</p>
                                        <p>₱ ${product.price}</p>
                                    </div>
                                    <button class="addOrder" data-id="${product.productID}">Order now</button>
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
                                    <button type="button" class="viewModalBtn" data-id="${product.productID}" data-img="${product.image}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}" data-bs-toggle="modal" data-bs-target="#viewModal">
                                        View
                                    </button>
                                    <img src="{{ '/product_img/${product.image}' }}" alt="Image">
                                    <div class="widget-details">
                                        <h5>${product.name}</h5>
                                        <p>${product.description}</p>
                                        <p>₱ ${product.price}</p>
                                    </div>
                                    <button class="addOrder" data-id="${product.productID}">Order now</button>
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
