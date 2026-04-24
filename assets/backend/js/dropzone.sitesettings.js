
var i = 0;
var sitepath = $('#sitepath').val();
var myDropzone = new Dropzone("div#homepagelogo", 
{ 
    url: sitepath+"administrator/site-settings/addhomepagelogo",
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    maxFiles: 1,
    init: function() {
        var thisDropzonebuyer = this;
        
        this.on("success", function(file, responseText) {
            file.previewElement.id = responseText;
            $('#homelogoimagefile').val(responseText);
        });
        this.on("removedfile", function(file, responseText) {
            //
            console.log(file.previewElement.id);
            var deletedfile = file.previewElement.id;
            $('#homelogoimagefile').val('');
        });
        this.on("maxfilesexceeded", function(file) {
            this.removeFile(file);
        });
    }
});

var myDropzone = new Dropzone("div#insidepagelogo", 
{ 
    url: sitepath+"administrator/site-settings/addinsidepagelogo",
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    maxFiles: 1,
    init: function() {
        var thisDropzoneseller = this;
       
        this.on("success", function(file, responseText) {
            
            file.previewElement.id = responseText;
            $('#insidelogoimagefile').val(responseText);
        });
        this.on("removedfile", function(file, responseText) {
            var deletedfile = file.previewElement.id;
            
            $('#insidelogoimagefile').val('');
        });
        this.on("maxfilesexceeded", function(file) {
            this.removeFile(file);
        });
    }
});
$('.change-home-logo').click(function(){
    $(this).hide()
    $('#home_logo').hide()
    $('#homepagelogo').css('display','block')
});
$('.change-inside-pic').click(function(){
    $(this).hide()
    $('#inside_logo').hide()
    $('#insidepagelogo').css('display','block')
});