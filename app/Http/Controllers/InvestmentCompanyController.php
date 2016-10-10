<?php

namespace App\Http\Controllers;

use App\InvestmentCompany;
use Illuminate\Http\Request;

use App\Http\Requests;

class InvestmentCompanyController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
                'quovo_id' =>     'required',
                'name' =>     'required',
            ]);
        $investmentCompany = new InvestmentCompany($request->all());
        $investmentCompany->save();
    }

    
}
