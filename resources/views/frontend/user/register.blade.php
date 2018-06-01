@extends('frontend/layouts/master') @section('title', 'Register') @section('menu', 'Register') @section('content') @include('frontend/shared/breadcrumbs')
<!--register-starts-->
<div class="register">
    <div class="container">
        <div class="register-top heading">
            <h2>{{ __('REGISTER') }}</h2>
        </div>
        <div class="register-main">
            {{ Form::open(array('route'=>'postRegister', 'id'=>'customer_register', 'method'=>'post')) }}
                {{ Form::token() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="loginbox form-horizontal">
                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                {{ Form::label('inputlastName', __('Last name *'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::text('last_name', old('last_name'), array('class' => 'form-control')) }}
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                {{ Form::label('inputfisrtName', __('Fisrt name *'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::text('first_name', old('first_name'), array('class' => 'form-control')) }}
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                {{ Form::label('inputemail', __('Email *'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::email('email', old('email'), array('class' => 'form-control')) }}
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                {{ Form::label('inputpassword', __('Password *'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::password('password', array('class' => 'form-control')) }}
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                                {{ Form::label('inputpassword', __('Confirm Password *'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::password('confirm_password', array('class' =>'form-control')) }}
                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="loginbox form-horizontal">
                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                {{ Form::label('inputphone', __('Phone number *'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::text('phone', old('phone'), array('class' => 'form-control')) }}
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                {{ Form::label('inputsex', __('Sex'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::select('sex', array('0' => 'Male', '1' => 'Female'), '0', array('class' => 'form-control')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('inputbirthday', __('Birthday'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::date('date', old('date'), array('class' => 'form-control')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('inputaddress', __('Address'), array('class' => 'control-label col-md-4 w3-right-align')) }}
                                <div class="col-md-7">
                                    {{ Form::text('address', old('address'), array('class' => 'form-control')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-5"></div>
                            <div class="col-md-2">
                                {{ Form::submit(__('SEND'), array('class' => 'btn btn-block w3-green w3-margin')) }}
                            </div>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--register-end-->
@endsection
