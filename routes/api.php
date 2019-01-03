<?php

$route->group(['prefix' => 'auth'], function ($route) {
    $route->group(['namespace' => 'Auth'], function ($route) {
        $route->post('register', 'RegisterController@register')->name('register');
        $route->post('login', 'LoginController@login')->name('login');

        $route->post('recovery', 'ForgotPasswordController@sendResetEmail')->name('password.recovery');
        $route->post('reset', 'ResetPasswordController@resetPassword')->name('password.reset');

        $route->post('logout', 'LogoutController@logout')->name('logout');
        $route->post('refresh', 'RefreshController@refresh');
    });

    $route->get('me', 'UserController@me');
});
