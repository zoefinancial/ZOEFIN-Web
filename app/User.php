<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

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

    function getInsurancePrediction(){
        return array(
            'Total Family Would Need'=>['Total Family Would Need'=>'4601884','Family Resources'=>'0'],
            'Available Resources'=>['Total Family Would Need'=>'0','Family Resources'=>'257000'],
            'Insurance Need'=>['Total Family Would Need'=>'0','Family Resources'=>'4344884']
        );
    }

    /**
     * Function to retrieve the Net Worth detailed data
     */
    function getDetailedNetWorth(){
        return array(
            'Home'=>[
                'Assets'=>'700000',
                'Liabilities'=>'480000',
                'Net Worth'=>'220000'
            ],
            'Retirement Savings'=>[
                'Assets'=>'182000',
                'Liabilities'=>'0',
                'Net Worth'=>'142000'
            ],
            'Brokerage Investments'=>[
                'Assets'=>'55000',
                'Liabilities'=>'0',
                'Net Worth'=>'55000'
            ],
            'Car'=>[
                'Assets'=>'20000',
                'Liabilities'=>'15000',
                'Net Worth'=>'5000'
            ],
            'Cash'=>[
                'Assets'=>'30000',
                'Liabilities'=>'0',
                'Net Worth'=>'10000'
            ],
            'Student Loan'=>[
                'Assets'=>'0',
                'Liabilities'=>'40000',
                'Net Worth'=>'0'
            ],
            'Credit card'=>[
                'Assets'=>'0',
                'Liabilities'=>'20000',
                'Net Worth'=>'0'
            ]
        );
    }

    function getTaxesInformation(){
        return array(
            '2014'=>['Marginal Tax Rate'=>'25%','Effective Tax Rate'=>'20%','Tax Amount'=>'30000'],
            '2015'=>['Marginal Tax Rate'=>'26%','Effective Tax Rate'=>'22%','Tax Amount'=>'35000'],
            '2016'=>['Marginal Tax Rate'=>'27%','Effective Tax Rate'=>'24%','Tax Amount'=>'40000']
        );
    }
}
