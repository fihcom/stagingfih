var fileArr = [];
var fileArrSeller = [];
var fileArrGeneral = [];

var i = 0;
var sitepath = $('#sitepath').val();
var myDropzone = new Dropzone("div#buyer", 
{ 
    url: sitepath+"administrator/homecontents/addimage",
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    maxFiles: 1,
    init: function() {
        var thisDropzonebuyer = this;
        /*var imageContentsBuyer = $('#imageContentsBuyer').val(); 
        if(imageContentsBuyer !='')
        {
            //file.previewElement.id = imageContentsBuyer;
            fileArr.push(imageContentsBuyer);
            var mockFile = { name: imageContentsBuyer }; // here we get the file name and size as response 
            thisDropzonebuyer.options.addedfile.call(thisDropzonebuyer, mockFile);
            thisDropzonebuyer.options.thumbnail.call(thisDropzonebuyer, mockFile, sitepath+"uploads/images_extra/"+imageContentsBuyer);//uploadsfolder is the folder where you have all those uploaded files
        }
        if(fileArr.length >0)
        {
            $('#imageContentsBuyer').val(fileArr);
        }*/
        this.on("success", function(file, responseText) {
            
            file.previewElement.id = responseText;
            fileArr.push(responseText);
            $('#imageContentsBuyer').val(fileArr);
        });
        this.on("removedfile", function(file, responseText) {
            //
            
            var deletedfile = file.previewElement.id;
            var i = 0
            while(i<fileArr.length)
            {
                if(fileArr[i] == deletedfile)
                {
                    fileArr.splice(i,1);
                }
                i++
            }
            $('#imageContentsBuyer').val(fileArr);
        });
        this.on("maxfilesexceeded", function(file) {
            //alert('buy');
            this.removeFile(file);
        });
    }
});

var myDropzone = new Dropzone("div#seller", 
{ 
    url: sitepath+"administrator/homecontents/addimage",
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    maxFiles: 1,
    init: function() {
        var thisDropzoneseller = this;
        /*var imageContentsSeller = $('#imageContentsSeller').val();
        if(imageContentsSeller !='')
        {
            fileArrSeller.push(imageContentsSeller);
            var mockFile = { name: imageContentsSeller }; // here we get the file name and size as response 
            thisDropzoneseller.options.addedfile.call(thisDropzoneseller, mockFile);
            thisDropzoneseller.options.thumbnail.call(thisDropzoneseller, mockFile, sitepath+"uploads/images_extra/"+imageContentsSeller);//uploadsfolder is the folder where you have all those uploaded files
        }
        if(fileArrSeller.length >0)
        {
            $('#imageContentsSeller').val(fileArrSeller);
        }*/
        this.on("success", function(file, responseText) {
            
            file.previewElement.id = responseText;
            fileArrSeller.push(responseText);
            $('#imageContentsSeller').val(fileArrSeller);
        });
        this.on("removedfile", function(file, responseText) {
            //
            var deletedfile = file.previewElement.id;
            //alert(deletedfile);
            var i = 0
            while(i<fileArrSeller.length)
            {
                if(fileArrSeller[i] == deletedfile)
                {
                    fileArrSeller.splice(i,1);
                }
                i++
            }
            $('#imageContentsSeller').val(fileArrSeller);
        });
        this.on("maxfilesexceeded", function(file) {
            ///alert('sell');
            this.removeFile(file);
        });
    }
});

var myDropzone = new Dropzone("div#general", 
{ 
    url: sitepath+"administrator/homecontents/addimage",
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    maxFiles: 1,
    init: function() {
        var thisDropzonegen = this;
        /*var imageContentsSeller = $('#imageContentsGeneral').val();
        if(imageContentsSeller !='')
        {
            fileArrGeneral.push(imageContentsSeller);
            var mockFile = { name: imageContentsSeller }; // here we get the file name and size as response 
            thisDropzonegen.options.addedfile.call(thisDropzonegen, mockFile);
            thisDropzonegen.options.thumbnail.call(thisDropzonegen, mockFile, sitepath+"uploads/images_extra/"+imageContentsSeller);//uploadsfolder is the folder where you have all those uploaded files
        }
        if(fileArrGeneral.length >0)
        {
            $('#imageContentsGeneral').val(fileArrGeneral);
        }*/
        this.on("success", function(file, responseText) {
            
            file.previewElement.id = responseText;
            fileArrGeneral.push(responseText);
            $('#imageContentsGeneral').val(fileArrGeneral);
        });
        this.on("removedfile", function(file, responseText) {
            //
            var deletedfile = file.previewElement.id;
            var i = 0
            while(i<fileArrGeneral.length)
            {
                if(fileArrGeneral[i] == deletedfile)
                {
                    fileArrGeneral.splice(i,1);
                }
                i++
            }
            $('#imageContentsGeneral').val(fileArrGeneral);
        });
        this.on("maxfilesexceeded", function(file) {
            //alert('general');
            this.removeFile(file);
        });
    }
});

$('.addbuyerstepbtn').click(function(){
    var buyerstepskeleton = $('#buyerstepskeleton').html();
    $('.buyersteps').append(buyerstepskeleton);
});

$('.addsellerstepbtn').click(function(){
    var sellerstepskeleton = $('#sellerstepskeleton').html();
    $('.sellersteps').append(sellerstepskeleton);
});
$('.addgeneralstepbtn').click(function(){
    var generalstepskeleton = $('#generalstepskeleton').html();
    $('.generalsteps').append(generalstepskeleton);
});

console.log(fileArr);
console.log(fileArrSeller);



