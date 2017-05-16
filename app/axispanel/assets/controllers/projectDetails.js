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

    var urlPath   = '../php/projectdetails/';
    var typeParam = getUrlParameter('projecttype');

    ////////////////////////////////////////////////////

    ////////////////////////////////////////////////////


    //---------------------
    //      SERVICES
    //---------------------

    var services = {
        getProjectTypesNewForm: function() {
            $.ajax({
                url: '../php/projecttype/get.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#newFormContainer #prdetailsType').find('option').remove().end().append('<option value="">Select Type</option>')

                    $.each(data.data, function(key, value) {
                        $('#newFormContainer').find('#prdetailsType')
                            .append($("<option></option>").attr("value", value.projectTypeName).text(value.projectTypeName));
                    });
                }
            });
        },
        getProjectNamesNewForm: function() {
            $.ajax({
                url: '../php/projects/get.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#newFormContainer #prdetailsName').find('option').remove().end().append('<option value="">Select Project</option>')

                    $.each(data.data, function(key, value) {
                        $('#newFormContainer').find('#prdetailsName')
                            .append($("<option></option>").attr("value", value.projectName).text(value.projectName));
                    });
                }
            });
        },
        getProjectTypesEditForm: function(selectedValue) {
                    $.ajax({
                        url: '../php/projecttype/get.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#editFormContainer #prdetailsType').find('option').remove()
                            $.each(data.data, function(key, value) {
                                if (value.projectTypeName == selectedValue) {
                                    $('#editFormContainer').find('#prdetailsType')
                                        .append($("<option></option>").attr("value", value.projectTypeName).text(value.projectTypeName).attr("selected", "selected")).change();

                                } else {
                                    $('#editFormContainer').find('#prdetailsType')
                                        .append($("<option></option>").attr("value", value.projectTypeName).text(value.projectTypeName));
                                }
                            })

                        }
                    });

                },
            getProjectNamesEditForm: function(selectedValue) {
                $.ajax({
                    url: '../php/projects/get.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#editFormContainer #prdetailsName').find('option').remove()

                        $.each(data.data, function(key, value) {
                            if (value.projectName == selectedValue) {
                                $('#editFormContainer').find('#prdetailsName')
                                    .append($("<option></option>").attr("value", value.projectName).text(value.projectName).attr("selected", "selected")).change();

                            } else {
                                $('#editFormContainer').find('#prdetailsName')
                                    .append($("<option></option>").attr("value", value.projectName).text(value.projectName));
                            }
                        })

                    }
                });
            }
    }


    //---------------------
    //      CTRL
    //---------------------

     $.ajax({
            url: '../php/projecttype/get.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // $('#projectTypeCtrl').find('option').remove().end().append('<option value="">Select Type</option>')

                $.each(data.data, function(key, value) {
                    $('#projectTypeCtrl')
                        .append($("<option></option>").attr("value", value.projectTypeName).text(value.projectTypeName));
                });
                $('#projectTypeCtrl option:first-child').trigger('change');
            }
        });


    $('#projectTypeCtrl').change(function(){
        var prTypeName = $('#projectTypeCtrl').val()
        $.ajax({
                url: urlPath + 'get.php?projecttype='+prTypeName,
                method:'GET',
                dataType:'json',
                success:function(data){

                    $('#imagesContainer').hide(700);
                    $('#editFormContainer').hide(700);
                    $('#newFormContainer').hide(700);

                    $('#newform').find("input[type=text],input[type=file],select, textarea").val("")
                    $('#editForm').find("input[type=text],input[type=file],select, textarea").val("")
                    $('#imagesform').find("input[type=text],input[type=file],select, textarea").val("")

                    var myDataTable= $('#datatable3').DataTable();                        
                    myDataTable.clear();
                    myDataTable.rows.add(data.data);
                    myDataTable.draw();

                    toastr.success(prTypeName + ' loaded successfully', 'Notification', {timeOut: 1400})
                 }
            })
    })



    var projectTypeName = $('#projectTypeCtrl').val()


    //Get all records
    $.ajax({
        url: urlPath + 'get.php?projecttype='+projectTypeName,
        method:'GET',
        dataType:'json',
        success:function(data){
            console.log(data)
            $('#PDName').html(typeParam)
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
                    {'data':'prdetailsTitle'},
                    {'data':'prdetailsName'},
                    {'data':'location'},
                    {'data':'projectDate'},
                    {'data':'new',
                    'render': function(data, type, full, meta) {
                                return data == 1 ? "Yes" : "No";
                            }
                    },
                    {   'data':null,
                        'render': function ( data, type, full, meta ) {
                            //set data-row attr as the datatable row -> give access the save changes to update row data localy
                            return "<button class='btn btn-xs btn-info' scrollto='#imagesContainer' id='openImageContainer' record-id='"+full.prdetailsTitle+"'  > <i class='fa fa-file-image-o'></i> </button> "+
                                   "<button class='btn btn-xs btn-success' scrollto='#editFormContainer' id='editRecord' data-row='"+meta.row+"' data-record='"+JSON.stringify(full)+"'  > <i class='fa fa-edit'></i> </button> "+
                                   "<a class='btn btn-xs btn-danger' id='deleteRecord' data-row='"+meta.row+"' record-id='"+full.prdetailsId+"' href='#'> <i class='fa fa-trash'></i> </a> "
                        },
                    }
                ]
            })     
        // Add Placeholder text to datatables filter bar
        $('.dataTables_filter input').attr("placeholder", "Enter Terms...");                  
        }
    })





    // -----------------------------------------------------------------
    //          IMAGES FORM
    //------------------------------------------------------------------

    
    $('#datatable3 tbody').on( 'click', '#openImageContainer', function (event) { 

        event.preventDefault();
        event.stopPropagation();
        $('#imagesContainer').find("input[type=text],input[type=file],select, textarea").val("")

        var projectTitle = $(this).attr('record-id');

        $('#iboxname').html(projectTitle)
        $('#imagesContainer').find('#projectTitle').val(projectTitle)

        $.ajax({
                url: urlPath + '../projectimages/get.php?projectTitle='+projectTitle,
                method:'GET',
                success:function(data){ 
                    var response = JSON.parse(data)
                    $('#imagesContainer').find(".image-viewer").empty()

                     $.each(response.data, function(key, value) {
                        var images ='<div class="col--2 ">'+
                                        '<i class="fa fa-trash btn btn-warning btn-xs" id="deleteImages" record-id="'+value.projectImageId+'"></i>'+
                                        '<div class="image-wrapper" >'+
                                            '<img src="projectImages/'+value.imageBefore+'" class="img-thumbnail" alt="Cinque Terre" width="100" height="236"> '+
                                                '<p class=""> Before </p>'+
                                        '</div>'+
                                        '<div class="image-wrapper" >'+
                                            '<img src="projectImages/'+value.imageAfter+'" class="img-thumbnail" alt="Cinque Terre" width="100" height="236"> '+
                                               '<p class=""> After </p>'+
                                        '</div>'+
                                    '</div>';
                        $('.image-viewer').append(images)
                    });
                $('#imagesContainer').show(700);
                }
            });
    });

    $('#imagesContainer').on( 'click', '#deleteImages', function (event) {

        var thisBtn = $(this);
        var imageId = $(this).attr('record-id');

        $.ajax({
                url: urlPath + '../projectimages/delete.php',
                method:'POST',
                data:{projectImageId:imageId},
                success:function(data){ 

                    thisBtn.parent().hide(500, function(){ thisBtn.parent().remove(); });

                    toastr.success('Images deleted successfully', 'Notification', {timeOut: 5000})

                }
            })
    })


    $('#cancelImagesForm').click(function(){
        $('#imagesContainer').hide(700);
    });

   $('#saveImagesForm').click(function(){

        if( !$('#imagesform').isValid(conf.language, conf, true) ) {
            // displayErrors( errors );
           } else {

             var fd = new FormData(document.getElementById("imagesform"));
            $.ajax({
                    url: urlPath + '../projectimages/upload.php',
                    method:'POST',
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success:function(data){ 

                        $('#imagesContainer').hide(700);
                        toastr.success('Images uploaded successfully', 'Notification', {timeOut: 5000})

                    }
                })


           }




       
        // $('#imagesContainer').hide(700);
    });





    // -----------------------------------------------------------------
    //          EDIT FORM
    //------------------------------------------------------------------

    $('#cancelEditForm').click(function(){
        $('#editFormContainer').hide(700);
    });

    //Edit brand btn Clicked
    $('#datatable3 tbody').on( 'click', '#editRecord', function (event) {

        event.preventDefault();
        event.stopPropagation();
        $('#newform').find("input[type=text],input[type=file],select, textarea").val("")
        $('#editFormContainer').show(700);
        
        //var product = JSON.parse($(this).attr('record-id')) 
        var mainRecord = $(this).attr('data-record');
        mainRecord = JSON.parse(mainRecord);
       
        //INIT
        services.getProjectNamesEditForm(mainRecord.prdetailsName)
        services.getProjectTypesEditForm(mainRecord.prdetailsType)

        var datatableRow = $(this).attr('data-row');
        
        //set datatable row in data-row attr to for saveEditForm(Save button) to have the access for datatable row
        $('#editFormContainer').find('#saveEditForm').attr("data-row",datatableRow)
        // $('#editFormContainer').find('#nfBoxName').html(datatableRow)
        $('#editFormContainer').find('#nfBoxName').html(mainRecord.prdetailsTitle)
        $('#editFormContainer').find('#prdetailsTitle').val(mainRecord.prdetailsTitle)
        $('#editFormContainer').find('#prdetailsSubtype').val(mainRecord.prdetailsSubtype)
        $('#editFormContainer').find('#description').val(mainRecord.description)
        $('#editFormContainer').find('#notes').val(mainRecord.notes)
        $('#editFormContainer').find('#location').val(mainRecord.location)
        $('#editFormContainer').find('#projectDate').val(mainRecord.projectDate)
        $('#editFormContainer').find('#new').prop('checked', mainRecord.new == 1 ? true : false)
        $('#editFormContainer').find('#imagename2').val(mainRecord.projectImage)
        $('#editFormContainer').find('#prdetailsId').val(mainRecord.prdetailsId)



    });

    // Edit brand form submited
    $('#saveEditForm').click(function(){
       if( !$('#editForm').isValid(conf.language, conf, true) ) {
            // displayErrors( errors );
           } else {

                var fd = new FormData(document.getElementById("editForm"));
                $.ajax({
                    url: urlPath + 'update.php',
                    method:'POST',
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
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


    // ----------------------------------------------------------------
    //          NEW FORM
    //------------------------------------------------------------------

    // New brand btn clicked -> show the form
    $('#openNewRecordForm').click(function(){
        $('#newform').find("input[type=text],input[type=file],select, textarea").val("")
        services.getProjectTypesNewForm()
        services.getProjectNamesNewForm()
        $('#newFormContainer').show(800);

    });

    // New brand canceled
    $('#cancelNewForm').click(function(){
        $('#newFormContainer').hide(700);
    });

        
    //CREATE NEW brand IN PROCESS
    $('#saveNewForm').click(function(){
            
            var frm = $('#newform').serializeFormJSON();
            console.log(frm.prdetailsType)
           if( !$('#newform').isValid(conf.language, conf, true) || isEmpty(frm.prdetailsType) || isEmpty(frm.prdetailsName) ) {
            // displayErrors( errors );
                toastr.warning('Some fields are required', 'Notification', {timeOut: 5000})
           } else {
           // The form is valid
           var fd = new FormData(document.getElementById("newform"));


            $.ajax({
                url: urlPath + 'post.php',
                method:'POST',
                data: fd,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success:function(data){ 

                    var _newRecord = JSON.parse(data);

                    if(_newRecord.prdetailsType == typeParam){
                        // _newRecord.new = _newRecord.new==1 ? true : false;
                        var myDataTable= $('#datatable3').DataTable();                        
                        myDataTable.row.add(_newRecord ).draw( false )
                    }

                    $('#newFormContainer').hide(700);
                    toastr.success('Project details created successfully', 'Notification', {timeOut: 5000})
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
                data: {prdetailsId:RecordId},
                success:function(data){ 

                //get the dt instance
                var myDataTable= $('#datatable3').DataTable();

                // get / set dt row
                var row = myDataTable.row($(thisDeleteBtn).parents('tr')).remove().draw();;
                
                inst.close();
                toastr.success('Project details deleted successfully', 'Notification', {timeOut: 5000})
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

