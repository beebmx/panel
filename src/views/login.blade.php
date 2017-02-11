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
    							Iniciar sesión
    						</legend>
    						<p>
    							Para iniciar sesión, ingrese su usuario y contraseña
    						</p>
    						<div class="form-group">
    							<span class="input-icon">
    								<input type="email" class="form-control" name="email" value="{{ old('email', '') }}" placeholder="E-mail">
    								<i class="ti-user"></i>
                                </span>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
    						</div>
    						<div class="form-group form-space">
    							<span class="input-icon">
    								<input type="password" class="form-control password" name="password" placeholder="Contraseña">
    								<i class="ti-lock"></i>
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
    									Mantenerme conectado
    								</label>
    							</div>
    							<button type="submit" class="btn btn-primary pull-right">
    								Ingresar
    							</button>
    						</div>
    					</fieldset>
    				</form>
                </div>
                    
                    
                
                    

                
                
            </div>
            {{--
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                                
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <input type="checkbox" class="checkboxes" id="remember-me">
                                    <label for="remember-me"> Remember Me </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                                    </div>
            </div>
            --}}
        </div>
    </div>
</div>
@endsection
