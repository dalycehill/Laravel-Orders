@extends('common') 

@section('pagetitle')
Cart
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
            <h1>Cart</h1>
        </div>
        <div class="col-md-10 col-md-offset-2">
            <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <table class="table">
				<thead>
                    <th>Title</th>
                    <th>Price</th>
					<th>Quantity</th>
					<th></th>
				</thead>
				<tbody>
                    @foreach ($items as $item) 
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->price }}</td>
                            
							<div class="form-cart">
                                {!! Form::model($item, ['route' => ['update_cart', $item->id], 'method'=>'GET', 'data-parsley-validate' => '', 'files' => true]) !!}
                                    <td class="td-cart">
                                        {{ Form::text('quantity', null, ['class'=>'form-control', 'style'=>'', 'data-parsley-required'=>'']) }}
                                    </td>
                                    <td class="td-cart"> 
                                        {{ Form::submit('Update', ['class'=>'btn btn-success btn-block', 'style'=>'margin-top:0px']) }}
                                {!! Form::close() !!}

                                 
								{!! Form::open(['route' => ['remove_item', $item->id], 'method'=>'GET']) !!}
							    	{{ Form::submit('Remove', ['class'=>'btn btn-sm btn-danger btn-block', 'style'=>'', 'onclick'=>'return confirm("Are you sure?")']) }}
                                {!! Form::close() !!}
                            </div>
							        </td>
						</tr>
                    @endforeach
				</tbody>
            </table>

            <h4 class="text-right">Subtotal: ${{$subtotal}}</h4><br/>
           
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <h4>Enter your information to order:</h4>
            {!! Form::open(['route' => 'check_order', 'data-parsley-validate' => '', 
			                'files' => true]) !!}
			    
				{{ Form::label('first_name', 'First Name:') }}
			    {{ Form::text('first_name', null, ['class'=>'form-control', 'style'=>'', 
			                                  'data-parsley-required'=>'']) }}

                {{ Form::label('last_name', 'Last Name:', ['style'=>'margin-top:20px']) }}
                {{ Form::text('last_name', null, ['class'=>'form-control', 'style'=>'', 
                                                'data-parsley-required'=>'']) }}

				{{ Form::label('phone', 'Phone:', ['style'=>'margin-top:20px']) }}
			    {{ Form::text('phone', null, ['class'=>'form-control', 'style'=>'', 
			                                  'data-parsley-required'=>'']) }}

				{{ Form::label('email', 'Email:', ['style'=>'margin-top:20px']) }}
			    {{ Form::text('email', null, ['class'=>'form-control', 'style'=>'', 
											  'data-parsley-required'=>'', 'data-parsley-type="email"']) }}

			    {{ Form::submit('Submit', ['class'=>'btn btn-success btn-lg btn-block', 'style'=>'margin-top:20px']) }}

			{!! Form::close() !!}
        </div>

    </div>

@endsection
