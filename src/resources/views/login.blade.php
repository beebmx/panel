@section('title', 'Login')
@section('module', 'login')
@extends('panel::layouts.login')

@section('content')
<section id="login" class="section">
    <div class="content">
        <form ref="form" class="form-login" method="post" action="{{ route('panel.login') }}">
        {!! csrf_field() !!}
        <div class="columns">
            <div class="column is-offset-4 is-4">
                <div class="card">
                    <div class="card-header">
                        @if (config('panel.logo') !== null)
                            <figure class="image">
                                <img src="{{ asset(config('panel.logo')) }}" alt="{{ config('panel.name') }}" />
                            </figure>
                        @else
                            <div>{{ config('panel.name') }}</div>
                        @endif
                    </div>
                    <div class="card-content">
                    
                        <div class="field">
                            <div class="control has-icons-left has-icons-right">
                                <input class="input{{ $errors->has('email') ? ' is-danger' : '' }}" type="email" placeholder="{{ trans('panel::login.email') }}" value="{{ old('email', '') }}" name="email" autocomplete="off" />
                                <span class="icon is-small is-left"><i class="fal fa-envelope"></i></span>
                            </div>
                            @if ($errors->has('email'))
                                <p class="help is-danger">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <div class="control has-icons-left has-icons-right">
                                <input class="input{{ $errors->has('password') ? ' is-danger' : '' }}" type="password" placeholder="{{ trans('panel::login.password') }}" value="{{ old('password', '') }}" name="password" autocomplete="off" />
                                <span class="icon is-small is-left"><i class="fal fa-lock"></i></span>
                            </div>
                             @if ($errors->has('password'))
                                <p class="help is-danger">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <input class="is-checkradio is-small is-primary has-background-color" id="remember" type="checkbox" name="remember" />
                            <label for="remember">@lang('panel::login.remember')</label>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="card-footer-item">
                            <div class="control">
                                <button type="submit" class="button is-primary">{{ trans('panel::login.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>
@endsection
