/*! Zoe Financial JS | (c) Zoe Financial |  */

Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));
    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

function moneyFormat(s,d){
    if(d>=0){
        return Number(s).format(d, 3, '.', ',');
    }else{
        return Number(s)/Math.pow(10,(-1*d));
    }
}

function humanReadableMoney(s){
    var n=Number(s);
    if(n<1000){
        return '$'+Number(s).format(0, 3, '.', ',')+'';
    }else if(n < 1000000){
        return '$'+moneyFormat(s,-3)+ ' K';
    }else{
        return '$'+moneyFormat(s,-6)+ ' M';
    }
    return null;
}