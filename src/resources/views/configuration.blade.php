@extends('web::layouts.grids.4-8')

@section('title', trans('web::seat.sign_in'))
@section('page_header', trans('web::seat.sign_in'))

@section('left')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('slacksso::seat.configuration') }}</h3>
        </div>
        <div class="panel-body">
            <form role="form" action="{{ route('warlof.slack.sso.configuration.post') }}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="box-body">

                    <legend>{{ trans('slacksso::seat.slack-api') }}</legend>

                    <p class="callout callout-warning text-justify">{!! trans('slacksso::seat.existing-credentials-disclaimer') !!}</p>

                    <div class="form-group">
                        <label for="slack-configuration-client" class="col-md-4">{{ trans('slacksso::seat.client-id') }}</label>
                        <div class="col-md-7">
                            <div class="input-group input-group-sm">
                                @if (setting('warlof.slack.sso.credentials.client_id', true) == null)
                                    <input type="text" class="form-control" id="slack-configuration-client"
                                           name="slack-configuration-client" />
                                @else
                                    <input type="text" class="form-control " id="slack-configuration-client"
                                           name="slack-configuration-client" value="{{ setting('warlof.slack.sso.credentials.client_id', true) }}" readonly />
                                @endif
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-danger btn-flat" id="client-eraser">
                                        <i class="fa fa-eraser"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="slack-configuration-secret" class="col-md-4">{{ trans('slacksso::seat.client-secret') }}</label>
                        <div class="col-md-7">
                            <div class="input-group input-group-sm">
                                @if (setting('warlof.slack.sso.credentials.client_secret', true) == null)
                                    <input type="text" class="form-control" id="slack-configuration-secret"
                                           name="slack-configuration-secret" />
                                @else
                                    <input type="text" class="form-control" id="slack-configuration-secret"
                                           name="slack-configuration-secret" value="{{ setting('warlof.slack.sso.credentials.client_secret', true) }}" readonly />
                                @endif
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-danger btn-flat" id="secret-eraser">
                                        <i class="fa fa-eraser"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="slack-sso-enabled" class="col-md-4">{{ trans('slacksso::seat.enable-slack-sso') }}</label>
                        <div class="col-md-7">
                            <div class="radio">
                                <label>
                                    @if (setting('warlof.slack.sso.allowed', true) != "1")
                                    <input type="radio" name="slack-sso-enabled" value="0" checked />
                                    @else
                                    <input type="radio" name="slack-sso-enabled" value="0" />
                                    @endif
                                    {{ trans('web::seat.no') }}
                                </label>
                                <label>
                                    @if (setting('warlof.slack.sso.allowed', true) == "1")
                                    <input type="radio" name="slack-sso-enabled" value="1" checked />
                                    @else
                                    <input type="radio" name="slack-sso-enabled" value="1" />
                                    @endif
                                    {{ trans('web::seat.yes') }}
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">{{ trans('slacksso::seat.update') }}</button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('javascript')
<script type="application/javascript">
    $('#client-eraser').click(function(){
        $('#slack-configuration-client').val('');
        $('#slack-configuration-client').removeAttr("readonly");
    });

    $('#secret-eraser').click(function(){
        $('#slack-configuration-secret').val('');
        $('#slack-configuration-secret').removeAttr("readonly");
    });
</script>
@endpush