<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $profile_image = "";

    /**
     * Function to retrieve the Net Worth data
     */
    function getNetWorth(){
        return array('Assets' => '817000', 'Liabilities' => '226600','Net Worth'=>'590400');
    }

    /**
     * Function to retrieve the cash flow data
     */
    function getCashFlow(){
        return array(
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
        );
    }

    /**
     * Function to retrieve the Investment data
     */
    function getInvestments(){
        return array(
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
        );
    }

    function getFamilyMembers(){
        return array('1'=>['id'=>'1','name'=>'John'],'2'=>['id'=>'2','name'=>'Melissa']);
    }

    /**
     * Function to retrieve the Insurance Summary data
     */
    function getInsuranceSummary(){
        return array(
            'John'=>[
                'Coverage'=>'2000000',
                'Type'=>'Term insurance',
                'Years coverage'=>'20',
                'Annual Payment'=>'1500'
            ],
            'Melissa'=>[
                'Coverage'=>'2000000',
                'Type'=>'Term insurance',
                'Years coverage'=>'20',
                'Annual Payment'=>'1500'
            ]
        );
    }

    function getInsurancePrediction($id)
    {
        $family_resources = 257000;
        if ($id == '1') {
            $family_need = 2882164;

        } else if ($id == '2') {
            $family_need = 2149032;
        } else {
            return null;
        }
        $total = $family_need - $family_resources;
        return array(
            'Total Family Would Need' => ['Total Family Would Need' => $family_need, 'Family Resources' => '0'],
            'Available Resources' => ['Total Family Would Need' => '0', 'Family Resources' => $family_resources],
            'Insurance Need' => ['Total Family Would Need' => '0', 'Family Resources' => $total]
        );
    }

    /**
     * Function to retrieve the Net Worth detailed data
     */
    function getDetailedNetWorth(){
        $accounts = DB::select('select account_type_id,
  account_type_name,
  case when account_category_id = 1 then total else 0 end Assets,
  case when account_category_id = 2 then total else 0 end Liabilities
from (
select
  account_category_id,
  account_category_name,
  account_type_id,
  account_type_name,
  account_current_value as total
from zoefin_model_MF.Profiles
  inner join zoefin_model_MF.Accounts using (profile_id)
  inner join zoefin_model_MF.Account_types using (account_type_id)
  inner join zoefin_model_MF.Account_subcategory using (account_subcategory_id)
  inner join zoefin_model_MF.Account_category using (account_category_id)
where user_id = ?
  and account_category_id in (1,2)
group by account_category_id,account_category_name,account_type_id,account_category_name
order by account_category_id,account_category_name,account_type_id,account_category_name) AL'
            ,[$this->id]);
        $result = array();
        $net_worth=0;
        foreach($accounts as $account){
            $array_account=array(
                'Assets'=>$account->Assets,
                'Liabilities'=>$account->Liabilities,
                'Net Worth'=>0
            );
            $net_worth+=$account->Assets-$account->Liabilities;
            $result[$account->account_type_name]=$array_account;
        }
        $result['Net Worth']=array(
            'Assets'=>0,
            'Liabilities'=>0,
            'Net Worth'=>$net_worth
        );
        return $result;
    }

    function getTaxesInformation(){
        return array(
            '2014'=>['Marginal Tax Rate'=>'25%','Effective Tax Rate'=>'20%','Taxes Paid'=>'30000'],
            '2015'=>['Marginal Tax Rate'=>'26%','Effective Tax Rate'=>'22%','Taxes Paid'=>'35000'],
            '2016'=>['Marginal Tax Rate'=>'27%','Effective Tax Rate'=>'24%','Taxes Paid'=>'40000','Estimated'=>'true']
        );
    }

    function getTotalTaxes($year){
        $years = [2014=>['Income Tax'=>92000,'Property Tax'=>11900,'Dividend Tax'=>90,'Capital Gains Tax'=>50],
            2015=>['Income Tax'=>92000,'Property Tax'=>11900,'Dividend Tax'=>90,'Capital Gains Tax'=>50],
            2016=>['Income Tax'=>92000,'Property Tax'=>11900,'Dividend Tax'=>90,'Capital Gains Tax'=>50]];
        return $years[$year];
    }

    function getDetailedTaxes($year){
        if($year==2015){
            return array(['Tax Type'=>'Federal','Marginal Tax Rate'=>'28%','Effective Tax Rate'=>'18%','Tax Amount'=>'44123'],
                ['Tax Type'=>'Social Security','Marginal Tax Rate'=>'1.45%','Effective Tax Rate'=>'6.7%','Tax Amount'=>'16715'],
                ['Tax Type'=>'State','Marginal Tax Rate'=>'6.7%','Effective Tax Rate'=>'6.3%','Tax Amount'=>'15664'],
                ['Tax Type'=>'Local','Marginal Tax Rate'=>'0%','Effective Tax Rate'=>'0%','Tax Amount'=>'0']);
        }
        if($year==2016){
            return array(['Tax Type'=>'Federal','Marginal Tax Rate'=>'28%','Effective Tax Rate'=>'18%','Tax Amount'=>'44123'],
                ['Tax Type'=>'Social Security','Marginal Tax Rate'=>'0%','Effective Tax Rate'=>'0%','Tax Amount'=>'1'],
                ['Tax Type'=>'State','Marginal Tax Rate'=>'0%','Effective Tax Rate'=>'6.3%','Tax Amount'=>'16715'],
                ['Tax Type'=>'Local','Marginal Tax Rate'=>'0%','Effective Tax Rate'=>'0%','Tax Amount'=>'0']);
        }
    }

    function getTaxesComparison(){
        return array(
            'Adjusted Gross Income'=>[
                2011=>195000,
                2012=>195000,
                2013=>205000,
                2014=>225000,
                2015=>256000,
                2016=>270000
            ],
            'Household Effective Tax Rate'=>[
                2011=>'21',
                2012=>'23',
                2013=>'26',
                2014=>'26',
                2015=>'28',
                2016=>'29'
            ]
        );
    }
}
