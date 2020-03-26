@extends('common') 

@section('pagetitle')
    Login
@endsection

@section('pagename')
    Laravel Project
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-4">
            {!! Form::open() !!}
                {{ Form::label('email', "Email:") }}
                {{ Form::email('email', null, ['class' => 'form-control']) }}

                {{ Form::label('password', "Password:") }}
                {{ Form::password('password', ['class' => 'form-control']) }}
                <br/>
                {{ Form::checkbox('remember')}}
                {{ Form::label('remember', "Remember Me") }}
                <br/>
                {{ Form::submit('Login', ['class' => 'btn btn-success btn-block']) }}

            {!! Form::close() !!}
        </div>
    </div>

@endsection