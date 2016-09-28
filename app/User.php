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
        'email', 'password'
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
        $individuals = Individual::where('users_id',$this->id)
            ->get();
        return $individuals;
    }

    function getFamilyMember($m_id){
        $individual = Individual::where('id',$m_id)
            ->first();
        return $individual;
    }

    function getHomes(){
        $homes = Home::where('users_id',$this->id)
            ->get();
        return $homes;
    }

    function getCars(){
        $cars = Car::where('users_id',$this->id)
            ->get();
        return $cars;
    }

    function getLoans(){
        $loans = Loan::where('users_id',$this->id)
            ->get();
        return $loans;
    }

    /**
     * Function to retrieve the Insurance Summary data
     */
    function getInsuranceSummary(){
        $result = array();
        foreach ($this->getFamilyMembers() as $familyMember) {
            foreach (Insurance::where('individuals_id',$familyMember->id)->get() as $insurance){
                $result[$familyMember->name]=['Coverage'=>$insurance->coverage,
                        'Type'=>$insurance->insurance_type,
                        'Years coverage'=>$insurance->years,
                        'Annual Payment'=>$insurance->anual_payment];
            }
        }
        return $result;
    }

    function getInsurancePrediction($m_id)
    {
        $insuranceInformation=InsuranceInformation::where('individuals_id',$m_id)->first();
        $family_resources=0;
        $family_need=0;
        $total=0;
        try{
            $family_resources = $insuranceInformation->available_resources;
            $family_need = $insuranceInformation->total_family_need;
            $total = $family_need - $family_resources;
        }catch(Exception $e){

        }

        return array(
            'Total Family Would Need' => ['Total Family Would Need' => $family_need, 'Family Resources' => 0],
            'Available Resources' => ['Total Family Would Need' => 0, 'Family Resources' => $family_resources],
            'Insurance Need' => ['Total Family Would Need' => 0, 'Family Resources' => $total]
        );
    }

    /**
     * Function to retrieve the Net Worth detailed data
     */
    function getDetailedNetWorth(){

        $result = array();
        $net_worth=0;
        $homes=$this->getHomes();
        foreach($homes as $account){
            if(isset($result['Home'])){
                $result['Home']['Assets']+=$account->current_value;
                $result['Home']['Net Worth']+=$account->current_value;
            }else{
                $array_account=array(
                    'Assets'=>$account->current_value,
                    'Liabilities'=>0,
                    'Net Worth'=>$account->current_value
                );
                $result['Home']=$array_account;
            }
        }
        $cars=$this->getCars();
        foreach($cars as $account){
            if(isset($result['Car'])){
                $result['Car']['Assets']+=$account->current_value;
                $result['Car']['Net Worth']+=$account->current_value;
            }else{
                $array_account=array(
                    'Assets'=>$account->current_value,
                    'Liabilities'=>0,
                    'Net Worth'=>$account->current_value
                );
                $result['Car']=$array_account;
            }
        }
        $loans=$this->getLoans();
        foreach($loans as $loan){
            if($loan->getLoanType->description=='Mortgage'){
                $result['Home']['Liabilities']=$loan->amount;
                $result['Home']['Net Worth']=$result['Home']['Net Worth']-$loan->amount;
            }else{
                if($loan->getLoanType->description=='Car Loan'){
                    $result['Car']['Liabilities']=$loan->amount;
                    $result['Car']['Net Worth']=$result['Car']['Net Worth']-$loan->amount;
                }else{
                    $array_account=array(
                        'Assets'=>0,
                        'Liabilities'=>$loan->amount,
                        'Net Worth'=>0
                    );
                    $net_worth-=$loan->amount;
                    $result[$loan->getLoanType->description]=$array_account;
                }
            }
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
