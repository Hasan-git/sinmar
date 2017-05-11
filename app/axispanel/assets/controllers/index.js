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

                //Get all projects
                $.ajax({
                    url: '../php/projects/get.php',
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
                                {'data':'projectId'},
                                {'data':'projectName'},
                                {   'data':null,
                                    'render': function ( data, type, full, meta ) {
                                        //set data-row attr as the datatable row -> give access the save changes to update row data localy
                                        return "<button class='btn btn-xs btn-success' id='editProject' data-row='"+meta.row+"' data-project='"+JSON.stringify(full)+"'  > <i class='fa fa-edit'></i> </button> "+
                                          "<a class='btn btn-xs btn-danger' id='deleteProject' data-row='"+meta.row+"' project-id='"+full.projectId+"' href='#'> <i class='fa fa-trash'></i> </a> "
                                    },
                                    
                                }
                            ]
                        })     
                    // Add Placeholder text to datatables filter bar
                    $('.dataTables_filter input').attr("placeholder", "Enter Terms...");                  
                    }
                })

                    $('#canelEditPro').click(function(){
                        $('#editmode').hide(700);
                    });

                    //Edit project btn Clicked
                   $('#datatable3 tbody').on( 'click', '#editProject', function (event) {

                        event.preventDefault();
                        event.stopPropagation();

                        $('#editmode').show(700);
                        
                        //var product = JSON.parse($(this).attr('project-id')) 
                        var project = $(this).data().project;
                        var datatableRow = $(this).attr('data-row');
                        
                        //set datatable row in data-row attr to for saveEditPro(Save button) to have the access for datatable row
                        $('#editmode').find('#saveEditPro').attr("data-row",datatableRow)

                        // $('#editmode').find('#proNameBox').html(datatableRow)
                        $('#editmode').find('#proNameBox').html(project.projectName)
                        $('#editmode').find('#projectName').val(project.projectName)
                        $('#editmode').find('#projectId').val(project.projectId)
                   
                    });

                    // Edit project form submited
                    $('#saveEditPro').click(function(){
                       
                        $.ajax({
                            url: '../php/projects/update.php',
                            method:'POST',
                            data: $('#editProForm').serialize(),
                            success:function(data){ 
                            // Serialize the form to Json 
                            var localProject = $('#editProForm').serializeFormJSON()

                            //Get the datatable row from the button attr and emit changes
                            var datatableRow_ = $('#saveEditPro').attr("data-row");
                            //get the dt instance
                            var myDataTable= $('#datatable3').DataTable();
                            // get / set dt row
                            var row = myDataTable.row(datatableRow_);
                            //Change row.projectName
                            //
                            myDataTable.row(row).data(localProject).draw();
                            $('#editmode').hide(700);
                            toastr.success('Project updated successfully', 'Notification', {timeOut: 5000})
                            } ,
                            error: function(err) {
                                toastr.error(error, 'Notification', {timeOut: 5000})
                            }
                        });
                    });


            // New project btn clicked -> show the form
            $('#newProOpen').click(function(){
                $('#newProForm').show(800);

            });

            // New Project canceled
            $('#canelNewPro').click(function(){
                $('#newProForm').hide(700);
            });


            $('#saveNewPro').click(function(){
                $.ajax({
                    url: '../php/projects/post.php',
                    method:'POST',
                    data: $('#newform').serialize(),
                    success:function(data){ 

                        var _newProduct = JSON.parse(data)

                        var myDataTable= $('#datatable3').DataTable();
                        
                        myDataTable.row.add(_newProduct  ).draw( false )
                        
                        $('#newProForm').hide(700);
                        toastr.success('Project updated successfully', 'Notification', {timeOut: 5000})
                    } ,
                    error: function(err) {
                        if(err){
                            toastr.error(err, 'Notification', {timeOut: 5000})
                        }else{
                            toastr.error('An error occurred', 'Notification', {timeOut: 5000})
                        }
                    }
                });    
            });

        $('#datatable3 tbody').on( 'click', '#deleteProject', function (event) {
            var thisProject = $(this);
            var projectId = $(this).attr('project-id');
            var inst = $('[data-remodal-id=modal]').remodal();
                    
            inst.open();

            $(document).on('confirmation', '.remodal', function () {
                
                $.ajax({
                        url: '../php/projects/delete.php',
                        method:'POST',
                        data: {projectId:projectId},
                        success:function(data){ 

                        //get the dt instance
                        var myDataTable= $('#datatable3').DataTable();

                        // get / set dt row
                        var row = myDataTable.row($(thisProject).parents('tr')).remove().draw();;
                        //myDataTable.row(row).data(localProject).draw();
                        // $('#editmode').hide(700);
                        toastr.success('Project deleted successfully', 'Notification', {timeOut: 5000})
                        } ,
                        error: function(err) {
                            toastr.error(error, 'Notification', {timeOut: 5000})
                        }
                    });
            });

            $(document).on('cancellation', '.remodal', function () {
                inst.close();
            });

        });




        });//end

