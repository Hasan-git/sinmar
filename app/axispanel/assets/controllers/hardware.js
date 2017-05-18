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
            conf.modules = 'security, date';
            conf.scrollToTopOnError = false;

            // Call the setup function
            $.validate({
                language: conf.language,
                modules: conf.modules
            });

            //TODO://
            var urlPath = '../php/items/';

            ////////////////////////////////////////////////////

            ////////////////////////////////////////////////////

            //---------------------
            //      SERVICES
            //---------------------

            var services = {
                getBrandsNewForm: function() {
                    $.ajax({
                        url: '../php/brands/get.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#newFormContainer #brandName').find('option').remove().end().append('<option value="">Select Brand</option>')

                            $.each(data.data, function(key, value) {
                                $('#newFormContainer').find('#brandName')
                                    .append($("<option></option>").attr("value", value.brandName).text(value.brandName));
                            });
                        }
                    });

                },
                getCategoriesNewForm: function() {
                    $.ajax({
                        url: '../php/categories/get.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#newFormContainer #categoryName').find('option').remove().end().append('<option value="">Select Category</option>')

                            $.each(data.data, function(key, value) {
                                $('#newFormContainer').find('#categoryName')
                                    .append($("<option></option>").attr("value", value.categoryName).text(value.categoryName));
                            });
                        }
                    });
                },
                getBrandsEditForm: function(selectedValue) {
                    $.ajax({
                        url: '../php/brands/get.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#editFormContainer #brandName').find('option').remove()
                            $.each(data.data, function(key, value) {
                                if (value.brandName == selectedValue) {
                                    $('#editFormContainer').find('#brandName')
                                        .append($("<option></option>").attr("value", value.brandName).text(value.brandName).attr("selected", "selected")).change();

                                } else {
                                    $('#editFormContainer').find('#brandName')
                                        .append($("<option></option>").attr("value", value.brandName).text(value.brandName));
                                }
                            })

                        }
                    });

                },
                getCategoriesEditForm: function(selectedValue) {
                    $.ajax({
                        url: '../php/categories/get.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#editFormContainer #categoryName').find('option').remove()

                            $.each(data.data, function(key, value) {
                                if (value.categoryName == selectedValue) {
                                    $('#editFormContainer').find('#categoryName')
                                        .append($("<option></option>").attr("value", value.categoryName).text(value.categoryName).attr("selected", "selected")).change();

                                } else {
                                    $('#editFormContainer').find('#categoryName')
                                        .append($("<option></option>").attr("value", value.categoryName).text(value.categoryName));
                                }
                            })

                        }
                    });
                }
            };

            ////////////////////////////////////////////////////

            ////////////////////////////////////////////////////

            // // Init Select2 - Basic Single
            $(".select2-single").select2();

            //Enable, Disable checkbox
            $("#newFormContainer #offer").click(function() {
                if ($(this).is(":checked")) {
                    $("#newFormContainer #offerPrice").removeAttr("disabled");
                    $("#newFormContainer #offerPrice").focus();
                } else {
                    $("#newFormContainer #offerPrice").attr("disabled", "disabled");
                }
            });

            $("#editFormContainer #offer").change(function() {
                if ($(this).is(":checked")) {
                    $("#editFormContainer #offerPrice").removeAttr("disabled");
                    $("#editFormContainer #offerPrice").focus();
                } else {
                    $("#editFormContainer #offerPrice").attr("disabled", "disabled");
                }
            });

            //Get all categories
            $.ajax({
                url: urlPath + 'get.php?itemType=Hardware',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    //Datatable Initializer
                    var tbl = $('#datatable3').dataTable({
                        "sDom": '<"dt-panelmenu text-center clearfix"T><"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
                        // "sDom": '<"dt-panelmenu clearfix"Tfr>t<"dt-panelfooter clearfix"ip>',
                        "oTableTools": {
                            "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                        },
                        lengthMenu: [
                            [10, 25, 50, -1],
                            ['10 rows', '25 rows', '50 rows', 'Show all']
                        ],
                        buttons: [
                            'pageLength'
                        ],
                        data: data.data,
                        columns: [
                            //TODO://
                            // {'data':'itemId'},
                            {
                                'data': 'itemName'
                            },
                            {
                                'data': 'brandName'
                            },
                            {
                                'data': 'categoryName'
                            },
                            {
                                'data': 'new',
                                'render': function(data, type, full, meta) {
                                    return data ? "Yes" : "No";
                                }
                            },
                            {
                                'data': 'offer',
                                'render': function(data, type, full, meta) {
                                    return data ? "Yes" : "No";
                                }
                            },
                            {
                                'data': 'price',
                                'render': function(data, type, full, meta) {
                                    return "$ " + data;
                                }
                            },
                            // {'data':'description'},
                            {
                                'data': null,
                                'render': function(data, type, full, meta) {
                                    //set data-row attr as the datatable row -> give access the save changes to update row data localy
                                    return "<button class='btn btn-xs btn-success' scrollto='#editFormContainer' id='editRecord' data-row='" + meta.row + "' data-record='" + JSON.stringify(full) + "'  > <i class='fa fa-edit'></i> </button> " +
                                        "<a class='btn btn-xs btn-danger' id='deleteRecord' data-row='" + meta.row + "' record-id='" + full.itemId + "' href='#'> <i class='fa fa-trash'></i> </a> "
                                },

                            }
                        ]
                    })
                    // Add Placeholder text to datatables filter bar
                    $('.dataTables_filter input').attr("placeholder", "Enter Terms...");
                }
            })

            $('#cancelEditForm').click(function() {
                $('#editFormContainer').hide(700);
                $('#editForm').find("input[type=text],input[type=file],select, textarea").val("")
                myDropzoneEdit.removeAllFiles(true);
            });

            //Edit category btn Clicked
            $('#datatable3 tbody').on('click', '#editRecord', function(event) {

                event.preventDefault();
                event.stopPropagation();
                $('#editForm').find("input[type=text],input[type=file],select, textarea").val("")
                //var product = JSON.parse($(this).attr('record-id')) 
                var mainRecord = $(this).attr('data-record');
                mainRecord = JSON.parse(mainRecord);
                var datatableRow = $(this).attr('data-row');

                //set datatable row in data-row attr to for saveEditForm(Save button) to have the access for datatable row
                $('#editFormContainer').find('#saveEditForm').attr("data-row", datatableRow)

                //INIT
                services.getBrandsEditForm(mainRecord.brandName)
                services.getCategoriesEditForm(mainRecord.categoryName)

                //TODO://
                $('#editFormContainer').find('#nfBoxName').html(mainRecord.itemName)
                $('#editFormContainer').find('#itemName').val(mainRecord.itemName)
                $('#editFormContainer').find('#model').val(mainRecord.model)
                $('#editFormContainer').find('#itemSize').val(mainRecord.itemSize)
                $('#editFormContainer').find('#model').val(mainRecord.model)
                $('#editFormContainer').find('#color').val(mainRecord.color)
                $('#editFormContainer').find('#price').val(mainRecord.price)
                $('#editFormContainer').find('#description').val(mainRecord.description)
                $('#editFormContainer').find('#new').prop('checked', mainRecord.new == 1 ? true : false)
                $('#editFormContainer').find('#offer').prop('checked', mainRecord.offer == 1 ? true : false).change()
                $('#editFormContainer').find('#offerPrice').val(mainRecord.offerPrice)
                // $('#editFormContainer').find('#itemType').val(mainRecord.itemType)
                // $('#editFormContainer').find('#imagenameEdit').val(mainRecord.itemImage)
                $('#editFormContainer').find('#imagenameEdit').val(mainRecord.itemImageName || mainRecord.itemImage)
                $('#editFormContainer').find('#itemId').val(mainRecord.itemId)

                $('#editFormContainer').show(700);

            });

            // Edit category form submited
            //NOT USED ANY MORE
            $('#saveEditForm0').click(function() {
                if (!$('#editForm').isValid(conf.language, conf, true)) {
                    // displayErrors( errors );
                } else {
                    $.ajax({
                        url: urlPath + 'update.php',
                        method: 'POST',
                        data: $('#editForm').serialize(),
                        success: function(data) {
                            // Serialize the form to Json 
                            var localRecord = $('#editForm').serializeFormJSON()

                            //Get the datatable row from the button attr and emit changes
                            var datatableRow_ = $('#saveEditForm').attr("data-row");
                            //get the dt instance
                            var myDataTable = $('#datatable3').DataTable();
                            // get / set dt row
                            var row = myDataTable.row(datatableRow_);
                            //Change row.projectName
                            //
                            myDataTable.row(row).data(localRecord).draw();
                            $('#editFormContainer').hide(700);
                            toastr.success('category updated successfully', 'Notification', {
                                timeOut: 5000
                            })
                        },
                        error: function(err) {
                            if (err.responseText) {
                                toastr.error(err.responseText, 'Notification', {
                                    timeOut: 5000
                                })
                            } else {
                                toastr.error("Something went wrong", 'Notification', {
                                    timeOut: 5000
                                })
                            }
                        }
                    });

                }

            });


            // New category btn clicked -> show the form
            $('#openNewRecordForm').click(function() {
                services.getBrandsNewForm()
                services.getCategoriesNewForm()
                $('#newform').find("input[type=text],input[type=file],select, textarea input[type=number]").val("").change()
                $('#newform').find('#price').val(0)
                $('#newform').get(0).reset();

                $('#newFormContainer').show(800);

            });

            // New category canceled
            $('#cancelNewForm').click(function() {
                $('#newFormContainer').hide(700);
                $('#newform').find("input[type=text],input[type=file],select, textarea").val("")
                myDropzone.removeAllFiles(true);
            });

            //CREATE NEW category IN PROCESS
            //NOT USED ANY MORE IN THIS CONTROLLER
            $('#saveNewForm0').click(function() {

                if (!$('#newform').isValid(conf.language, conf, true)) {
                    // displayErrors( errors );
                } else {
                    // The form is valid
                    $.ajax({
                        url: urlPath + 'post.php',
                        method: 'POST',
                        data: $('#newform').serialize(),
                        success: function(data) {

                            var _newRecord = JSON.parse(data)

                            var myDataTable = $('#datatable3').DataTable();

                            myDataTable.row.add(_newRecord).draw(false);

                            $('#newFormContainer').hide(700);
                            toastr.success('category updated successfully', 'Notification', {
                                timeOut: 5000
                            })
                        },
                        error: function(err) {
                            if (err.responseText) {
                                toastr.error(err.responseText, 'Notification', {
                                    timeOut: 5000
                                })
                            } else {
                                toastr.error("Something went wrong", 'Notification', {
                                    timeOut: 5000
                                })
                            }
                        }
                    });


                }



            });


            //DELETE category CLICKED
            $('#datatable3 tbody').on('click', '#deleteRecord', function(event) {
                var thisDeleteBtn = $(this);
                var RecordId = $(this).attr('record-id');
                var inst = $('[data-remodal-id=modal]').remodal();

                inst.open();

                $(document).on('confirmation', '.remodal', function() {

                    $.ajax({
                        url: urlPath + 'delete.php',
                        method: 'POST',
                        //TODO:??
                        data: {
                            itemId: RecordId
                        },
                        success: function(data) {

                            //get the dt instance
                            var myDataTable = $('#datatable3').DataTable();

                            // get / set dt row
                            var row = myDataTable.row($(thisDeleteBtn).parents('tr')).remove().draw();;

                            inst.close();
                            toastr.success('category deleted successfully', 'Notification', {
                                timeOut: 5000
                            })
                        },
                        error: function(err) {
                            if (err.responseText) {
                                toastr.error(err.responseText, 'Notification', {
                                    timeOut: 5000
                                })
                            } else {
                                toastr.error("Something went wrong", 'Notification', {
                                    timeOut: 5000
                                })
                            }
                        }
                    });
                });

                $(document).on('cancellation', '.remodal', function() {
                    inst.close();
                });

            });




            Dropzone.autoDiscover = false;

            //DROPZONE FOR NEW ITEM
            //DROPZONE FOR NEW ITEM
            //DROPZONE FOR NEW ITEM
            //DROPZONE FOR NEW ITEM
            var myDropzone = new Dropzone("div#myId", {
                url: "../php/itemimages/upload.php",
                paramName: "file",
                uploadMultiple: true,
                maxFiles: 10,
                parallelUploads: 1,
                autoProcessQueue: false,
                addRemoveLinks: false,
                acceptedFiles: "image/jpeg,image/jpg,image/png,image/gif",
                init: function() {
                    var submitButton = document.querySelector("#saveNewForm");
                    var myDropzone = this; //closure
                    var idz;
                    var itemName;
                    submitButton.addEventListener("click", function() {

                        if ($('#newform').isValid(conf.language, conf, true)) {

                            var fd = new FormData(document.getElementById("newform"));
                            // var data = $('#editForm').serialize()
                            // fd.append('itemImage', $('#newform input[type=file]')[0].files[0]); 

                            $.ajax({
                                url: "../php/items/post.php",
                                type: "POST",
                                data: fd,
                                enctype: 'multipart/form-data',
                                processData: false, // tell jQuery not to process the data
                                contentType: false // tell jQuery not to set contentType
                            }).done(function(data) {
                                console.log(data);

                                data = JSON.parse(data)

                                var _newRecord = data

                                var myDataTable = $('#datatable3').DataTable();


                                myDataTable.row.add(_newRecord).draw(false);


                                idz = data.itemId;
                                itemName = data.itemName;
                                console.log(idz, itemName);
                                toastr.success("Item created successfully", 'Notification', {
                                    timeOut: 5000
                                });
                                // myDropzone.on('sendingmultiple', function(data, xhr, formData) {
                                //     formData.append("itemId", idz);
                                //     formData.append("itemName", itemName);

                                // });

                                myDropzone.on('sending', function(data, xhr, formData) {
                                    console.log('sending')
                                    formData.append("itemId", idz);
                                    formData.append("itemName", itemName);
                                });

                                myDropzone.on("queuecomplete", function(file, res) {
                                    if (myDropzone.files[0].status != Dropzone.SUCCESS) {
                                        toastr.error("Failed to upload images", 'Notification', {
                                            timeOut: 5000
                                        })
                                        $('#newFormContainer').hide(700);
                                        myDropzone.removeAllFiles(true);
                                        $('#newform').find("input[type=text],input[type=file],select, textarea").val("")
                                    } else {
                                        toastr.success("Item images uploaded successfully", 'Notification', {
                                            timeOut: 5000
                                        });
                                        $('#newFormContainer').hide(700);
                                        myDropzone.removeAllFiles(true);
                                        $('#newform').find("input[type=text],input[type=file],select, textarea").val("")

                                    }
                                });

                                if (myDropzone.getQueuedFiles().length > 0) {
                                    myDropzone.processQueue(); //tell Dropzone to process all queued files
                                } else {
                                    $('#newFormContainer').hide(700);
                                    $('#newform').find("input[type=text],input[type=file],select, textarea").val("")
                                }



                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //IMPORTANT CHECK IF ERROR ITEM NAME IS UNIQUE
                                //IMPORTANT CHECK IF ERROR ITEM NAME IS UNIQUE
                                //IMPORTANT CHECK IF ERROR ITEM NAME IS UNIQUE
                                //IMPORTANT CHECK IF ERROR ITEM NAME IS UNIQUE
                                toastr.error("Something went wrong", 'Notification', {
                                    timeOut: 5000
                                })
                            });
                            //  myDropzone.processQueue();

                        } else {
                            toastr.warning("Some fields are required", 'Notification', {
                                timeOut: 5000
                            })
                        } //Validation
                    }); //event click
                }
            });

            // LOOP OVER QUEUE -> Good when parallelUploads is less than max files 
            myDropzone.on('success', myDropzone.processQueue.bind(myDropzone));

            // ADD  REMOVE BTN MANUALLY
            myDropzone.on("addedfile", function(file) {
                var _this = this;

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
            });
            $('#datatable3 tbody').on('click', '#editRecord', function(event) {
                myDropzoneEdit.removeAllFiles(true);
            })


            //DROPZONE FOR EDIT ITEM
            //DROPZONE FOR EDIT ITEM
            //DROPZONE FOR EDIT ITEM
            //DROPZONE FOR EDIT ITEM
            var myDropzoneEdit = new Dropzone("div#dropzoneEdit", {
                url: "../php/itemimages/upload.php",
                paramName: "file",
                uploadMultiple: true,
                maxFiles: 10,
                parallelUploads: 1,
                autoProcessQueue: false,
                addRemoveLinks: false,
                acceptedFiles: "image/jpeg,image/jpg,image/png,image/gif",
                init: function() {

                    var submitButton = document.querySelector("#saveEditForm");
                    var myDropzoneEdit = this; //closure
                    var idz;
                    var itemName;

                    //GET FILES FROM SERVER -> FILES TO DROPZONE 
                    $('#datatable3 tbody').on('click', '#editRecord', function(event) {
                        myDropzoneEdit.removeAllFiles(true);

                        var itemId_ = $('#editFormContainer').find('#itemName').val()
                        $.get('../php/itemimages/get.php?itemName=' + itemId_, function(data) {
                             var images = JSON.parse(data)
                            if(images.length){
                                $.each(data, function(key, value) {
                                    var mockFile = {
                                        name: value.imageName,
                                        imageId: value.ImageId
                                    };
                                    // myDropzoneEdit.options.addedfile.call(myDropzoneEdit, mockFile);
                                    myDropzoneEdit.emit("addedfile", mockFile);
                                    // myDropzoneEdit.options.thumbnail.call(myDropzoneEdit, mockFile, "images/"+value.imageName);
                                    myDropzoneEdit.emit("thumbnail", mockFile, "images/" + value.imageName);
                                    myDropzoneEdit.files.push(mockFile);
                                });
                            }
                            
                        });
                    });


                    submitButton.addEventListener("click", function() {

                        if ($('#editForm').isValid(conf.language, conf, true)) {

                            var fd = new FormData(document.getElementById("editForm"));
                            // var data = $('#editForm').serialize()
                            // fd.append('itemImage', $('#newform input[type=file]')[0].files[0]); 

                            $.ajax({
                                url: "../php/items/update.php",
                                type: "POST",
                                data: fd,
                                enctype: 'multipart/form-data',
                                processData: false, // tell jQuery not to process the data
                                contentType: false // tell jQuery not to set contentType
                            }).done(function(data) {

                                // data = JSON.parse(data)
                                // var _newRecord = data
                                var response = JSON.parse(data)
                                // // Serialize the form to Json 
                                var localRecord = $('#editForm').serializeFormJSON()

                                localRecord.new = !!localRecord.new
                                localRecord.offer = !!localRecord.offer

                                //Get the datatable row from the button attr and emit changes
                                var datatableRow_ = $('#saveEditForm').attr("data-row");
                                // //get the dt instance
                                var myDataTable = $('#datatable3').DataTable();
                                // // get / set dt row
                                var row = myDataTable.row(datatableRow_);
                                // //Change row.projectName
                                // //
                                myDataTable.row(row).data(response.data).draw();

                                // console.log(myDataTable.row(row).data())
                                // idz = data.itemId;
                                itemName = localRecord.itemName;
                                toastr.success("Item created successfully", 'Notification', {
                                    timeOut: 5000
                                });
                                // myDropzoneEdit.on('sendingmultiple', function(data, xhr, formData) {
                                //     formData.append("itemId", idz);
                                //     formData.append("itemName", itemName);

                                // });

                                myDropzoneEdit.on('sending', function(data, xhr, formData) {
                                    console.log('sending')
                                    // formData.append("itemId", idz);
                                    formData.append("itemName", itemName);
                                });

                                myDropzoneEdit.on("queuecomplete", function(file, res) {
                                    if (myDropzoneEdit.files[0].status != Dropzone.SUCCESS) {
                                        toastr.error("Failed to upload images", 'Notification', {
                                            timeOut: 5000
                                        })
                                        $('#editFormContainer').hide(700);
                                        myDropzoneEdit.removeAllFiles(true);
                                        $('#editForm').find("input[type=text],input[type=file],select, textarea").val("")
                                    } else {
                                        toastr.success("Item images uploaded successfully", 'Notification', {
                                            timeOut: 5000
                                        });
                                        $('#editFormContainer').hide(700);
                                        myDropzoneEdit.removeAllFiles(true);
                                        $('#editForm').find("input[type=text],input[type=file],select, textarea").val("")

                                    }
                                });


                                if (myDropzoneEdit.getQueuedFiles().length > 0) {
                                    myDropzoneEdit.processQueue(); //tell Dropzone to process all queued files
                                } else {
                                    $('#editFormContainer').hide(700);
                                    //CLEAR THE FORM INPUTS
                                    $('#editForm').find("input[type=text],input[type=file],select, textarea").val("")
                                }

                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //IMPORTANT CHECK IF ERROR ITEM NAME IS UNIQUE
                                //IMPORTANT CHECK IF ERROR ITEM NAME IS UNIQUE
                                //IMPORTANT CHECK IF ERROR ITEM NAME IS UNIQUE
                                //IMPORTANT CHECK IF ERROR ITEM NAME IS UNIQUE
                                toastr.error("Something went wrong", 'Notification', {
                                    timeOut: 5000
                                })
                            });

                        } else { //VALIDATION
                            toastr.warning("Some fields are required", 'Notification', {
                                timeOut: 5000
                            })
                        }
                    }); //EVENT CLICK

                }
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
                            url: urlPath + '../itemimages/delete.php',
                            method: 'POST',
                            data: {
                                ImageId: file.imageId
                            },
                            success: function(data) {
                                toastr.success('Image deleted successfully', 'Notification', {
                                    timeOut: 5000
                                })
                                _this.removeFile(file);
                            },
                            error: function() {
                                toastr.error('Could not delete this image', 'Notification', {
                                    timeOut: 5000
                                })
                            }
                        })
                    });
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




        }); //end