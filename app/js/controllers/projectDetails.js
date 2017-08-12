jQuery(document).ready(function() {
  "use strict";

  var urlPath   = "php/activities/";

    //////////////////////////////////////

    var record,_data;
    if( $.urlParam('id') ){
      _data= {
        prdetailsId:$.urlParam('id'),
      }
    }

    $.ajax({
      url: 'php/projectdetails/get.php',
      method: 'GET',
      data: _data,
      dataType: 'json',
      success: function(data) {
        record = data.data[0];

            //////////////////
            $.each(record.images,function(key,val){
              $('#sync3,#sync4').append('<div class="item ">'+
                '<img src="axispanel/projectImages/'+val.imageAfter+'" class="img-responsive" alt="Image">'+
                '</div>'
                );
            })
            $('#description').html(record.description);
            $('#prdetailsTitle').html(record.prdetailsTitle);
            $('#location').html(record.location);
            $('#projectDate').html(record.projectDate);
            $('#prdetailsType').html(record.prdetailsType);
            $('#prdetailsName').html(record.prdetailsName);
            initOwl() // OWL is modified to global variable in custom-owl.js to fit actDetails.js ajax call
          },
          error: function(error) {
            // toastr.error(err.responseText, 'Notification', {timeOut: 5000})
          }
          });


 });
