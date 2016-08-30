<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    //phpinfo();
    return redirect('dashboard');
});

Route::get('/dashboard',
    ['middleware' => 'auth',
        function () {
            return view('charts',["page_title"=>"Zoe Financial Dashboard"]);
        }
    ]
);

Route::get('/user/net_worth',
    ['middleware' => 'auth',
        function () {
            return response()->json(['Assets' => '817000', 'Liabilities' => '226600','Net Worth'=>'590400']);
        }
    ]
);

Route::get('/user/cash_flow',
    ['middleware' => 'auth',
        function () {
            return response()->json(
                [
                    'Income after tax' => [
                        '2012' => 130000,
                        '2013' => 135000,
                        '2014' => 150000,
                        '2015' => 155000,
                        '2016' => 165000,
                        '2017' => 175000
                    ],
                    'Expenses' => [
                        '2012' => 120000,
                        '2013' => 120000,
                        '2014' => 125000,
                        '2015' => 140000,
                        '2016' => 145000,
                        '2017' => 150000,
                    ],
                    'Savings' => [
                        '2012' => 10000,
                        '2013' => 15000,
                        '2014' => 25000,
                        '2015' => 15000,
                        '2016' => 20000,
                        '2017' => 25000,
                    ]
                ]
            );
        }
    ]
);

Route::get('/user/investments',
    ['middleware' => 'auth',
        function () {
            return response()->json(
                [
                    'Investments'=>[
                        '401k'=>'40000',
                        'IRA'=>'50000',
                        'JPM Funds'=>'20000',
                        'E-Trade'=>'15000'
                    ],
                    'Taxes Related Info'=>[
                        'Taxable'=>'90000',
                        'Tax Defered'=>'35000'
                    ]
                ]
            );
        }
    ]
);


Route::auth();

Route::get('/home', 'HomeController@index');
