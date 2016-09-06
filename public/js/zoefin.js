/*! Zoe Financial JS | (c) Zoe Financial |  */

var miles_separator=',';
var decimal_separator='.';

Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));
    return (c ? num.replace(decimal_separator, c) : num).replace(new RegExp(re, 'g'), '$&' + (s || miles_separator));
};

function moneyFormat(s,d){
    if(d>=0){
        return Number(s).format(d, 3);
    }else if (d==-3){
        return (Number(s)/Math.pow(10,(-1*d))).format(0,3);
    }else{
        return (Number(s)/Math.pow(10,(-1*d))).format(1,3);
    }
}

function tableMoneyFormat(s){
    return moneyFormat(s,0);
}


function humanReadableMoney(s){
    var n=Number(s);
    if(n<1000){
        return '$'+Number(s).format(0, 3)+'';
    }else if(n < 1000000){
        return '$'+moneyFormat(s,-3)+ ' K';
    }else{
        return '$'+moneyFormat(s,-6)+ ' M';
    }
    return null;
}
/**/
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}