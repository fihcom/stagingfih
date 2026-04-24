$(document).ready(function(){
   
    $('#form1').on('submit',function(){
        $('#form1save').attr('disabled','true');
        $('#form1save').attr('value','Loading...');
        return true;
    });
    $('#form1save').click(function(){
        $('#form1').submit();
    });


    var maxfileupload = 5;
    if($('#uploadedimages').val())
    {
        var images = JSON.parse($('#uploadedimages').val());
        maxfileupload = (maxfileupload-parseInt(images.length));
    }
    else
    {
        var images = [];
    }
    
    //console.log(images);
    var sitepath = $('#sitepath').val();
    
    $(".dropzone").dropzone({
        maxFiles: maxfileupload,
        dictDefaultMessage: "Drop Maximum 5 files here to upload",
        addRemoveLinks: true,
        dictRemoveFileConfirmation : "Do you really want to remove this image?",
        maxfilesexceeded: function(file) {
            //alert('Maximum 5 images can be uploaded.');
            $("#js-modal").modal('show');
            this.removeFile(file);
            //this.addFile(file);
        },
        init: function() { 
            var thisDropzone = this;
            $.each(images, function(key,value){ //loop through it
                //alert('here');
                var mockFile = { name: value }; // here we get the file name and size as response 
                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, sitepath+"uploads/agent_pictures/"+value);//uploadsfolder is the folder where you have all those uploaded files
            });
            this.on("success", function(file, response) {
                ///console.log('res',response);
                //$('.imageuploadhash').val(response.token);
                images.push(response.Filename);
                var myJsonString = JSON.stringify(images);
                $('#uploadedimages').val(myJsonString);

            });
            this.on("removedfile", function(file) {
                //alert(file.name);
                var newImahes = [];
                var newImages =  images.filter(function(val) {
                    return val != file.name;
                });
                var senddata = {
                    'filename': file.name,
                    'csrf_instantscouting_name': $('.imageuploadhash').val()
                };
                /*$.ajax({
                    'url': sitepath + 'agent/removePic',
                    'type': 'post',
                    'data': senddata,
                    'success': function(data){
                        console.log(data);
                    }
                });*/
                var myJsonString = JSON.stringify(newImages);
                $('#uploadedimages').val(myJsonString);
                
            });
            
        }
    });
    Dropzone.confirm = function(question, fnAccepted, rejected) {
        // Ask the question, and call accepted() or rejected() accordingly.
        // CAREFUL: rejected might not be defined. Do nothing in that case.
        removeCallback = fnAccepted;
        // launch your fancy bootstrap modal    
        $("#js-modal-delete").modal('show');
    };
    $("#js-remove").click(function() {
        if (removeCallback) {
          removeCallback();
        }
        $("#js-modal-delete").modal('hide');
    });
    function removeCallback(){
        //alert('remove');
    }
});