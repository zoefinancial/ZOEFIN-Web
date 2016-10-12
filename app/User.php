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

    public function investment()
    {
        return $this->hasMany(Investment::class, 'users_id', 'id');
    }
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
   /* function getInvestments(){
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
    }*/

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

    /**
     * @return array
     */
    public function getBankingAccount()
    {
        return BankingAccount::where('users_id',$this->id)
            ->get();
    }

    /**
     * getInvestments extract all investments from user to
     * display on net worth chart
     * @return mixed
     */
    public function getInvestments()
    {
        return Investment::where('users_id',$this->id)
            ->get();
    }

    function getLoans(){
        $loans = Loan::where('users_id',$this->id)
            ->get();
        return $loans;
    }

    function getLoansByType($type_id){
        $loans = Loan::where(['users_id'=>$this->id,'loan_types_id'=>$type_id])
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
                $result[]=['Name'=>$familyMember->name,'Coverage'=>$insurance->coverage,
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
        if($insuranceInformation){
            $family_resources = $insuranceInformation->available_resources;
            $family_need = $insuranceInformation->total_family_need;
            $total = $family_need - $family_resources;
        }

        return array(
            'Family Needs'=>['Family Needs' =>$family_need],
            'Available Resources'=>['Available Resources' =>  $family_resources,],
            'Insurance Needed'=>['Insurance Needed' => $total,]
        );
    }

    function getIncomes(){
        $incomes=Income::where('users_id',$this->id)
            ->whereNull('loan_id')
            ->orderBy('date')
            ->get();
        return $incomes;
    }

    function getExpenses(){
        $expenses=Expense::where('users_id',$this->id)
            ->orderBy('date')
            ->get();
        return $expenses;
    }

    function getExpensesBetweenDates($from,$to){
        $expenses=Expense::where([['users_id',$this->id],['date','>=',$from],['date','<=',$to]])
            ->orderBy('date')
            ->get();
        return $expenses;
    }

    /**
     * Function to retrieve the Net Worth detailed data
     */
    public function getDetailedNetWorth(){
        $result = array();
        $net_worth=0;
        $assets=0;
        $liabilities=0;
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
            $assets+=$account->current_value;
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
            $assets+=$account->current_value;
        }

        $bankingAccount = $this->getBankingAccount();
        foreach($bankingAccount as $account){
            if(isset($result['Cash'])){
                $result['Cash']['Assets']+=$account->current_balance;
                $result['Cash']['Net Worth']+=$account->current_balance;
            }else{
                $array_account=array(
                    'Assets'=>$account->current_balance,
                    'Liabilities'=>0,
                    'Net Worth'=>$account->current_balance
                );
                $result['Cash']=$array_account;
            }
            $assets+=$account->current_balance;
        }

        $investments = $this->getInvestments();
        foreach($investments as $account){
            if(isset($result['Investment'])){
                $result['Investment']['Assets'] += $account->total_balance;
                $result['Investment']['Net Worth'] += $account->total_balance;
            }else{
                $array_account = array(
                    'Assets' => $account->total_balance,
                    'Liabilities' => 0,
                    'Net Worth' => $account->total_balance
                );
                $result['Investment'] = $array_account;
            }
            $assets+=$account->total_balance;
        }

        $loans=$this->getLoans();
        foreach($loans as $loan){
            if($loan->getLoanType->description=='Mortgage'){
                if(isset($result['Home'])){
                    $result['Home']['Liabilities']=$result['Home']['Liabilities']-$loan->amount;
                    $result['Home']['Net Worth']=$result['Home']['Net Worth']+$loan->amount;
                }else{
                    $array_account=array(
                        'Assets'=>0,
                        'Liabilities'=>$loan->amount*-1,
                        'Net Worth'=>$loan->amount
                    );
                    $result['Home']=$array_account;
                }
            }else{
                if($loan->getLoanType->description=='Car Loan'){
                    if(isset($result['Car'])){
                        $result['Car']['Liabilities']=$result['Car']['Liabilities']-$loan->amount;
                        $result['Car']['Net Worth']=$result['Car']['Net Worth']+$loan->amount;
                    }else{
                        $array_account=array(
                            'Assets'=>0,
                            'Liabilities'=>$loan->amount*-1,
                            'Net Worth'=>0-$loan->amount
                        );
                        $result['Car']=$array_account;
                    }
                }else{
                    $array_account=array(
                        'Assets'=>0,
                        'Liabilities'=>$loan->amount*-1,
                        'Net Worth'=>0
                    );
                    $net_worth+=$loan->amount;
                    $result[$loan->getLoanType->description]=$array_account;
                }
            }
            $liabilities-=$loan->amount;
        }
        $result['Net Worth']=array(
            'Assets'=>0,
            'Liabilities'=>0,
            'Net Worth'=>$net_worth
        );
        foreach ($result as $item) {
            $net_worth+=$item['Net Worth'];
        }
        $result['Total']=array(
                'Assets'=>$assets,
                'Liabilities'=>$liabilities,
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
