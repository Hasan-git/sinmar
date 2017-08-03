$.urlParam = function(name){
  var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
  results = results != null ? results[1] : false ;
  return results;
}

Number.prototype.currencyDisplay = function() {
  var num = this.valueOf().toString()
    var value = Number(num);
    var res = num.split(".");
    if(num.indexOf('.') === -1) {
        value = value.toFixed(2);
        num = value.toString();
    } else if (res[1].length < 3) {
        value = value.toFixed(2);
        num = value.toString();
    }
    return num
};
