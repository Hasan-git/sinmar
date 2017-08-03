jQuery(document).ready(function() {
    "use strict";





    var fullRecords;
    var fullRecords2;
    var records, _data,types;

    //////////////////////////////////////


    if ($.urlParam('type')) {
        _data = {
            itemType: $.urlParam('type'),
        }
    }

    var current_page = 1;
    var records_per_page = 6; // activities per page
    var mainItemBox = $(".products").children().clone();
    $(".products").children().remove();



    var actions = {
        loadItems : function(){
            $.ajax({
                url: 'php/items/get.php',
                method: 'GET',
                dataType: 'json',
                data: _data,
                cache : false,
                success: function(data) {

                    fullRecords = data.data;
                    records = fullRecords;
                    fullRecords2 = data;

                    console.log(fullRecords)

                    //////////////////

                    actions.categoryBtnClicked();
                    actions.nextClicked();
                    actions.preClicked();
                    actions.firstClicked();
                    actions.lastClicked();
                    actions.changePage(1)

                },
                error: function(error) {
                    // toastr.error(err.responseText, 'Notification', {timeOut: 5000})
                }
            });
        },
        //Pagination next btn
        nextClicked: function() {
            $('.page-numbers.next').click(function() {
                if (current_page < numPages()) {
                    current_page++;
                    actions.changePage(current_page);
                }
            })
        },
        //Pagination pre btn
        preClicked: function() {
            $('.page-numbers.pre').click(function() {

                if (current_page > 1) {
                    current_page--;
                    actions.changePage(current_page);
                }
            })
        },
        firstClicked: function() {
            $('.page-numbers.first').click(function() {

                current_page = 1;
                actions.changePage(current_page);

            })
        },
        lastClicked: function() {
            $('.page-numbers.last').click(function() {

                current_page = numPages();
                actions.changePage(current_page);
            })
        },
        changePage: function(page) {
            var btn_next = $('.next');
            var btn_prev = $('.pre');
            var btn_first = $('.first');
            var btn_last = $('.last');
            var page_span = $('.page');

            // Validate page
            if (page < 1) page = 1;
            if (page > numPages()) page = numPages();


            $('.products').children().remove()
            for (var i = (page - 1) * records_per_page; i < (page * records_per_page); i++) {
                if (records[i]) {
                    var value = records[i];

                    var newItemBox = mainItemBox.clone()

                    newItemBox.find("#itemName").html(value.itemName);
                    newItemBox.find("#categoryName").html(value.categoryName);
                    newItemBox.find("#brandName").html(value.brandName);
                    newItemBox.find("#oldPrice").html(value.price);
                    newItemBox.find("#price").html('$'+value.price);
                    newItemBox.find("#offerPrice").html(value.offerPrice);
                    newItemBox.find("#image").attr('src',"axispanel/images/" + value.itemImage);
                    newItemBox.find("#itemLink").attr('href', 'shopsingle.php?id=' + value.itemId);

                    if(value.offer){
                        //Show promotion widget
                        newItemBox.find("#offer").removeClass('hidden');
                        newItemBox.find("#offerBox").removeClass('hidden');
                    }else{
                        newItemBox.find("#price").removeClass('hidden');
                    }

                    if(value.new)
                        //Show promotion widget
                        newItemBox.find("#new").removeClass('hidden');


                    newItemBox.prependTo('.products')
                }
            }

            var target = $('.records_article');
            if (target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 140
                }, 1000);
            }

            page_span.html(page);

            if (page == 1) {
                btn_prev.css('visibility', 'hidden');
                btn_first.css('visibility', 'hidden');
            } else {
                btn_prev.css('visibility', 'visible');
                btn_first.css('visibility', 'visible');
            }

            if (page == numPages()) {
                btn_next.css('visibility', 'hidden');
                btn_last.css('visibility', 'hidden');
            } else {
                btn_next.css('visibility', 'visible');
                btn_last.css('visibility', 'visible');
            }
        },

        categoryBtnClicked: function() {

            $('input').keyup(function() {

                var this_ = $(this);

                var filter = this_.attr('value')
                 filter = this_.val()
                var filterBy, filteredRecords = [];

                var as = '//data[ contains(itemName , "'+filter+'" ) or contains(categoryName , "'+filter+'" ) or contains(brandName , "'+filter+'" )]/.'
                //fullrecords2 handle result with data[]
                filteredRecords = JSON.search( fullRecords2, as );

                records = filteredRecords;

                actions.changePage(1);
                current_page = 1;

                // var target = $('.records_article');
                // if (target.length) {
                //     event.preventDefault();
                //     $('html, body').stop().animate({
                //         scrollTop: target.offset().top - 140
                //     }, 1000);
                // }
            });
        }
    }


    function numPages() {
        return Math.ceil(records.length / records_per_page);
    }
    actions.loadItems();
    actions.categoryBtnClicked();

});
