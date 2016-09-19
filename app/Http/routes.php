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

Route::get('/onboarding', 'OnBoardingController@create');

Route::post('/onboarding', 'OnBoardingController@store');

/*
 * Side Menu options
 * */

Route::get('/dashboard',
    ['middleware' => 'auth',
        function () {
            return view('dashboard',["page_title"=>"Zoe Financial Dashboard","side_bar_active_item"=>'dashboard']);
        }
    ]
);

Route::get('/insurance',
    ['middleware' => 'auth',
        function () {
            return view('insurance',["page_title"=>"Insurance",'side_bar_active_item'=>'insurance']);
        }
    ]
);

Route::get('/taxes',
    ['middleware' => 'auth',
        function () {
            return view('taxes',["page_title"=>"Taxes",'side_bar_active_item'=>'taxes']);
        }
    ]
);

/*
 * END Side Menu options
 * */

/*
 * Web Services
 * */

/*
 * INSURANCE
 * */

Route::get('/user/insurance/prediction/{id}',
    ['middleware' => 'auth',
        function ($id) {
            return response()->json(Auth::user()->getInsurancePrediction($id));
        }
    ]
);

Route::get('/user/insurance/summary',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getInsuranceSummary());
        }
    ]
);

/*
 * END INSURANCE
 * */

/*
 * NET WORTH
 * */

Route::get('/user/net_worth',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getNetWorth());
        }
    ]
);

Route::get('/user/net_worth/detailed',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getDetailedNetWorth());
        }
    ]
);



Route::get('/user/cash_flow',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getCashFlow());
        }
    ]
);

/*
 * END NET WORTH
 * */

/*
 * TAXES
 * */

Route::get('/user/taxes/summary',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getTaxesInformation());
        }
    ]
);

Route::get('/user/taxes/total/{year}',
    ['middleware' => 'auth',
        function ($year) {
            return response()->json(Auth::user()->getTotalTaxes($year));
        }
    ]
);

Route::get('/user/taxes/detailed/{year}',
    ['middleware' => 'auth',
        function ($year) {
            return response()->json(Auth::user()->getDetailedTaxes($year));
        }
    ]
);

Route::get('/user/taxes/comparison',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getTaxesComparison());
        }
    ]
);

/*
 * END TAXES
 * */

/*
 * INVESTMENTS
 * */

Route::get('/user/investments',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getInvestments());
        }
    ]
);

/*
 * END INVESTMENTS
 * */

/*
 * Test web services
 * */

Route::post('/test/forms',
    ['middleware' => 'auth',
        function () {
            return response()->json(request()->all());
        }
    ]
);


Route::post('/authenticate',
    ['middleware' => 'auth',
        function () {
            $response = request()->all();

            /*
             array(5) {
                ["_token"]=> string(40) "UcBuX5t8TJ2ojZaCQl4odDChv9Efa3CreaQmKzRe"
                ["account"]=> string(15) "[object Object]"
                ["account_id"]=> string(0) ""
                ["institution"]=> array(2) {
                    ["name"]=> string(5) "Chase"
                    ["type"]=> string(5) "chase"
                    }
                ["public_token"]=> string(128) "5cbfe0e25cdbaceb833b127a8661b87a4e29d7b18f111d0da19c23ed9d412d208284db83e52f7cfdc86d1e684a40f45ada62dc19f185af36db31aac96f4c9b01"
            }
             * */
            $plaidToken = new App\PlaidTokens;
            $plaidToken->user_id=Auth::user()->id;
            $plaidToken->institution_name=$response['institution']['name'];
            $plaidToken->institution_type=$response['institution']['type'];
            $plaidToken->public_token=$response['public_token'];
            $plaidToken->save();
            return redirect('dashboard');
        }
    ]
);

/*
 * END Test web services
 * */

/*
 * END Web Services
 * */

/*
 * Authentication
 * */

Route::auth();

Route::get('/home', ['middleware' => 'auth']);
