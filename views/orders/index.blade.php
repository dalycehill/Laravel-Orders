@extends('common') 

@section('pagetitle')
Orders
@endsection

@section('pagename')
Laravel Project
@endsection

@section('scripts')
{!! Html::script('/bower_components/parsleyjs/dist/parsley.min.js') !!}
@endsection

@section('css')
{!! Html::style('/css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Orders</h1>
        </div>
        <div class="col-md-10 col-md-offset-2">
            <hr />
        </div>
    </div>

    <div class="row">
		<div class="col-md-10 col-md-offset-2">
			<table class="table">
				<thead>
					<th>Order ID</th>
                    <th>Name</th>
                    <th>Created At</th>
					<th>Last Modified</th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($orders as $order)
						<tr>
							<th>{{ $order->id }}</th>
							<td>
								<a href="{{ route('orders.show', $order->id) }}" class="order-link">{{ $order->first_name }} {{ $order->last_name }}</a>
							</td>
							<td style="width: 100px;">{{ date('M j, Y', strtotime($order->created_at)) }}</td>
							<td>{{ date('M j, Y', strtotime($order->updated_at)) }}</td>
                            <td style="width: 175px;">
                                <div style='float:left; margin-right:5px;'>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-success btn-sm">Receipt</a>
                                </div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
