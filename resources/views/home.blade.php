@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning" uk-alert>
                {{ Session::get('error') }}
                @php
                    Session::forget('error');
                @endphp
            </div>
        @endif

        <div class="container"> 
            <form action="/home" method="POST">
                @csrf
                <select style="padding:6px" name="category">
                    <option value="electronics" selected>Electronics</option>
                    <option value="fashion">Fashion</option>
                    <option value="home-decor">Home Decor</option>
                </select>
                &nbsp; &nbsp; <input style="padding:6px; border:'0px black dashed';" name="maximum_price" type="text" placeholder=" Maximum Price (₹)" autocomplete="off" required/>
                &nbsp; &nbsp;<button type="submit" class="btn btn-primary">Search</button>  
            </form> 
            <p style="color:red">@error('maximum_price') {{$message}} @enderror  </p>
        </div>

        <br><br><br>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card" style="margin-bottom:50px">
                        <div class="card-header">
                            <!-- The product name (duh..) -->
                            <strong>{{ $product->name }}</strong>
                        </div>
                        <div class="card-header">
                            <!-- The product image (duh..) -->
                            <img src={{ $product->image }} width="210px" height="220px">
                        </div>
                        <div class="card-body">
                            <h5>
                                <!-- We format the number to a price with currency behind it -->
                                {{ $product->price }} ₹
                            </h5>
                            <a href="{{ route('add', [ $product->getRouteKey() ]) }}">
                                <!-- The button for adding the product to the cart -->
                                <button class="btn btn-primary">Add to cart</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection