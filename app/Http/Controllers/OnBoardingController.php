<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\OnBoarding;
use App\Http\Requests;
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

        OnBoarding::create($data);
    }

    private function ageToDate($age)
    {
        $dt = new Carbon();
        return $dt->subYears($age);
    }
}
