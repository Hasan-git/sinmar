jQuery(document).ready(function() {
    "use strict";

    // var urlPath = "php";

    //////////////////////////////////////

    var actions = {
        initProjects: function() {
            $.ajax({
                url: 'php/projectdetails/getAll.php?limit=8',
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                    var records = data.data;

                    //////////////////

                    var projectHtml = $(".project_article").first().clone();

                    $('.current_projects').find('.project_article').remove()


                    $.each(records, function(key, val) {

                        var projectArticle = projectHtml.clone();

                        projectArticle.find('#prdetailsTitle').html(val.prdetailsTitle);
                        projectArticle.find('#prdetailsName').html(val.prdetailsName);
                        projectArticle.find('#prdetailsType').html(val.prdetailsType);
                        projectArticle.find("#image").attr('src', "axispanel/projectImages/" + val.projectImage);
                        projectArticle.find("#projectLink").attr('href', 'prdetail.php?id=' + val.prdetailsId);

                        // if (key % 2 != 0)
                        //     projectArticle.children().removeClass('block-img-left').addClass('block-img-right').addClass('mgb0')

                        projectArticle.appendTo(".current_projects")

                    })
                },
                error: function(error) {
                    // toastr.error(err.responseText, 'Notification', {timeOut: 5000})
                }
            });
        }
    }

    $.ajax({
                url: 'php/home/get.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                    var records = data.data;

                    $('#xpYearsCtr').html(records.xpYears);
                    $('#projectsCtr').html(records.projects);
                    $('#ClientsCtr').html(records.clients);
                    $('#empolyeesCtr').html(records.employees);
                },
                error: function(error) {
                    // toastr.error(err.responseText, 'Notification', {timeOut: 5000})
                }
            });


    actions.initProjects()

});
