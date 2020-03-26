@extends('common') 

@section('pagetitle')
{{ $category->name }}
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>{{ $category->name }}</h1>
        </div>
        <div class="col-md-10 col-md-offset-2">
            <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <div class="card cat-card">
                <div class="card-body">
                    <h4 class="card-title">Categories</h4>
                    <hr />

                    @foreach ($categories as $category)
                    <a href="{{ route('category', $category->id) }}">
                        <p class="card-text"> {{ $category->name }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            
            @foreach ($items as $item) 
                <div class="col-md-4">
                    <div class="card cat-card-list">
                        <div class="card-body">
                            <a href="{{ route('item', $item->id) }}">
                                <img src="{{ Storage::url('images/items/tn_'.$item->picture) }}" class="product-picture" />
                            </a>
                            <a href="{{ route('item', $item->id) }}">
                                <h4 class="card-text">{{ $item->title }}</h4>
                            </a>
                            <p class="card-text">${{ $item->price }}
                                <a href="{{ route('add_to_cart', $item->id) }}" class="btn btn-primary btn-sm buy-now-btn">BUY NOW</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection