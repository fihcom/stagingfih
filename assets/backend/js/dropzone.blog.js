
var fileArr = [];
var i = 0;
var sitepath = $('#sitepath').val();
var blogimgDropzone = new Dropzone("div#blogimg", 
{ 
    url: sitepath+"administrator/blogs/addimage",
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    maxFiles: 1,
    init: function() {
        var thisDropzone = this;
        $.each(images, function(key,value){ //loop through it
            //alert('here');
            fileArr.push(value);
            var mockFile = { name: value }; // here we get the file name and size as response 
            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, sitepath+"uploads/images_blog/"+value);//uploadsfolder is the folder where you have all those uploaded files
        });
        if(fileArr.length >0)
        {
            $('#imageContents').val(fileArr);
        }
        this.on("success", function(file, responseText) {
            file.previewElement.id = responseText;
            fileArr.push(responseText);
            //fileArr[file] = responseText;
            $('#imageContents').val(fileArr);
            //console.log(fileArr);
        });
        this.on("removedfile", function(file, responseText) {
            //
            var deletedfile = file.previewElement.id;
            console.log(deletedfile);
            var i = 0
            while(i<fileArr.length)
            {
                if(fileArr[i] == deletedfile)
                {
                    fileArr.splice(i,1);
                }
                i++
            }
            $('#imageContents').val(fileArr);
            
        });
        this.on("maxfilesexceeded", function(file) {
            
            this.removeFile(file);
        });
    }
});

