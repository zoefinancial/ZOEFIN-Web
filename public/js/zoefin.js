/*! Zoe Financial JS | (c) Zoe Financial |  */

var miles_separator=',';
var decimal_separator='.';
var currency_format_indicators = ['']
var percentage_format_indicators=['Household Effective Tax Rate'];

var tooltips=[];
tooltips['Marginal Tax Rate']="Percentage taken from your next dollar of taxable income, Why it matters? You need to know it to calculate what amount of your raise or bonus you’ll get to keep after taxes or whether it is worthwhile to contribute more to your tax-advantaged accounts";
tooltips['Effective Tax Rate']="Total Tax Paid / Taxable Income. Why it matters? Typically a more accurate reflection of what your overall tax bill than its marginal tax rate.";




var colors=['rgba(75, 192, 192, 0.5)',
    'rgba(255, 99, 132, 0.5)',
    'rgba(54, 162, 235, 0.5)',
    'rgba(255, 206, 86, 0.5)',
    'rgba(153, 102, 255, 0.5)',
    'rgba(255, 159, 64, 0.5)',
    'rgba(0, 0, 0, 0.5)',
    'rgba(128, 0, 0, 0.5)',
    'rgba(128, 0, 128, 0.5)',
    'rgba(128, 255, 0, 0.5)',
    'rgba(0, 255, 0, 0.5)',
    'rgba(0, 255, 255, 0.5)',
    'rgba(128, 255, 255, 0.5)',
    'rgba(255, 41, 0, 0.5)',
    'rgba(193, 54, 189, 0.5)',
    ];

Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));
    return (c ? num.replace(decimal_separator, c) : num).replace(new RegExp(re, 'g'), '$&' + (s || miles_separator));
};

function moneyFormat(s,d){
    if(d>=0){
        return parseFloat(s).format(d, 3);
    }else if (d==-3){
        return (parseFloat(s)/Math.pow(10,(-1*d))).format(0,3);
    }else{
        return (parseFloat(s)/Math.pow(10,(-1*d))).format(1,3);
    }
}

function tableMoneyFormat(s){
    return moneyFormat(s,0);
}


function humanReadableMoney(s){
    var n=parseFloat(s);
    if(Math.abs(n)<1000){
        return '$'+parseFloat(s).format(0, 3)+'';
    }else if(Math.abs(n) < 1000000){
        return '$'+moneyFormat(s,-3)+ ' K';
    }else{
        return '$'+moneyFormat(s,-6)+ ' M';
    }
    return null;
}
/**/

Object.defineProperty(Array.prototype, "contains", {
    enumerable: false,
    value: function(obj) {
        var i = this.length;
        while (i--) {
            if (this[i] === obj) {
                return true;
            }
        }
        return false;
    }
});

Object.defineProperty(Array.prototype, "containsKey", {
    enumerable: false,
    value: function(obj) {
        for(var key in this){
            if(key==obj){
                return true;
            }
        }
        return false;
    }
});

$.put = function(url, data, callback, type){

    if ( $.isFunction(data) ){
        type = type || callback,
            callback = data,
            data = {}
    }

    return $.ajax({
        url: url,
        type: 'PUT',
        success: callback,
        data: data,
        contentType: type
    });
}

$.delete = function(url, data, callback, type){

    if ( $.isFunction(data) ){
        type = type || callback,
            callback = data,
            data = {}
    }

    return $.ajax({
        url: url,
        type: 'DELETE',
        success: callback,
        data: data,
        contentType: type
    });
}

