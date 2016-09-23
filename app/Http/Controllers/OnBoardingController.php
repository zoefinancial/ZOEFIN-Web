<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\OnBoarding;
use App\Http\Requests;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;

class OnBoardingController extends Controller
{
    public function create()
    {
        return view('onboarding');
    }

    public function store()
    {
        $data = request()->all();

        $data['date_birth'] = $this->ageToDate($data['age']);

        unset($data['age']);


        $onBoarding = OnBoarding::create($data);

        Cookie::queue('on_boarding', $onBoarding['attributes'], 45000);

        if ( ($data['income'] * 1) >= 120000 ) { //120.000 should be inside parameter
            return view('onboarding/success');
        }
        return view('onboarding/recommend');
    }

    private function ageToDate($age)
    {
        $dt = new Carbon();
        return $dt->subYears($age);
    }
}
