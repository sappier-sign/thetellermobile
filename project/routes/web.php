<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

$app->get('/', function () use ($app) {
    return $app->version();
});

// POS Routes
$app->group(['prefix' => 'pos'], function ($app)  {
    $app->post('purchase', function (Request $request){
        $this->validate($request, [
            'merchant_id'   =>  'bail|required|size:12|alpha_dash',
            'terminal_id'   =>  'bail|required|size:8|numeric'
        ]);
    });
});

$app->get('/users', 'UserController@index');

$app->post('/register', function (Request $request){
	$this->validate($request, [
		'userEmail'		=> 'bail|required|min:6|max:100|unique:tlr_users',
		'userPassword'	=> 'bail|required|min:6|max:100',
		'userFirstName'	=> 'bail|required|min:2|max:100',
		'userLastName'	=> 'bail|required|min:2|max:100',
		'userPhone'		=> 'bail|required|digits_between:12,16|unique:tlr_users',
	],[
	    'userPhone.digits_between'  =>  'Phone number must be in international format! Eg. 2332498273645'
    ]);

	return UserController::store($request);
});

# User Login
$app->post('/login', function (Request $request){
	$this->validate($request, [
		'userEmail'		=> 'bail|required|min:6|max:100',
		'userPassword'	=> 'bail|required|min:6|max:100'
	]);

	return UserController::show($request);
});

# User Update
$app->post('/user/update', 'UserController@update');

# User Change Password
$app->put('user/changepassword', function (Request $request){
	$this->validate($request, [
		'oldPassword'		=>	'bail|required|min:6|max:100',
		'newPassword'		=>	'bail|required|min:6|max:100',
		'confirmPassword'	=>	'bail|required|min:6|max:100'
	]);
	$userController = new UserController($request);
	return $userController->changePassword($request);
});

$app->get('/payment/source/categories', 'PaymentSourceCategoryController@index');
$app->get('/payment/source/category/{id}', 'PaymentSourceCategoryController@show');
$app->get('/services', 'ServiceController@index');
$app->get('/service/categories', 'CategoryController@index');
$app->get('/service/category/{id}', 'CategoryController@show');
$app->get('/service/providers', 'ServicesProviderController@index');
$app->get('/service/provider/{id}', 'ServicesProviderController@show');
$app->get('/transaction/history', 'TransactionController@getUserHistory');

$app->post('/transaction/{action}', function (Request $request, $action) {

    $this->validate($request, [
        "serviceKey"        =>  'bail|required|exists:tlr_services,serviceKey',
        "providerKey"       =>  'bail|required|exists:tlr_services_providers,providerKey',
        "categoryKey"       =>  'bail|required|exists:tlr_categories,categoryKey',
        "transactionSRN"    =>  'bail|required',
        "transactionCharge" =>  'bail|required',
        "transactionAmount" =>  'bail|required',
        "billingAmount"     =>  'bail|required',
        "paymentSourceKey"  =>  'bail|required|exists:tlr_payment_sources,paymentSourceKey'
    ]);

    $transactionController = new TransactionController();
    return $transactionController->handle($request, $action);
});

$app->post('/verify/phone_number', function (Request $request){
    $this->validate($request, [
        "phone_number"  =>  "bail|required|digits:12",
        "user_id"       =>  "bail|required|min:12"
    ]);

    return \App\User::verifyNumber($request->phone_number, $request->user_id);
});

$app->post('/login/pin', function (Request $request){
    $this->validate($request, [
        'userPin' => 'bail|required|digits:4'
    ]);

    $userController = new UserController($request);
    return $userController->pinLogin($request->userPin);

});

$app->post('sms/send', 'UserController@sendSms');
