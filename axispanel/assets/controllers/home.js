jQuery(document).ready(function() {
    "use strict";

            // Init Theme Core
            Core.init();

            // Init Demo JS
            Demo.init();

            //Toastr Configuration
            toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "5000",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
            //VALIDATION CONFIGURATION
            var conf = $.formUtils.defaultConfig();
            conf.language = 'en';
            conf.modules =  'security, date';
            conf.scrollToTopOnError = false;

            // Call the setup function
            $.validate({
                language:   conf.language,
                modules:    conf.modules
            });

        //////////////////////////////////////

            $.ajax({
                url: '../php/home/get.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                    var records = data.data;

                    //////////////////
                    console.log(records)

                    $('#editFormContainer').find('#xpYears').val(records.xpYears);
                    $('#editFormContainer').find('#projects').val(records.projects);
                    $('#editFormContainer').find('#clients').val(records.clients);
                    $('#editFormContainer').find('#employees').val(records.employees);
                    $('#editFormContainer').find('#id').val(records.id);
                },
                error: function(error) {
                    // toastr.error(err.responseText, 'Notification', {timeOut: 5000})
                }
            });


            $('#save').click(function(){
                $.ajax({
                            url:  '../php/home/update.php',
                            method:'POST',
                            data: $('#editForm').serialize(),
                            success:function(data){
                            toastr.success('Updated successfully', 'Notification', {timeOut: 2000})
                            } ,
                            error: function(err) {
                               if(err.responseText){
                                    toastr.error(err.responseText, 'Notification', {timeOut: 5000})
                               }else{
                                    toastr.error("Something went wrong", 'Notification', {timeOut: 5000})
                               }
                            }
                    });
            });

});
