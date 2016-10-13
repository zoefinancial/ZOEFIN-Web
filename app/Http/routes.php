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

use Illuminate\Http\Request;

Route::get('/', function () {
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
            return view('dashboard', ["page_title"=>"Zoe Financial Dashboard", "side_bar_active_item"=>'dashboard']);
        }
    ]
);

Route::get('/home', 'HomeController@getHome');

Route::post('/api/home', 'HomeController@store');

Route::put('/api/home', 'HomeController@update');

Route::delete('/api/home', 'HomeController@delete');

Route::post('/api/car/', 'CarController@store');

Route::put('/api/car/', 'CarController@update');

Route::delete('/api/car/', 'CarController@delete');

Route::post('/api/loan/', 'LoanController@store');

Route::delete('/api/loan/', 'LoanController@delete');

Route::put('/api/loan/', 'LoanController@update');

Route::post('/api/bankingaccount', 'BankingAccountController@store');

Route::post('/api/investment', 'InvestmentController@store');

Route::delete('/api/investment', 'InvestmentController@delete');

Route::put('/api/investment', 'InvestmentController@update');

Route::get('/investment', 'InvestmentController@index');

Route::get('/api/investment/taxable', 'InvestmentController@taxable');

Route::get('/api/investment/vehicle', 'InvestmentController@vehicleTable');

Route::get('/taxes', 'TaxesController@index');

Route::get('/budgeting', 'BudgetingController@index');

Route::get('/budgeting/expenses', 'BudgetingController@expenses');

Route::get('/insurance',
    ['middleware' => 'auth',
        function () {
            return view('insurance', ["page_title"=>"Insurance", 'side_bar_active_item'=>'insurance']);
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
 * Income & Expenses
 * */

Route::get('/api/incomes', 'IncomeController@getIncomes');

Route::get('/api/expenses', 'ExpenseController@getExpenses');
Route::get('/api/expenses/dates/{from}/{to}', 'ExpenseController@getExpensesBetweenDates');
Route::get('/api/expenses/dates/', 'ExpenseController@getExpenses');

Route::get('/api/expenses/dates/accounts/{from}/{to}', 'ExpenseController@getExpensesByAccountAndDate');
Route::get('/api/expenses/dates/accounts', 'ExpenseController@getExpensesTimeLineByAccount');

Route::get('/api/expenses/accounts', 'ExpenseController@getExpensesPieByAccount');
Route::get('/api/expenses/accounts/{from}/{to}', 'ExpenseController@getExpensesPieBetweenDatesByAccount');

Route::get('/api/expenses/categorization/{from}/{to}', 'ExpenseController@getExpensesCategorizationBetweenDates');
Route::get('/api/expenses/categorization/', 'ExpenseController@getExpensesCategorization');

Route::get('/api/budgeting/expenses', 'ExpenseController@getAllExpenses');
Route::get('/api/budgeting/expenses/{from}/{to}', 'ExpenseController@getAllExpensesBetweenDates');

Route::get('/api/cash_flow', 'CashFlowController@getCashFlow');



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

Route::get('/user/investments', 'InvestmentController@taxable');

/*
 * END INVESTMENTS
 * */

Route::get('/api/quovo_iframe', 'QuovoClientController@getIFrameToken');
Route::get('/api/quovo_sync', 'QuovoClientController@clientSync');
Route::get('/api/quovo_sync/detailed', 'QuovoClientController@completeSync');

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

Route::get('/test/members',
    ['middleware' => 'auth',
        function () {
            return Auth::user()->getFamilyMembers();
        }
    ]
);

Route::post('/taxesUpload',
    array('middleware' => 'auth',
        function (Request $request) {
            if ($request->hasFile('taxfile')) {
                $destinationPath = env('S3_ENV', 'dev').'/'.Auth::user()->id.'_'.str_slug(Auth::user()->email).'/taxes/'.$request->get('year').'/'; // upload path
                $fileName = $request->file('taxfile')->getClientOriginalName(); // renameing image
                $path=$destinationPath.$fileName;
                $uploadedFile = $request->file('taxfile');
                $s3 = Storage::disk('s3');
                $s3->put($path, file_get_contents($uploadedFile));
                return redirect('taxes');
            }
        }
    )
);

Route::post('/profileUpload',
    array('middleware' => 'auth',
        function (Request $request) {
            if ($request->hasFile('imageFileName')) {
                $destinationPath = env('S3_ENV', 'dev').'/'.Auth::user()->id.'_'.str_slug(Auth::user()->email).'/profile/'; // upload path
                $fileExtension = $request->file('imageFileName')->getClientOriginalExtension();
                $fileName = 'ProfilePicture.'.$fileExtension;
                $path=$destinationPath.$fileName;
                $uploadedFile = $request->file('imageFileName');
                $s3 = Storage::disk('s3');
                $s3->put($path, file_get_contents($uploadedFile));
                return Redirect::back();
            }
            return Redirect::back();
        }
    )
);

Route::post('/insuranceUpload',
    array('middleware' => 'auth',
        function (Request $request) {
            if ($request->hasFile('insurancefile')) {
                $destinationPath = env('S3_ENV', 'dev').'/'.Auth::user()->id.'_'.str_slug(Auth::user()->email).'/insurance/'.$request->get('individual').'/'; // upload path
                $fileName = $request->file('insurancefile')->getClientOriginalName(); // renameing image
                $path=$destinationPath.$fileName;
                $uploadedFile = $request->file('insurancefile');
                $s3 = Storage::disk('s3');
                $s3->put($path, file_get_contents($uploadedFile));
                return redirect('insurance');
            }
            return ['Error'=>'Oops! Something went wrong'];
        }
    )
);

Route::post('/budgetingUpload',
    array('middleware' => 'auth',
        function (Request $request) {
            if ($request->hasFile('budgetingFile')) {
                $destinationPath = env('S3_ENV', 'dev').'/'.Auth::user()->id.'_'.str_slug(Auth::user()->email).'/budgeting/'.$request->get('filePeriod').'/'.$request->get('fileType').'/'; // upload path
                $fileName = $request->file('budgetingFile')->getClientOriginalName(); // renameing image
                $path=$destinationPath.$fileName;
                $uploadedFile = $request->file('budgetingFile');
                $s3 = Storage::disk('s3');
                $s3->put($path, file_get_contents($uploadedFile));
                return redirect('budgeting');
            }
            return redirect('budgeting');
        }
    )
);

Route::get('/getFile',
    array('middleware' => 'auth',
        function (Request $request) {
            $f=$request->get('f');
            $file_name=base64_decode($f);
            $s3 = Storage::disk('s3');
            $file_content=$s3->get($file_name);
            $response = response($file_content, 200, [
                'Content-Type' => 'application/pdf',
                //'Content-Length' => $file_content->length,
                'Content-Description' => 'File Transfer',
                'Content-Disposition' => 'attachment; filename='.basename($file_name),
                'Content-Transfer-Encoding' => 'binary',
            ]);
            return $response;
        }
    )
);

Route::post('/renameFile',
    array('middleware' => 'auth',
        function (Request $request) {
            $file_name=base64_decode($request->get('rename_old_file_name'));
            $new_file_name=$request->get('rename_new_file_name');
            if (!str_is('*.pdf', $new_file_name)) {
                if (!str_is('*.PDF', $new_file_name)) {
                    $new_file_name = str_finish($new_file_name, '.pdf');
                }
            }
            $s3 = Storage::disk('s3');
            $directory=dirname($file_name);
            $s3->move($file_name, $directory.'/'.$new_file_name);
            return ['Information'=>'File '.basename($file_name).' renamed to '.$new_file_name];
        }
    )
);

Route::post('/deleteFile',
    array('middleware' => 'auth',
        function (Request $request) {
            $file_name=base64_decode($request->get('delete_file_name'));
            $s3 = Storage::disk('s3');
            $s3->delete($file_name);
            return ['Information'=>'File '.basename($file_name).' deleted'];
        }
    )
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
