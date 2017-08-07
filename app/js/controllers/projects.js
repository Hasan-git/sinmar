jQuery(document).ready(function() {
    "use strict";



    $(".projectContainer").isotope({
        layoutMode: 'fitRows',
        filter: '*',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false

        }
    });

    $(".projectContainer").isotope('layout');

    var urlPath = "php/activities/";

    //////////////////////////////////////

    var fullRecords;
    var records, _data,types;


    if ($.urlParam('projecttype')) {
        _data = {
            projecttype: $.urlParam('projecttype'),
        }
    }

    var current_page = 1;
    var records_per_page = 3; // activities per page

    //load projects types before projects details to avoid isotope conflicts
    $.ajax({
        url: 'php/projecttype/get.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {

            types = data.data;

            //////////////////

             $.each(types, function(key, val) {
                    var $type = $('<a href="#" data-filter=".'+val.projectTypeName+'" class="text-cap">'+
                                    '<h4>'+val.projectTypeName+'</h4>'+
                                 '</a>');

                     var newType = $($type).appendTo('.projectFilter');
            });
                    actions.loadProjects();

        },
        error: function(error) {
            // toastr.error(err.responseText, 'Notification', {timeOut: 5000})
        }
    });


    var actions = {
        loadProjects : function(){
            $.ajax({
                url: 'php/projectdetails/getAll.php',
                method: 'GET',
                dataType: 'json',
                // data: _data,
                success: function(data) {

                    fullRecords = data.data;
                    records = fullRecords;
                    // console.log(fullRecords)

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


            $('.records_article').children().remove()
            for (var i = (page - 1) * records_per_page; i < (page * records_per_page); i++) {
                if (records[i]) {
                    var value = records[i];

                    var $a = $('<div class="element-item ' + value.prdetailsType + '">'+
                                '<img src="axispanel/projectImages/' + value.projectImage + '" class="img-responsive" alt="Image">'+
                                '<div class="project-info">'+
                                   '<a href="prdetail.php?id=' + value.Id + '">'+
                                      '<h4 class="title-project text-cap">' + value.prdetailsTitle + '</h4>'+
                                   '</a>'+

                                   '<a href="prdetail.php?id=' + value.prdetailsId + '"  class="cateProject"> ' + value.prdetailsName + ' / ' + value.prdetailsType + '</a>'+
                                '</div>'+
                             '</div>');

                    var di = $a;
                    var newItems = $(di).appendTo('.projectContainer');
                    $(".projectContainer").isotope('appended', newItems).isotope('layout');
                }
            }
            $(".projectContainer").isotope('layout');

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

            setInterval(function() {
                if ($('.projectContainer').height() < 400) {
                    $('.records_article_paginaton').css('margin-top', 280 + 'px')
                } else {
                    $('.records_article_paginaton').css('margin-top', 0 + 'px')
                }

            }, 1000);
        },

        categoryBtnClicked: function() {
            $('.projectFilter a').click(function() {
                var this_ = $(this);

                var filter = this_.attr('data-filter')
                var filterBy, filteredRecords = [];


                $.map(fullRecords, function(val, key) {
                    if ( ("."+val.prdetailsType).toString() === filter ) {
                        filteredRecords.push(val)
                    } else if (filter === '*') {
                        filteredRecords.push(val)
                    }
                });
                records = filteredRecords;
                actions.changePage(1);
                current_page = 1;

                var target = $('.records_article');
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 140
                    }, 1000);
                }
            });
        }
    }


    function numPages() {
        return Math.ceil(records.length / records_per_page);
    }

});
