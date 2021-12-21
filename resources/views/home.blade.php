<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet"href="{{asset('./css/app.css')}}">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
      @foreach($products as $key =>$pro)
      <div class="card-left">
        <h3 class="title text-center">Our Products</h3>
        <div class="single-products">
              <div class="shop-item-image"style="background-color:{{$pro->color}}">
                <img src="{{$pro->image}}" with="233"height="255"alt="">
              </div>
              <p>{{$pro->name}}</p>
              <p>{{$pro->description}}</p>
              <div class="shop-item-bottom">
                <div class="shop-item-price">
                  <h2>${{number_format($pro->price,2,'.','.')}}</h2>
                </div>
                <div class="shop-item-button">
                  @php   
                  $cart = Cart::content();
                  @endphp  
                    @if($cart->where('id',$pro->id)->count())
                      In cart
                    @else  
                    <form>
                      @csrf
                      <input type="hidden"class="cart_product_id_{{$pro->id}}"value="{{$pro->id}}">
                      <input type="hidden"class="cart_product_name_{{$pro->id}}"value="{{$pro->name}}">
                      <input type="hidden"class="cart_product_image_{{$pro->id}}"value="{{$pro->image}}">
                      <input type="hidden"class="cart_product_price_{{$pro->id}}"value="{{$pro->price}}">
                      <input type="hidden"class="cart_product_color_{{$pro->id}}"value="{{$pro->color}}">
                      <input type="hidden"class="cart_product_qty_{{$pro->id}}"value="1">
                      <button type="button"class="btn btn-default add-to-cart"data-id_product="{{$pro->id}}" name="add_to_cart">
                        ADD TO CART
                      </button>
                    </form>
                    @endif
                </div>
              </div>
              
        </div>
      </div>
      @endforeach
      
      <div class="card-right">
        <form action="{{url('update-cart-ajax')}}" method="POST"> 
          @csrf
          <h3 class="title text-left">Your cart</h3>
          @if(Session::get('cart') == true)
          @php
          $total = 0;
					@endphp
          @foreach(Session::get('cart') as $cart)
          @php 
            $subtotal = $cart['product_qty'] * $cart['product_price'];
            $total+=$subtotal;
					@endphp
        <div class="cart-item">
          <div class="cart-item-left">
            <div class="cart-item-image"style="background-color: {{$cart['product_color']}}">
              <div class="cart-item-image-block">
                <img src="{{$cart['product_image']}}">
              </div>
            </div>
          </div>
          <div class="cart-item-right">
            <div class="cart-item-name">{{$cart['product_name']}}</div>
            <div class="cart-item-price">${{number_format($cart['product_price'],2,'.','.')}}</div>
            <div class="cart-item-actions">
              <input type="hidden" class="product_id" value="{{$cart['id']}}">
              <div class="cart-item-count quantity">
                <div class="btn-increment-decrement btn-dec changeQuantity" style="float:left">-</div>
                <input type="number"min="0" class="input-qty input-quantity"name="cart_qty[{{$cart['session_id']}}]" style="float:left" id=""value="{{$cart['product_qty']}}">
                <div class="btn-increment-decrement btn-inc changeQuantity" style="float:left">+</div>
                <a class="cart_quantity_delete" href="{{url('/delete-product/'.$cart['session_id'])}}"><img src="{{asset('./images/trash.png')}}"></a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <input type="submit" value="Update" name="update_qty" class="btn btn-primary btn-update">
        <p class="total">Total: ${{$total}}</p>
      </form>
        @else  
          <?php
            echo "Your cart is empty";
          ?>
				@endif
      </div>
      <script src="{{asset('./js/jquery.js')}}"></script>
      <script src="{{asset('./js/bootstrap.min.js')}}"></script>
      <script src="{{asset('./js/main.js')}}"></script>
      <!-- change Increament and Decrement  -->
      <script type="text/javascript">
        $(document).ready(function () {
          $('.btn-inc').click(function (e) {
            e.preventDefault();
            var incre_value = $(this).parents('.quantity').find('.input-qty').val();
            var value = parseInt(incre_value, 10);
            value = isNaN(value) ? 0 : value;
            if(value<10){
                value++;
                $(this).parents('.quantity').find('.input-qty').val(value);
            }
          });

          $('.btn-dec').click(function (e) {
          e.preventDefault();
          var decre_value = $(this).parents('.quantity').find('.input-qty').val();
          var value = parseInt(decre_value, 10);
          value = isNaN(value) ? 0 : value;
          if(value>1){
              value--;
              $(this).parents('.quantity').find('.input-qty').val(value);
          }
          });
        });
      </script>
        <!-- Update Cart Data without Refresh Page Failed -->
      <script type="text/javascript">
        $(document).ready(function () {
          $('.changeQuantity').click(function (e) {
              e.preventDefault();
              var quantity = $(this).closest(".cart-item").find('.input-qty').val();
              var product_id = $(this).closest(".cart-item").find('.product_id').val();

              var data = {
                  '_token': $('input[name=_token]').val(),
                  'quantity':quantity,
                  'product_id':product_id,
              };

              $.ajax({
                  url: "{{url('/update-cart-ajax')}}",
                  type: 'POST',
                  data: data,
                  success: function (data) {
                      window.location.reload();
                      // alertify.set('notifier','position','top-right');
                      // alertify.success(response.status);
                  }
              });
          });
        });
      </script>
      <!--- add to cart by using Ajax --->
      <script type="text/javascript">
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_color = $('.cart_product_color_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('/add-cart-ajax')}}",
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,
                          cart_product_name:cart_product_name,
                          cart_product_image:cart_product_image,
                          cart_product_price:cart_product_price,
                          cart_product_qty:cart_product_qty,
                          cart_product_color:cart_product_color,
                          _token:_token},
                    success:function(data){
                        location.reload();
                    }
                });
            });
        });
    </script>
    </body>
</html>
