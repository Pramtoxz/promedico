<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('booking', 'Home::booking', ['filter' => 'auth']);

// Auth Routes
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// Register dengan OTP
$routes->get('auth/register', 'Auth::registerForm');
$routes->post('auth/register', 'Auth::register');
$routes->post('auth/verify-register-otp', 'Auth::verifyRegisterOTP');

// Forgot Password dengan OTP
$routes->get('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/verify-forgot-password-otp', 'Auth::verifyForgotPasswordOTP');
$routes->post('auth/reset-password', 'Auth::resetPassword');

// Resend OTP
$routes->post('auth/resend-otp', 'Auth::resendOTP');

// Admin Routes
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Admin::index', ['filter' => 'role:admin,manager']);

    // User Management (hanya admin)
    $routes->group('', ['filter' => 'role:admin'], function ($routes) {
        $routes->get('users', 'Admin::users');
        $routes->get('getUsers', 'Admin::getUsers');
        $routes->get('getUser/(:num)', 'Admin::getUser/$1');
        $routes->post('createUser', 'Admin::createUser');
        $routes->post('addUser', 'Admin::addUser');
        $routes->post('updateUser/(:num)', 'Admin::updateUser/$1');
        $routes->post('deleteUser/(:num)', 'Admin::deleteUser/$1');
        $routes->get('getRoles', 'Admin::getRoles');
    });

    // Add routes for user management
    $routes->get('users', 'Admin::users');
    $routes->get('users/datatable', 'Admin::usersDatatable');
    $routes->post('users/detail', 'Admin::getUserDetail');
    $routes->get('users/create', 'Admin::createUser');
    $routes->post('users/store', 'Admin::storeUser');
    $routes->get('users/edit/(:num)', 'Admin::editUser/$1');
    $routes->post('users/update/(:num)', 'Admin::updateUser/$1');
    $routes->post('users/delete', 'Admin::deleteUser');
});

// Tamu Routes - dipisahkan dari admin routes
$routes->group('tamu', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Tamu::index');
    $routes->get('viewtamu', 'Tamu::viewTamu');
    $routes->post('detail', 'Tamu::getTamuDetail');
    $routes->get('create', 'Tamu::createTamu'); 
    $routes->post('store', 'Tamu::storeTamu');
    $routes->get('edit/(:segment)', 'Tamu::editTamu/$1');
    $routes->post('update/(:segment)', 'Tamu::updateTamu/$1');
    $routes->post('delete', 'Tamu::deleteTamu');
    $routes->post('createUserForTamu', 'Tamu::createUserForTamu');
});