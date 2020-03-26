@extends('common') 

@section('pagetitle')
Products
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>{{ $item->title }}</h1>
        </div>
        <div class="col-md-10 col-md-offset-2">
            <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-md-offset-2">
            <div class="card item-card">
                <div class="card-body">
                    <img src="{{ Storage::url('images/items/lrg_'.$item->picture) }}" class="item-picture"/>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card item-info-card">
                <div class="card-body card-text-size">
                    <p class="card-text">Price: <b>${{ $item->price }}</b>
                        <a href="/products" class="btn btn-primary btn-md buy-now-btn">BUY NOW</a>
                    </p>
                    <p class="card-text">ID: <b>#{{ $item->id }}</b></p>
                    <p class="card-text">SKU: <b>{{ $item->sku }}</b></p>
                    <p class="card-text">In Stock: <b>{{ $item->quantity }}</b></p>
                    <p class="card-text">Description: {!! $item->description !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection