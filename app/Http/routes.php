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


Route::get('/user/insurance/prediction',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getInsurancePrediction());
        }
    ]
);

Route::get('/user/net_worth',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getNetWorth());
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

Route::get('/user/detailed/net_worth',
    ['middleware' => 'auth',
        function () {
            return response()->json( Auth::user()->getDetailedNetWorth());
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

Route::get('/user/taxes',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getTaxesInformation());
        }
    ]
);

Route::get('/user/investments',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getInvestments());
        }
    ]
);


Route::auth();

Route::get('/home', 'HomeController@index');
