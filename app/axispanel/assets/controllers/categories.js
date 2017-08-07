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

            //TODO://
            var urlPath = 'http://sinmar-lb.com/php/categories/';
            //var urlPath = '../php/categories/';

            ////////////////////////////////////////////////////

            ////////////////////////////////////////////////////

            //Get all categories
            $.ajax({
                url:  urlPath + 'get.php',
                method:'GET',
                cache : false,
                dataType:'json',
                success:function(data){
                    //Datatable Initializer
                    var tbl = $('#datatable3').dataTable({
                        "sDom": '<"dt-panelmenu text-center clearfix"T><"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
                        // "sDom": '<"dt-panelmenu clearfix"Tfr>t<"dt-panelfooter clearfix"ip>',
                        "oTableTools": {
                            "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                        },
                        lengthMenu: [
                            [ 10, 25, 50, -1 ],
                            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                        ],
                        buttons: [
                            'pageLength'
                        ],
                        data:data.data,
                        columns:[
                            //TODO://
                            {'data':'categoryId',
                             'render': function ( data, type, full, meta ) {
                                    return meta.row+1
                                }
                            },
                            {'data':'categoryName'},
                            {   'data':null,
                                'render': function ( data, type, full, meta ) {
                                    //set data-row attr as the datatable row -> give access the save changes to update row data localy
                                    return "<button class='btn btn-xs btn-success' scrollto='#editFormContainer' id='editRecord' data-row='"+meta.row+"' data-record='"+JSON.stringify(full)+"'  > <i class='fa fa-edit'></i> </button> "+
                                      "<a class='btn btn-xs btn-danger' id='deleteRecord' data-row='"+meta.row+"' record-id='"+full.categoryId+"' href='#'> <i class='fa fa-trash'></i> </a> "
                                },

                            }
                        ],
                        "fnDrawCallback": function ( oSettings ) {
                            /* Need to redo the counters if filtered or sorted */
                            if ( oSettings.bSorted || oSettings.bFiltered )
                            {
                                for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
                                {
                                    $('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
                                }
                            }
                        },
                        "aoColumnDefs": [
                            { "bSortable": false, "aTargets": [ 0 ] }
                        ],
                        // "aaSorting": [[ 1, 'asc' ]]
                    })

                // Add Placeholder text to datatables filter bar
                $('.dataTables_filter input').attr("placeholder", "Enter Terms...");
                }
            })

            $('#cancelEditForm').click(function(){
                $('#editFormContainer').hide(700);
            });

            //Edit category btn Clicked
           $('#datatable3 tbody').on( 'click', '#editRecord', function (event) {

                event.preventDefault();
                event.stopPropagation();
                $('#editForm').find("input[type=text],input[type=file],select, textarea").val("")
                $('#editFormContainer').show(700);

                //var product = JSON.parse($(this).attr('record-id'))
                var mainRecord = $(this).attr('data-record');
                mainRecord = JSON.parse(mainRecord);
                var datatableRow = $(this).attr('data-row');

                //set datatable row in data-row attr to for saveEditForm(Save button) to have the access for datatable row
                $('#editFormContainer').find('#saveEditForm').attr("data-row",datatableRow)

                //TODO://
                $('#editFormContainer').find('#nfBoxName').html(mainRecord.categoryName)
                $('#editFormContainer').find('#categoryName').val(mainRecord.categoryName)
                $('#editFormContainer').find('#categoryId').val(mainRecord.categoryId)

            });

            // Edit category form submited
            $('#saveEditForm').click(function(){
               if( !$('#editForm').isValid(conf.language, conf, true) ) {
                    // displayErrors( errors );
                   } else {
                        $.ajax({
                            url:  urlPath + 'update.php',
                            method:'POST',
                            cache : false,
                            data: $('#editForm').serialize(),
                            success:function(data){
                            // Serialize the form to Json
                            var localRecord = $('#editForm').serializeFormJSON()

                            //Get the datatable row from the button attr and emit changes
                            var datatableRow_ = $('#saveEditForm').attr("data-row");
                            //get the dt instance
                            var myDataTable= $('#datatable3').DataTable();
                            // get / set dt row
                            var row = myDataTable.row(datatableRow_);
                            //Change row.projectName
                            //
                            myDataTable.row(row).data(localRecord).draw();
                            $('#editFormContainer').hide(700);
                            toastr.success('category updated successfully', 'Notification', {timeOut: 5000})
                            } ,
                            error: function(err) {
                               if(err.responseText){
                                    toastr.error(err.responseText, 'Notification', {timeOut: 5000})
                               }else{
                                    toastr.error("Something went wrong", 'Notification', {timeOut: 5000})
                               }
                            }
                    });

                   }

            });


            // New category btn clicked -> show the form
            $('#openNewRecordForm').click(function(){
                $('#newform').find("input[type=text],input[type=file],select, textarea").val("")
                $('#newFormContainer').show(800);

            });

            // New category canceled
            $('#cancelNewForm').click(function(){
                $('#newFormContainer').hide(700);
            });




            //CREATE NEW category IN PROCESS
            $('#saveNewForm').click(function(){

                   if( !$('#newform').isValid(conf.language, conf, true) ) {
                    // displayErrors( errors );
                   } else {
                   // The form is valid
                    $.ajax({
                        url:  urlPath + 'post.php',
                        method:'POST',
                        cache : false,
                        data: $('#newform').serialize(),
                        success:function(data){

                            var _newRecord = JSON.parse(data)

                            var myDataTable= $('#datatable3').DataTable();

                            myDataTable.row.add(_newRecord ).draw( false )

                            $('#newFormContainer').hide(700);
                            toastr.success('category updated successfully', 'Notification', {timeOut: 5000})
                        } ,
                        error: function(err) {
                           if(err.responseText){
                                    toastr.error(err.responseText, 'Notification', {timeOut: 5000})
                               }else{
                                    toastr.error("Something went wrong", 'Notification', {timeOut: 5000})
                               }
                        }
                    });


                   }



            });


        //DELETE category CLICKED
        $('#datatable3 tbody').on( 'click', '#deleteRecord', function (event) {
            var thisDeleteBtn = $(this);
            var RecordId = $(this).attr('record-id');
            var inst = $('[data-remodal-id=modal]').remodal();

            inst.open();

            $(document).on('confirmation', '.remodal', function () {

                $.ajax({
                        url:  urlPath + 'delete.php',
                        method:'POST',
                        cache : false,
                        //TODO:??
                        data: {categoryId:RecordId},
                        success:function(data){

                        //get the dt instance
                        var myDataTable= $('#datatable3').DataTable();

                        // get / set dt row
                        var row = myDataTable.row($(thisDeleteBtn).parents('tr')).remove().draw();;

                        inst.close();
                        toastr.success('category deleted successfully', 'Notification', {timeOut: 5000})
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

            $(document).on('cancellation', '.remodal', function () {
                inst.close();
            });

        });

        });//end

