<?php

Route::post('/deploys', 'DeploysController@create');

Route::post('slack/options', 'SlackController@options');
Route::post('slack/request', 'SlackController@request');
