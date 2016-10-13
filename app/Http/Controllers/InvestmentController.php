<?php

namespace App\Http\Controllers;

use App\Investment;
use App\InvestmentCompany;
use App\InvestmentVehicle;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{

    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $investmentTable = ['box_title'=>'Investment','url'=>'/api/investment/vehicle','canvas_id'=>'investment_table','total'=>'true','moneyFormat'=>'Total','overlay'=>'1'];
        $chart_taxes     = ['box_title'=>'Investment chart','url'=>'/api/investment/taxable','canvas_id'=>'investment_chart','overlay'=>'1'];
        return view('investment', compact('investmentTable', 'chart_taxes'));
    }
    /**
     * Store Investment
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'individuals_id' =>     'required',
            'investment_vehicles_id' =>     'required',
            'investment_companies_id' =>     'required',
            'total_balance' =>     'required|max:99999999999|numeric',
            'initial' =>     'required|date',
        ]);
        try {
            $investment = new Investment($request->all());
            $investment->users_id = Auth::user()->id;
            $investment->save();

            return ['Information'=>'Investment created'];
        } catch (\Exception $e) {
            return ['Error'=>$e->getMessage()];
        }
    }

    public function delete(Request $request)
    {
        if (Investment::where('id', base64_decode($request->get('delete_investment_id')))->delete()==1) {
            return ['Information'=>'Investment deleted'];
        } else {
            return ['Error'=>'Oops! Something went wrong'];
        }
    }

    public static function getInvestments($user_id)
    {
        return Investment::where('users_id', $user_id)->get();
    }

    public function taxable()
    {
        $investment = new Investment;
        $result = $investment->taxesDistribution(Auth::user()->id);
        $graph = [];
        foreach ($result as $key => $item) {
            $graph[$item->description] = $item->total;
        }
        return response()->json($graph);
    }

    public function vehicleTable()
    {
        $investment = new Investment;

        return response()->json($investment->vehicleGroup(Auth::user()->id));
    }

    public function getInvestment($user_id, $quovo_id, $name)
    {
        return Investment::select('id', 'users_id', 'individuals_id', 'investment_vehicles_id', 'investment_companies_id', 'account_quovo_id', 'quovo_id', 'employer', 'name', 'total_balance', 'quovo_last_change')
                            ->where([['users_id', '=', $user_id], ['quovo_id', '=', $quovo_id]])
                            ->first();
    }

    public function storeMapping($data)
    {
        $investmentCompany = new InvestmentCompany();
        $company = $investmentCompany->getInvestmentCompany(['quovo_id' => $data->brokerage, 'name' => $data->brokerage_name]);
        $vehicle = InvestmentVehicle::firstOrCreate(['description' => $data->portfolio_type]);

        $investment = new Investment([
            'users_id' => $data->user_id,
            'investment_vehicles_id' => $vehicle->id,
            'investment_companies_id' => $company->id,
            'account_quovo_id' => $data->account,
            'quovo_id' => $data->id,
            'active' => !($data->is_inactive),
            'total_balance' => $data->value,
            'name' => $data->portfolio_name,
            'quovo_last_change' => $data->last_change->timestamp,
        ]);

        $investment->save();
        return true;
    }

    public function findOrCreate($data)
    {
        $investment = $this->getInvestment($data->user_id, $data->id, $data->portfolio_name);

        if (is_null($investment)) {
            $investment = $this->storeMapping($data);
        } elseif (($data->last_change->timestamp > $investment->quovo_last_change) || ($data->portfolio_name == $investment->name)) {
            $investment->quovo_last_change = $data->last_change->timestamp;
            $investment->total_balance     = $data->value;
            $investment->active            = !($data->is_inactive);
            $investment->account_quovo_id  = $data->account;
            $investment->quovo_id          = $data->id;
            $investment->save();
        }

        return $investment;
    }
}
