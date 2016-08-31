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
            return response()->json(Auth::user()->getNetWorth());
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

Route::get('/user/investments',
    ['middleware' => 'auth',
        function () {
            return response()->json(Auth::user()->getInvestments());
        }
    ]
);


Route::auth();

Route::get('/home', 'HomeController@index');
