<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>example-component</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        img {
            width: 100%;
        }

        .text-red {
            color: #e03f19;
        }

        #productDetail {
            width: 80%;
            margin: auto;
            height: 500px;
            padding: 30px;
        }

        .product {
            width: calc(50% - 30px);
            margin-right: 30px;
            display: inline-block;
            float: left;
        }

        .product .productImg {
            width: 100%;
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div id="productDetail">
    <section class="product">
        <h2>{{$productInfo->name}}</h2>
        <div class="productImg"><img src="{{$productInfo->image}}"></div>
    </section>
    <deal :product="{{$productInfo->id}}"></deal>
</div>
<script src="/js/productDetail.js"></script>
</body>


</html>