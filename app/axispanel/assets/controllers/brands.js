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

            var urlPath = '../php/brands/';

            ////////////////////////////////////////////////////
            
            ////////////////////////////////////////////////////

            //Get all brands
            $.ajax({
                url: urlPath + 'get.php',
                method:'GET',
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
                            {'data':'brandId'},
                            {'data':'brandName'},
                            {   'data':null,
                                'render': function ( data, type, full, meta ) {
                                    //set data-row attr as the datatable row -> give access the save changes to update row data localy
                                    return "<button class='btn btn-xs btn-success' scrollto='#editFormContainer' id='editRecord' data-row='"+meta.row+"' data-record='"+JSON.stringify(full)+"'  > <i class='fa fa-edit'></i> </button> "+
                                      "<a class='btn btn-xs btn-danger' id='deleteRecord' data-row='"+meta.row+"' record-id='"+full.brandId+"' href='#'> <i class='fa fa-trash'></i> </a> "
                                },
                                
                            }
                        ]
                    })     
                // Add Placeholder text to datatables filter bar
                $('.dataTables_filter input').attr("placeholder", "Enter Terms...");                  
                }
            })

            $('#cancelEditForm').click(function(){
                $('#editFormContainer').hide(700);
            });

            //Edit brand btn Clicked
           $('#datatable3 tbody').on( 'click', '#editRecord', function (event) {

                event.preventDefault();
                event.stopPropagation();

                $('#editFormContainer').show(700);
                
                //var product = JSON.parse($(this).attr('record-id')) 
                var mainRecord = $(this).attr('data-record');
                mainRecord = JSON.parse(mainRecord);
                console.log(mainRecord)
                var datatableRow = $(this).attr('data-row');
                
                //set datatable row in data-row attr to for saveEditForm(Save button) to have the access for datatable row
                $('#editFormContainer').find('#saveEditForm').attr("data-row",datatableRow)

                // $('#editFormContainer').find('#nfBoxName').html(datatableRow)
                $('#editFormContainer').find('#nfBoxName').html(mainRecord.brandName)
                $('#editFormContainer').find('#brandName').val(mainRecord.brandName)
                $('#editFormContainer').find('#brandId').val(mainRecord.brandId)
           
            });

            // Edit brand form submited
            $('#saveEditForm').click(function(){
               if( !$('#editForm').isValid(conf.language, conf, true) ) {
                    // displayErrors( errors );
                   } else {
                        $.ajax({
                            url: urlPath + 'update.php',
                            method:'POST',
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
                            toastr.success('Brand updated successfully', 'Notification', {timeOut: 5000})
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


            // New brand btn clicked -> show the form
            $('#openNewRecordForm').click(function(){
                $('#newFormContainer').show(800);

            });

            // New brand canceled
            $('#cancelNewForm').click(function(){
                $('#newFormContainer').hide(700);
            });

                


            //CREATE NEW brand IN PROCESS
            $('#saveNewForm').click(function(){
                
                   if( !$('#newform').isValid(conf.language, conf, true) ) {
                    // displayErrors( errors );
                   } else {
                   // The form is valid
                    $.ajax({
                        url: urlPath + 'post.php',
                        method:'POST',
                        data: $('#newform').serialize(),
                        success:function(data){ 

                            var _newRecord = JSON.parse(data)

                            var myDataTable= $('#datatable3').DataTable();
                            
                            myDataTable.row.add(_newRecord ).draw( false )
                            
                            $('#newFormContainer').hide(700);
                            toastr.success('Brand updated successfully', 'Notification', {timeOut: 5000})
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


        //DELETE brand CLICKED
        $('#datatable3 tbody').on( 'click', '#deleteRecord', function (event) {
            var thisDeleteBtn = $(this);
            var RecordId = $(this).attr('record-id');
            var inst = $('[data-remodal-id=modal]').remodal();
                    
            inst.open();

            $(document).on('confirmation', '.remodal', function () {
                
                $.ajax({
                        url: urlPath + 'delete.php',
                        method:'POST',
                        data: {brandId:RecordId},
                        success:function(data){ 

                        //get the dt instance
                        var myDataTable= $('#datatable3').DataTable();

                        // get / set dt row
                        var row = myDataTable.row($(thisDeleteBtn).parents('tr')).remove().draw();;
                        
                        inst.close();
                        toastr.success('Brand deleted successfully', 'Notification', {timeOut: 5000})
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

