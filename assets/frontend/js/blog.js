$(function () {
    var sitepath = $('#sitepath').val();
    //alert('kkkkk');
    $('#loadmoreblog').click(function(){
        $.ajax({
            url: $('#blogfrm').attr('action'),
            data: $('#blogfrm').serialize(),
            dataType: 'json', 
            type: 'post',
            beforeSend: function(){
                $("#loadmoreblog").html('Loading...');
                $("#loadmoreblog").attr('disabled',true);
            },
            success: function(data) {
                console.log(data);
                $('.csrftoken').attr('value',data.token);
                
                $.each(data.data.blog, function( index, value ) {
                    var indiblog = $('#blogthumb').html();
                    $('#blogStart').val(parseInt($('#blogStart').val())+parseInt($('#blogLimit').val()));
                    if(parseInt(data.data.totalrecord.totalrecord)<=parseInt($('#blogStart').val()))
                    {
                        $('#loadmoreblog').hide();
                    }
                    if(value.blogImage !='')
                    {
                        var img = ' src="'+sitepath+'uploads/images_blog/'+value.blogImage+'"';
                    }
                    indiblog = indiblog.replace("[BLOGSLUG]",value.blogSlug);
                    indiblog = indiblog.replace("[BLOGDATE]",value.adddateformat);
                    indiblog = indiblog.replace("[BLOGDESCRIPTION]",value.blogDescription.substring(0, 200)+'...');
                    indiblog = indiblog.replace(/blogname/g,value.blogName);
                    indiblog = indiblog.replace(/blogimage/g,img);
                    $('#blogul').append(indiblog);
                    $("#loadmoreblog").html('Load More Post');
                    $("#loadmoreblog").attr('disabled',false);
                });
                
            }             
        });
    });

    $('#loadmorecuratedcontentseller').click(function(){
        $.ajax({
            url: $('#blogfrm').attr('action'),
            data: $('#blogfrm').serialize(),
            dataType: 'json', 
            type: 'post',
            beforeSend: function(){
                $("#loadmorecuratedcontentseller").html('Loading...');
                $("#loadmorecuratedcontentseller").attr('disabled',true);
            },
            success: function(data) {
                console.log(data);
                $('.csrftoken').attr('value',data.token);
                
                $.each(data.data.record, function( index, value ) {
                    var indiblog = $('#blogthumb').html();
                    $('#blogStart').val(parseInt($('#blogStart').val())+parseInt($('#blogLimit').val()));
                    if(parseInt(data.data.totalrecord.totalrecord)<=parseInt($('#blogStart').val()))
                    {
                        $('#loadmorecuratedcontentseller').hide();
                    }
                    var imgArr = JSON.parse(value.image);
                    if(value.image !='')
                    {
                        var img = ' src="'+sitepath+'uploads/images_extra/'+imgArr[0]+'"';
                    }
                    indiblog = indiblog.replace("[BLOGSLUG]",value.title_slug);
                    indiblog = indiblog.replace("[BLOGDATE]",value.curatedDate);
                    indiblog = indiblog.replace("[BLOGDESCRIPTION]",value.description.substring(0, 2000)+'...');
                    indiblog = indiblog.replace(/blogname/g,value.title);
                    indiblog = indiblog.replace(/blogimage/g,img);
                    $('#blogul').append(indiblog);
                    $("#loadmorecuratedcontentseller").html('Load More Post');
                    $("#loadmorecuratedcontentseller").attr('disabled',false);
                });
                
            }             
        });
    });
});