jQuery(document).ready(function() {
  "use strict";


    //////////////////////////////////////

    var record,_data;
    if( $.urlParam('id') ){
      _data= {
        id:$.urlParam('id'),
      }
    }

    $.ajax({
      url: 'php/items/get.php',
      method: 'GET',
      data: _data,
      dataType: 'json',
      success: function(data) {
        record = data.data[0];
        console.log(data)

            //////////////////

            // $.each(record.images,function(key,val){
            //   $('#sync3,#sync4').append('<div class="item ">'+
            //     '<img src="images/activity/'+val.imageName+'" class="img-responsive" alt="Image">'+
            //     '</div>'
            //     );
            // })
            $('#itemName').html(record.itemName);
            $('#displayName').html(record.itemName);
            $('#itemSize').html(record.itemSize);
            $('#model').html(record.model);
            $('#color').html(record.color);
            $('#itemType').html(record.itemType);
            $('#price').html(record.price);
            $("#oldPrice").html(record.price.currencyDisplay());
            $("#price").html('$'+record.price.currencyDisplay());
            $("#offerPrice").html(record.offerPrice.currencyDisplay());
            $('#brandName').html(record.brandName);
            $('#categoryName').html(record.categoryName);
            $('#description').html(record.description);
            $('#image').attr('src',"axispanel/images/" + record.itemImage);

            if(record.offer){
              //Show promotion widget
              $("#offer").removeClass('hidden');
              $("#offerBox").removeClass('hidden');
            }else{
                $("#price").removeClass('hidden');
            }

          },
          error: function(error) {
            // toastr.error(err.responseText, 'Notification', {timeOut: 5000})
          }
          });


 });
