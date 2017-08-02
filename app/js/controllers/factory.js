$.urlParam = function(name){
  var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
  results = results != null ? results[1] : false ;
  return results;
}
