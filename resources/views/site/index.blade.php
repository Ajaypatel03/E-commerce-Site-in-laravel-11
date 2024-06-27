@extends('layouts.site')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <div class="content-wrapper">

        <div class="container">
            <div class="row pt120">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="heading align-center mb60">
                        <h4 class="h1 heading-title">E-commerce tutorial</h4>
                        <p class="heading-text">Buy books, and we ship to you.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Books products grid -->

        <div class="container">
            <div class="row pt120">
                <div class="books-grid">

                    <div class="row mb30">
                        @if (count($products) > 0)
                            @foreach ($products as $product)
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="books-item">
                                        <div class="books-item-thumb">
                                            @if ($product->gallery)
                                                <img src="{{ $product->gallery->image }}" alt="book">
                                            @endif
                                            <div class="new">New</div>
                                            <div class="sale">Sale</div>
                                            <div class="overlay overlay-books"></div>
                                        </div>

                                        <div class="books-item-info">
                                            <h5 class="books-title">{{ $product ? $product->name : '' }}</h5>

                                            <div class="books-price">
                                                {{ config('product.currency') }}{{ $product->price }}</div>

                                        </div>

                                        <a href="javascript:void(0)" data-id="{{ $product->id }}"
                                            class="btn btn-small btn--dark add add_to_cart_btn">
                                            <span class="text">Add to Cart</span>
                                            <i class="seoicon-commerce"></i>
                                        </a>

                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>

                    <div class="row pb120">

                        <div class="col-lg-12">

                            <nav class="navigation align-center">

                                <a href="#" class="page-numbers bg-border-color current"><span>1</span></a>
                                <a href="#" class="page-numbers bg-border-color"><span>2</span></a>
                                <a href="#" class="page-numbers bg-border-color"><span>3</span></a>
                                <a href="#" class="page-numbers bg-border-color"><span>4</span></a>
                                <a href="#" class="page-numbers bg-border-color"><span>5</span></a>

                                <svg class="btn-prev">
                                    <use xlink:href="#arrow-left"></use>
                                </svg>
                                <svg class="btn-next">
                                    <use xlink:href="#arrow-right"></use>
                                </svg>

                            </nav>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>

    <script>
        $(document).ready(function() {

            console.log('jQuery is loaded:', typeof $ !== 'undefined'); // Check if jQuery is loaded

            $('.add_to_cart_btn').click(function() {

                var product_id = $(this).data('id');

                $.ajax({
                    url: "{{ route('add_to_cart') }}",
                    method: "GET",
                    data: {
                        product_id
                    },
                    success: function(data) {
                        if (data.products) {
                            console.log(data.products);
                        }
                        calculateCartItems();
                    },
                    error: function(response) {

                        if (response.responseJSON.errors) {
                            toastr['error'](response);
                        } else if (response.responseJSON.error) {
                            toastr['error'](response.responseJSON.error);
                        } else {
                            toastr(
                                'Something Went Wrong,Please Refresh The Page And Try Again.'
                            );
                        }
                    },
                });
            });

            function calculateCartItems() {
                $.ajax({
                    url: "{{ route('calculate.add_to_cart') }}",
                    method: "GET",
                    success: function(data) {
                        $('.cart_total_items').html(data.cart_total_items);
                    },
                    error: function(response) {

                    },
                });
            }
        });
    </script>
@endsection
