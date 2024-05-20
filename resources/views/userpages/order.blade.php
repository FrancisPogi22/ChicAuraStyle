<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/order.css') }}">
</head>

<body>
    @include('partials.header')
    <section id="order">
        <div class="wrapper">
            <div class="order-con">
                <h2>Orders</h2>
                <div class="order-list-con">
                    @forelse ($orders as $order)
                        <div class="order-widget">
                            <input type="checkbox" class="order-checkbox" data-price="{{ $order->totalPrice }}">
                            <img src="/product_img/{{ $order->image }}" alt="Image">
                            <div class="order-details">
                                <h6>{{ $order->name }}</h6>
                                <p>{{ $order->description }}</p>
                                <div class="quantity-con">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control quantity" name="quantity"
                                        data-product-id="{{ $order->productID }}" value="{{ $order->quantity }}"
                                        placeholder="Quantity" required>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No item's in cart.</p>
                    @endforelse
                </div>
                <div class="checkout-con">
                    <p id="total">Total Price: ₱ <span id="total-price">0</span></p>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#checkoutModal">Checkout</button>
                </div>
                <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Checkout Form</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('check.out') }}" method="POST" id="checkout-form">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="productIDs" id="productIDs">
                                    <div class="field-con">
                                        <input type="text" name="name" class="form-control" placeholder="Name"
                                            required>
                                    </div>
                                    <div class="field-con">
                                        <input type="text" name="address" class="form-control" placeholder="Address"
                                            required>
                                    </div>
                                    <div class="field-con">
                                        <select name="payment" class="form-control">
                                            <option value="" selected hidden disabled>Select payment method
                                            </option>
                                            <option value="COD">Cash on delivery</option>
                                            <option value="Gcash">Gcash</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Purchase</button>
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
            function calculateTotalPrice() {
                let total = 0;

                $('.order-checkbox:checked').each(function() {
                    total += parseFloat($(this).data('price'));
                });
                $('#total-price').text(total.toFixed(2));
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.quantity').on('change', function() {
                let orderId = $(this).data('product-id');
                let newQuantity = $(this).val();

                $.ajax({
                    url: "{{ route('update.quantity') }}",
                    type: "PUT",
                    data: {
                        id: orderId,
                        quantity: newQuantity
                    },
                    success: function(response) {
                        if (response.status == "warning") {
                            showWarningMessage(response.message);
                        }
                    },
                    error: function(response) {
                        showWarningMessage('An error occurred while updating the quantity.');
                    }
                });
            });

            $('.order-checkbox, .quantity').change(calculateTotalPrice);

            $('#checkout-form').submit(function(event) {
                event.preventDefault();

                let selectedProductIDs = [];

                $('.order-checkbox:checked').each(function() {
                    let productID = $(this).siblings('.quantity').data('product-id');

                    selectedProductIDs.push(productID);
                });

                if (selectedProductIDs.length == 0) {
                    showInfoMessage('Please select at least one product.');
                    return;
                }

                $('#productIDs').val(selectedProductIDs.join(','));
                this.submit();
            });

        });
    </script>
</body>

</html>
