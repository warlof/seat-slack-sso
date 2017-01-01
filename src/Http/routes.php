<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 29/12/2016
 * Time: 20:47
 */

Route::group([
    'namespace' => 'Warlof\Seat\Slack\Sso\Http\Controllers',
    'prefix' => 'slacksso',
    'middleware' => 'web'
], function(){

    Route::get('/auth', [
        'as' => 'warlof.slack.sso.auth.slack',
        'uses' => 'SlackSsoController@redirectToProvider'
    ]);

    Route::get('/auth/callback', [
        'as' => 'warlof.slack.sso.auth.callback',
        'uses' => 'SlackSsoController@handleProviderCallback'
    ]);

    Route::get('/auth/confirmation', [
        'as' => 'warlof.slack.sso.auth.confirmation',
        'uses' => 'SlackSsoController@getSsoConfirmation'
    ]);

    Route::post('/auth/confirmation', [
        'as' => 'warlof.slack.sso.auth.confirm',
        'uses' => 'SlackSsoController@postSsoConfirmation'
    ]);

    Route::get('/configuration', [
        'as' => 'warlof.slack.sso.configuration',
        'uses' => 'SlackSsoController@getConfiguration'
    ]);

    Route::post('/configuration', [
        'as' => 'warlof.slack.sso.configuration.post',
        'uses' => 'SlackSsoController@postConfiguration'
    ]);

});