@extends('common') 

@section('pagetitle')
Thank You!
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Thank you for your purchase.</h1>
			<hr/>
		</div>
    </div>
    <div class="row">
		<div class="col-md-5 col-md-offset-2">
            <h4>Bill to:</h4>
            <p>{{$data['first_name']}} {{$data['last_name']}}</p>
            <p>{{$data['phone']}}</p>
            <p>{{$data['email']}}</p>
        </div>
        
        <div class="col-md-5">
            <h4>Order Id: {{$order_id}}</h4><br/>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-10 col-md-offset-2"> 
            <br/>
            <table class="table">
				<thead>
                    <th>Quantity</th>
                    <th>Title</th>
                    <th class="text-right">Price</th>
				</thead>
				<tbody>
                    @foreach ($items as $item) 
                        <tr>
                            <td>{{$item->quantity}}</td>
                            <td>{{ $item->title }}</td>
                            <td class="text-right">{{ $item->price }}</td>
						</tr>
                    @endforeach
				</tbody>
            </table>
            <hr/>
            <h4 class="text-right">Subtotal: ${{$subtotal}}</h4><br/>
           
        </div>
    </div>
@endsection