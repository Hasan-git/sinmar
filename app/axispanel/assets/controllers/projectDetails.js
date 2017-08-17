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

    var urlPath   = 'http://sinmar-lb.com/php/projectdetails/';
        //var urlPath   = '../php/projectdetails/';
        var typeParam = getUrlParameter('projecttype');

    $(".select2-single").select2();

    // var maxImagesSize = 300000, maxImagesWidth = 850, maxImagesHeight = 478;
    var maxImagesSize = 300000,
        maxImagesWidth = 1080,
        maxImagesHeight = 720;

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
                cache : false,
                success: function(data) {
                    $('#newFormContainer #prdetailsType').find('option').remove().end().append('<option value="" selected="selected">Select Type</option>').attr("selected", "selected").change()

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
                cache : false,
                success: function(data) {
                    $('#newFormContainer #prdetailsName').find('option').remove().end().append('<option value="">Select Project</option>').attr("selected", "selected").change()

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
                        cache : false,
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
                    cache : false,
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
            cache : false,
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
                url:  '../php/projectdetails/get.php?projecttype='+prTypeName,
                method:'GET',
                dataType:'json',
                cache : false,
                success:function(data){
            console.log(data)

                    $('#imagesContainer').hide(700);
                    $('#editFormContainer').hide(700);
                    $('#newFormContainer').hide(700);

                    $('#newform').find("input[type=text],input[type=file],select, textarea").val("").change()
                    $('#editForm').find("input[type=text],input[type=file],select, textarea").val("").change()
                    $('#imagesform').find("input[type=text],input[type=file],select, textarea").val("").change()

                    var myDataTable= $('#datatable3').DataTable();
                    myDataTable.clear();
                    myDataTable.rows.add(data.data);
                    myDataTable.draw();
                    $('#PDName').html(prTypeName)


                    toastr.success(prTypeName + ' loaded successfully', 'Notification', {timeOut: 1400})
                 }
            })
    })



    var projectTypeName = $('#projectTypeCtrl').val()


    //Get all records
    $.ajax({
        url: '../php/projectdetails/get.php?projecttype='+projectTypeName,
        method:'GET',
        dataType:'json',
        cache : false,
        success:function(data){
            console.log(data)
            $('#PDName').html(projectTypeName)
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


    //OPEN IMAGES CONTAINER and append item images to the form
    $('#datatable3 tbody').on( 'click', '#openImageContainer', function (event) {

        event.preventDefault();
        event.stopPropagation();
        $('#imagesContainer').find("input[type=text],input[type=file],select, textarea").val("")

        var projectTitle = $(this).attr('record-id');

        $('#iboxname').html(projectTitle)
        $('#imagesContainer').find('#projectTitle').val(projectTitle)

        // $.ajax({
        //     url: '../php/projectimages/get.php?projectTitle='+projectTitle,
        //     method:'GET',
        //     cache : false,
        //     success:function(data){
        //         $('#imagesContainer').find(".image-viewer").empty()
        //         var response = JSON.parse(data)
        //         console.log(response)

        //         if(response.data.length){
        //             $.each(response.data, function(key, value) {
        //                 var images ='<div class="col--2 ">'+
        //                                 '<i class="fa fa-trash btn btn-warning btn-xs" id="deleteImages" record-id="'+value.projectImageId+'" ></i>'+
        //                                 '<div class="image-wrapper" >'+
        //                                     '<img src="projectImages/'+projectTitle+'" class="img-thumbnail" alt="Cinque Terre" width="100" height="236"> '+
        //                                         '<p class=""> Before </p>'+
        //                                 '</div>'+
        //                                 '<div class="image-wrapper" >'+
        //                                     '<img src="projectImages/'+value.imageAfter+'" class="img-thumbnail" alt="Cinque Terre" width="100" height="236"> '+
        //                                        '<p class=""> After </p>'+
        //                                 '</div>'+
        //                             '</div>';
        //                 $('.image-viewer').append(images)
        //             });
        //         }else{
        //              var message ='<div class="col-xs-8"> <b><i class="fa fa-briefcase fa-lg"></i>There is no images</b> </div>';
        //              var message_ = '<div class="col-xs-8 alert alert-warning m-l-sm">'+
        //                               '<strong><i class="fa fa-briefcase fa-lg m-r-xs"></i></strong> No images found !'+
        //                             '</div> '
        //              $('.image-viewer').append(message_)
        //         }
        //     }
        // });
        $('#imagesContainer').show(700);

    });

    $('#imagesContainer').on( 'click', '#deleteImages', function (event) {

        var thisBtn = $(this);
        var imageId = $(this).attr('record-id');

        $.ajax({
                url:   '../php/projectimages/delete.php',
                method:'POST',
                cache : false,
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
                    url: '../php/projectimages/upload.php',
                    method:'POST',
                    cache : false,
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

        $('#editForm').find("input[type=text],input[type=file],select, textarea input[type=number]").val("").change()
        $('#editForm').get(0).reset();


        $('#editFormContainer').show(700);

        //var product = JSON.parse($(this).attr('record-id'))
        var mainRecord = $(this).attr('data-record');
        mainRecord = JSON.parse(mainRecord);

       console.log(mainRecord)
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
        $('#editFormContainer').find('#imagename2').val(mainRecord.projectImage || mainRecord.projectImageName)
        $('#editFormContainer').find('#prdetailsId').val(mainRecord.prdetailsId)



    });

    // Edit PRoJECT form submited
    $('#saveEditForm').click(function(){
       if( !$('#editForm').isValid(conf.language, conf, true) ) {
            // displayErrors( errors );
           } else {

                var fd = new FormData(document.getElementById("editForm"));
                $.ajax({
                    url:  '../php/projectdetails/update.php',
                    method:'POST',
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success:function(data){
                    // Serialize the form to Json
                    var localRecord = $('#editForm').serializeFormJSON()

                    var response = JSON.parse(data)

                    console.log("edit",localRecord,response)




                    //Get the datatable row from the button attr and emit changes
                    var datatableRow_ = $('#saveEditForm').attr("data-row");
                    //get the dt instance
                    var myDataTable= $('#datatable3').DataTable();
                    // get / set dt row
                    var row = myDataTable.row(datatableRow_);
                    //Change row.projectName

                    //checking if the projectType changed? if changed to remove the record from the current table
                    var prevProjectType = $('#projectTypeCtrl').val()
                    var currentProjectType = response.data.prdetailsType

                    if(prevProjectType != currentProjectType){
                        //Different projectType than remve the record from the table
                         myDataTable.row(row).remove().draw();
                    }else{
                        //Same projectType then add to the table
                        myDataTable.row(row).data(response.data).draw();
                    }

                    $('#editFormContainer').hide(700);

                    toastr.success('Project updated successfully', 'Notification', {timeOut: 5000})
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
        $('#newform').find("input[type=text],input[type=file],select, textarea input[type=number]").val("").change()
        $('#newform').get(0).reset();

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
                url: '../php/projectdetails/post.php',
                method:'POST',
                data: fd,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success:function(data){

                    var _newRecord = JSON.parse(data);

                    // if(_newRecord.prdetailsType == typeParam){
                        // _newRecord.new = _newRecord.new==1 ? true : false;

                    //checking if the projectType changed? if changed to remove the record from the current table
                    var prevProjectType = $('#projectTypeCtrl').val()
                    var currentProjectType = _newRecord.prdetailsType

                    if(prevProjectType == currentProjectType){
                        // projectTypes match than add record to the current table
                        var myDataTable= $('#datatable3').DataTable();
                        myDataTable.row.add(_newRecord ).draw( false )
                    }
                    // }

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

    // ----------------------------------------------------------------
    //          DELETE RECORD
    //------------------------------------------------------------------

    //DELETE brand CLICKED
    $('#datatable3 tbody').on( 'click', '#deleteRecord', function (event) {
        var thisDeleteBtn = $(this);
        var RecordId = $(this).attr('record-id');
        var inst = $('[data-remodal-id=modal]').remodal();

        inst.open();

        $(document).on('confirmation', '.remodal', function () {

            $.ajax({
                    url:  '../php/projectdetails/delete.php',
                    method:'POST',
                    data: {prdetailsId:RecordId},
                    success:function(data){

                    //get the dt instance
                    var myDataTable= $('#datatable3').DataTable();

                    // get / set dt row
                    var row = myDataTable.row($(thisDeleteBtn).parents('tr')).remove().draw();

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


            //DROPZONE FOR EDIT ITEM
            //DROPZONE FOR EDIT ITEM
            //DROPZONE FOR EDIT ITEM
            //DROPZONE FOR EDIT ITEM
            var myDropzoneEdit = new Dropzone("div#dropzoneEdit", {
                url: "../php/projectimages/upload.php",
                paramName: "file",
                uploadMultiple: true,
                maxFiles: 10,
                parallelUploads: 1,
                autoProcessQueue: false,
                addRemoveLinks: false,
                acceptedFiles: "image/jpeg,image/jpg,image/png,image/gif",
                init: function() {

                    var submitButton = document.querySelector("#saveImagesForm");
                    var myDropzoneEdit = this; //closure
                    var projectTitle;

                    //GET FILES FROM SERVER -> FILES TO DROPZONE
                    $('#datatable3 tbody').on('click', '#openImageContainer', function(event) {
                        myDropzoneEdit.removeAllFiles(true);


                         projectTitle = $(this).attr('record-id')
                        $.get('../php/projectimages/get.php?projectTitle=' + projectTitle, function(data) {

                            var images = JSON.parse(data)
                            if(images.data.length){
                                $.each(images.data, function(key, value) {
                                var mockFile = {
                                    name: '',//value.imageAfter
                                    imageId: value.projectImageId,
                                    size : ''
                                };
                                // myDropzoneEdit.options.addedfile.call(myDropzoneEdit, mockFile);
                                myDropzoneEdit.emit("addedfile", mockFile);
                                // myDropzoneEdit.options.thumbnail.call(myDropzoneEdit, mockFile, "images/"+value.imageName);
                                myDropzoneEdit.emit("thumbnail", mockFile, "projectImages/" + value.imageAfter);
                                myDropzoneEdit.files.push(mockFile);
                            });
                            }
                        });
                    });

                    // SAVE EDIT FORM CHANGES
                    submitButton.addEventListener("click", function() {

                                myDropzoneEdit.on('sending', function(data, xhr, formData) {
                                    formData.append("projectTitle", projectTitle);
                                });

                                myDropzoneEdit.on('error', function(file, errorMessage) {
                                    // an error occurred but is there any more files in Queue should be uploaded ?
                                    if (this.getQueuedFiles().length > 0) {
                                        myDropzoneEdit.processQueue();
                                    }
                                });

                                if (myDropzoneEdit.getQueuedFiles().length >= 0) {
                                    myDropzoneEdit.processQueue(); //tell Dropzone to process all queued files
                                } else {
                                    // no images to upload
                                     $('#imagesContainer').hide(700);
                                }
                    }); //EVENT CLICK

                    this.on("thumbnail", function(file) {
                        // if size check if image is pushed from database
                        if (file.size) {
                            if (file.size >= maxImagesSize) {
                                file.rejectSize();
                            } else if (file.width > maxImagesWidth || file.height > maxImagesWidth) {
                                file.rejectDimensions();
                            } else {
                                file.accept();
                            }
                        }
                    });

                    this.on("complete", function(file) {
                        //check if all images uploaded and queue empty then edit process is done
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                            $('#imagesContainer').hide(700);
                        }
                    });

                    this.on('error', function(file, errorMessage) {
                        this.removeFile(file)
                        toastr.error("'" + file.name + "' : " + errorMessage, 'Notification', {
                            timeOut: 7000
                        })
                    });

                },
                    accept: function(file, done) {
                    // console.log(file, done)
                    file.accept = function() {
                        done()
                    };
                    file.rejectDimensions = function() {
                        done("Invalid dimension, Accepted Dimensions (" + maxImageWidth + "x" + maxImageHeight + ")");
                    };
                    file.rejectSize = function() {
                        done("Invalid size, Accepted Size  (" + (maxImagesSize / 1000) + " Kb)");
                    };
                }
            });

                myDropzoneEdit.on("queuecomplete", function(file, res) {
                        $.each(myDropzoneEdit.files, function(key, val) {
                            // file size referring for none existing files in the database
                            if (val.size && val.status != "added") {
                                if (val.status == Dropzone.SUCCESS) {
                                    toastr.success(val.name + " Uploaded successfully ", 'Notification', {
                                        timeOut: 2000
                                    })
                                } else {
                                    //toastr.error("/Failed to upload " + val.name , 'Notification', {timeOut: 6000})
                                }
                            }
                        })
                    });

            // LOOP OVER QUEUE -> Good when parallelUploads is less than max files
            myDropzoneEdit.on('success', myDropzoneEdit.processQueue.bind(myDropzoneEdit));

            // ADD  REMOVE BTN MANUALLY
            myDropzoneEdit.on("addedfile", function(file) {
                var _this = this;

                if (file.imageId) {
                    var removeButtonForServer = Dropzone.createElement("<button data-dz-remove " +
                        "class='del_thumbnail btn btn-default btn-xs btn-block m-t-xxs' " +
                        " style='cursor:pointer;color:#C5350A;' image-id=" + file.imageId + ">Delete <span style='cursor:pointer;' class='fa fa-cloud'></span></button>");

                    removeButtonForServer.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        $.ajax({
                            url: '../php/projectimages/delete.php',
                            method: 'POST',
                            data: {
                                projectImageId: file.imageId
                            },
                            success: function(data) {
                                toastr.success('Image deleted successfully', 'Notification', {
                                    timeOut: 2000
                                })
                                _this.removeFile(file);
                            },
                            error: function() {
                                toastr.error('Could not delete this image', 'Notification', {
                                    timeOut: 2000
                                })
                            }
                        })
                    });
                    $(file.previewElement).find('.dz-size')
                        .html("Existing")
                        .css({
                            'font-size': '10px',
                            'font-family': 'sans-serif',
                        });
                    $(file.previewElement)
                        .css({
                            'background': '#f5c12d'
                        })

                    file.previewElement.appendChild(removeButtonForServer);
                } else {
                    /* Maybe display some more file information on your page */
                    var removeButton = Dropzone.createElement("<button data-dz-remove " +
                        "class='del_thumbnail btn btn-default btn-xs btn-block m-t-xxs' " +
                        " style='cursor:pointer;color:#C5350A;'><span style='cursor:pointer;' class='fa fa-trash'></span></button>");
                    removeButton.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        _this.removeFile(file);
                    });
                    file.previewElement.appendChild(removeButton);
                }
            });
    });//end

