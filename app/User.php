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

    function getNetWorth(){
        return array('Assets' => '817000', 'Liabilities' => '226600','Net Worth'=>'590400');
    }

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

    function getDetailedNetWorth(){
        return array(
            'Home'=>[
                'Total'=>'700000',
                'Liabilities'=>'480000',
                'Net Worth'=>'220000'
            ],
            'Retirement Savings'=>[
                'Total'=>'182000',
                'Liabilities'=>'0',
                'Net Worth'=>'142000'
            ],
            'Brokerage Investments'=>[
                'Total'=>'55000',
                'Liabilities'=>'0',
                'Net Worth'=>'55000'
            ],
            'Car'=>[
                'Total'=>'20000',
                'Liabilities'=>'15000',
                'Net Worth'=>'5000'
            ],
            'Cash'=>[
                'Total'=>'30000',
                'Liabilities'=>'0',
                'Net Worth'=>'10000'
            ],
            'Student Loan'=>[
                'Total'=>'0',
                'Liabilities'=>'40000',
                'Net Worth'=>'0'
            ]
        );
    }
}
