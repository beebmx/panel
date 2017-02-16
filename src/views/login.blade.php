@section('title', 'Login')
@section('module', 'login')
@extends('panel::layouts.login')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="logo">
                @if (config('panel.logo') !== null)
                <a href="{{ url()->current() }}"><img src="{{ asset(config('panel.logo')) }}" alt="{{ config('panel.name') }}" /></a>
                @endif
            </div>
            <div class="panel-login">
                <div>
                    <form class="form-login" method="post" action="{{ url(config('panel.prefix').'/login') }}">
    					{!! csrf_field() !!}
    					<fieldset>
    						<legend>
    							@lang('panel::login.title')
    						</legend>
    						<p>
    							@lang('panel::login.text')
    						</p>
    						<div class="form-group">
    							<span class="input-icon">
    								<input type="email" class="form-control" name="email" value="{{ old('email', '') }}" placeholder="@lang('panel::login.email')">
    								<i class="material-icons">person</i>
                                </span>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
    						</div>
    						<div class="form-group form-space">
    							<span class="input-icon">
    								<input type="password" class="form-control password" name="password" placeholder="@lang('panel::login.password')">
    								<i class="material-icons">lock_outline</i>
                                </span>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
    						</div>
    						<div class="form-group form-space">
    							<div class="panel-checkbox">
    								<input type="checkbox" id="remember" name="remember">
    								<label for="remember">
    									@lang('panel::login.remember')
    								</label>
    							</div>
    							<button type="submit" class="btn btn-primary pull-right">
    								@lang('panel::login.submit')
    							</button>
    						</div>
    					</fieldset>
    				</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
