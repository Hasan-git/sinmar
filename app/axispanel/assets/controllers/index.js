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
                  "preventDuplicates": false,
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
                            "sDom": '<"dt-panelmenu clearfix"Tfr>t<"dt-panelfooter clearfix"ip>',
                            "oTableTools": {
                                "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                            },
                            data:data.data,
                            columns:[
                                {'data':'projectId'},
                                {'data':'projectName'},
                                {   'data':null,
                                    'render': function ( data, type, full, meta ) {
                                        //set data-row attr as the datatable row -> give access the save changes to update row data localy
                                        return "<button class='btn btn-xs btn-success' id='editProject' data-row='"+meta.row+"' data-project='"+JSON.stringify(full)+"'  > <i class='fa fa-edit'></i> </button> "+
                                          "<button class='btn btn-xs btn-danger' id='deleteProject' data-row='"+meta.row+"' project-id='"+full.projectId+"' > <i class='fa fa-trash'></i> </button> "
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



        });//end

