<?php

// Request account
Route::get('/account/request', ['as' => 'account.request', 'uses' => 'Account\RequestController@get_request']);
Route::post('/account/request', ['uses' => 'Account\RequestController@post_request']);
// Verify email and create account
Route::get('/account/email/verify',
    [
        'as' => 'account.request.verify_email',
        'uses' => 'Account\VerificationController@get_verify'
    ]);
Route::post('/account/email/verify', ['uses' => 'Account\VerificationController@post_verify']);
