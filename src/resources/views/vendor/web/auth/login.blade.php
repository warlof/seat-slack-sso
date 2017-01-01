@extends('web::layouts.app-mini')

@section('title', trans('web::seat.sign_in'))

@section('content')

    <div class="login-logo">
        S<b>e</b>AT | {{ trans('web::seat.sign_in') }}
    </div>

    <hr>

    <div class="login-box-body">
        <p class="login-box-msg">
            {{ trans('web::seat.login_welcome') }}
        </p>

        <form action="{{ route('auth.login.post') }}" class="form-horizontal" method="post">
            {{ csrf_field() }}

            <div class="box-body">
                <div class="form-group has-feedback">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                           placeholder="{{ trans('web::seat.username') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="{{ trans('web::seat.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <div class="col-sm-10">
                        <div class="checkbox pull-left">
                            <label>
                                <input type="checkbox" name="remember"> {{ trans('web::seat.remember_me') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <div class="pull-left">
                    <a href="{{ route('password.email') }}">{{ trans('web::seat.forgot') }}</a><br>
                    @if(setting('registration', true) === 'yes')
                        <a href="{{ route('auth.register') }}" class="text-center">{{ trans('web::seat.register') }}</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary pull-right">{{ trans('web::seat.sign_in') }}</button>
            </div>
            <!-- /.box-footer -->

            @if ((setting('allow_sso', true) === 'yes') && (setting('warlof.slack.sso.allowed', true) == '1'))
                <button type="button" class="btn btn-primary btn-lg center-block" data-toggle="modal" data-target="#sso-authentication">
                    <i class="fa fa-key"></i> Sign in with an external account
                </button>

                <div class="modal fade" id="sso-authentication" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Choose an authority</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @if(setting('allow_sso', true) === 'yes')
                                    <div class="col-md-6">
                                        <a href="{{ route('auth.eve') }}">
                                            <img src="{{ asset('web/img/evesso.png') }}">
                                        </a>
                                    </div>
                                    @endif
                                    @if(setting('warlof.slack.sso.allowed', true) == '1')
                                        <div class="col-md-6 text-center">
                                            <a href="{{ route('warlof.slack.sso.auth.slack') }}">
                                                <img alt="Sign in with Slack" height="40" width="172"
                                                     src="https://platform.slack-edge.com/img/sign_in_with_slack.png"
                                                     srcset="https://platform.slack-edge.com/img/sign_in_with_slack.png 1x, https://platform.slack-edge.com/img/sign_in_with_slack@2x.png 2x" />
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else

            <!-- SSO Button! -->
            @if(setting('allow_sso', true) === 'yes')
                <div class="box-footer text-center">
                    <a href="{{ route('auth.eve') }}">
                        <img src="{{ asset('web/img/evesso.png') }}">
                    </a>
                </div>
                <!-- /.box-footer -->
            @endif

            <!-- Slack SSO Button ! -->
            @if(setting('warlof.slack.sso.allowed', true) == '1')
            <div class="box-footer text-center">
                <a href="{{ route('warlof.slack.sso.auth.slack') }}">
                    <img alt="Sign in with Slack" height="40" width="172"
                         src="https://platform.slack-edge.com/img/sign_in_with_slack.png"
                         srcset="https://platform.slack-edge.com/img/sign_in_with_slack.png 1x, https://platform.slack-edge.com/img/sign_in_with_slack@2x.png 2x" />
                </a>
            </div>
            @endif
            @endif

        </form>

    </div>
    <!-- /.login-box-body -->

@stop
