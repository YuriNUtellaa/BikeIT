@extends('layouts.header')
@section('content')
    <table id="cart" class="table table-hover table-condensed" style="padding-top: 100px;">
        <thead>
            <tr>
                <th style="width:50%">Product</th>
                <th style="width:10%">Price</th>
                <th style="width:8%">Quantity</th>
                <th style="width:22%" class="text-center">Subtotal</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @if(session('cart'))
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['sell_price'] * $details['quantity'] @endphp
                    <tr data-id="{{$id}}">
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 hidden-xs"><img src="{{asset('image')}}/{{$details['image']}}" width="100" height="50">
                                <div class="col-sm-9">
                                    <h4 class="nomargin">{{$details['product_name']}}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">P{{$details['sell_price']}}</td>
                        <td data-th="Quantity">
                            <input type="number" value="{{$details['quantity']}}" min="1" class="form-control quantity cart_update">
                        </td>
                        <td data-th="Subtotal" class="text-center">P{{$details['sell_price'] * $details['quantity']}}
                        </td>
                        <td class="actions" data-th="">
                            <button class="btn btn-danger btn-sm cart_remove"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><h3><strong>Total P{{$total}}</strong></h3></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                    <a href="/home" class="btn btn-danger"><i class="fa fa-arrow-left"></i>Continue Shopping</a>
                    <button class="btn btn-success cart_checkout"><i  class="fa fa-money"></i>Checkout</button>
                </td>
            </tr>
        </tfoot>
    </table>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(".cart_update").click(function(e) {
            e.preventDefault();
            var ele = $(this);

                $.ajax({
                    url:'{{route('update_cart')}}',
                    method: "patch",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: ele.parents("tr").attr("data-id"),
                        quantity: ele.parents("tr").find(".quantity").val()
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
             });

        $(".cart_remove").click(function(e) {
            e.preventDefault();
            var ele = $(this);

            if(confirm("Do you really want to remove?")) {
                $.ajax({
                    url:'{{route('remove_from_cart')}}',
                    method: "DELETE",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

        $(".cart_checkout").click(function(e) {
            e.preventDefault();
            if(confirm("Do you want to proceed with the checkout?")) {
                $.ajax({
                    url: '{{ route('checkout') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // Assuming you have a success page to redirect after checkout
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('An error occurred during checkout: ' + xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection