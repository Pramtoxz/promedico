<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');

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

// Admin & Dokter & Pimpinan dashboard (protected by auth filter)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
});

// Pasien routes (protected by auth filter and role filter)
$routes->group('pasien', ['filter' => ['auth', 'role:pasien,admin,dokter,pimpinan']], function ($routes) {
    $routes->get('/', 'PasienController::index');
    $routes->get('view', 'PasienController::viewPasien');
    $routes->post('detail', 'PasienController::getPasienDetail');
    $routes->get('formtambah', 'PasienController::formtambah');
    $routes->post('save', 'PasienController::save');
    $routes->get('formedit/(:segment)', 'PasienController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'PasienController::updatedata/$1');
    $routes->get('detail/(:segment)', 'PasienController::detail/$1');
    $routes->post('delete', 'PasienController::delete');
    $routes->post('createUser/(:segment)', 'PasienController::createUser/$1');
    $routes->post('updatePassword/(:segment)', 'PasienController::updatePassword/$1');
});


// Dokter routes (protected by auth filter and role filter)
$routes->group('dokter', ['filter' => ['auth', 'role:admin,dokter,pimpinan']], function ($routes) {
    $routes->get('/', 'DokterController::index');
    $routes->get('view', 'DokterController::viewDokter');
    $routes->post('detail', 'DokterController::getDokterDetail');
    $routes->get('formtambah', 'DokterController::formtambah');
    $routes->post('save', 'DokterController::save');
    $routes->get('formedit/(:segment)', 'DokterController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'DokterController::updatedata/$1');
    $routes->get('detail/(:segment)', 'DokterController::detail/$1');
    $routes->post('delete', 'DokterController::delete');
    $routes->post('createUser/(:segment)', 'DokterController::createUser/$1');
    $routes->post('updatePassword/(:segment)', 'DokterController::updatePassword/$1');
});

// Jadwal routes (protected by auth filter and role filter)
$routes->group('jadwal', ['filter' => ['auth', 'role:admin,dokter,pimpinan']], function ($routes) {
    $routes->get('/', 'JadwalController::index');
    $routes->get('view', 'JadwalController::viewJadwal');
    $routes->get('formtambah', 'JadwalController::formtambah');
    $routes->post('save', 'JadwalController::save');
    $routes->get('formedit/(:segment)', 'JadwalController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'JadwalController::updatedata/$1');
    $routes->get('detail/(:segment)', 'JadwalController::detail/$1');
    $routes->post('delete', 'JadwalController::delete');
    $routes->post('toggleStatus', 'JadwalController::toggleStatus');
    $routes->get('getdokter', 'JadwalController::getdokter');
    $routes->get('viewGetDokter', 'JadwalController::viewGetDokter');
});

// Jadwal routes (protected by auth filter and role filter)
$routes->group('jenis', ['filter' => ['auth', 'role:admin,dokter,pimpinan']], function ($routes) {
    $routes->get('/', 'JenisController::index');
    $routes->get('view', 'JenisController::viewJenis');
    $routes->get('formtambah', 'JenisController::formtambah');
    $routes->post('save', 'JenisController::save');
    $routes->get('formedit/(:segment)', 'JenisController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'JenisController::updatedata/$1');
    $routes->get('detail/(:segment)', 'JenisController::detail/$1');
    $routes->post('delete', 'JenisController::delete');
});

// Obat routes (protected by auth filter and role filter)
$routes->group('obat', ['filter' => ['auth', 'role:admin,dokter,pimpinan']], function ($routes) {
    $routes->get('/', 'ObatController::index');
    $routes->get('view', 'ObatController::viewObat');
    $routes->get('formtambah', 'ObatController::formtambah');
    $routes->post('save', 'ObatController::save');
    $routes->get('formedit/(:segment)', 'ObatController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'ObatController::updatedata/$1');
    $routes->get('detail/(:segment)', 'ObatController::detail/$1');
    $routes->post('delete', 'ObatController::delete');
});

// Booking routes (protected by auth filter and role filter)
$routes->group('booking', ['filter' => ['auth', 'role:admin,dokter,pimpinan']], function ($routes) {
    $routes->get('/', 'BookingController::index');
    $routes->get('view', 'BookingController::viewBooking');
    $routes->get('formtambah', 'BookingController::formtambah');
    $routes->post('save', 'BookingController::save');
    $routes->get('formedit/(:segment)', 'BookingController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'BookingController::updatedata/$1');
    $routes->get('detail/(:segment)', 'BookingController::detail/$1');
    $routes->post('delete', 'BookingController::delete');
    $routes->post('updateStatus', 'BookingController::updateStatus');
    $routes->post('checkSlotAvailability', 'BookingController::checkSlotAvailability');
    $routes->post('findAvailableSlot', 'BookingController::findAvailableSlot');
    $routes->post('checkDayMatch', 'BookingController::checkDayMatch'); // New route
    $routes->get('getPasien', 'BookingController::getPasien');
    $routes->get('viewGetPasien', 'BookingController::viewGetPasien');
    $routes->get('getJadwal', 'BookingController::getJadwal');
    $routes->get('viewGetJadwal', 'BookingController::viewGetJadwal');
});

