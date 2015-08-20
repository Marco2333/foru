//  调用PersonController

$(function(){
    $("#tab-1").click(function(){
        $("#tab-1").addClass("active");
        $("#tab-2").removeClass("active");
        $("#person-basic-info").removeClass("none");
        $("#change-image-wrapper").addClass("none");
        
    });

    $("#tab-2").click(function(){
        $("#tab-2").addClass("active");
        $("#tab-1").removeClass("active"); 
        $("#change-image-wrapper").removeClass("none");
        $("#person-basic-info").addClass("none"); 
    });
})

function savePersonInfo(){
    // var nickname = document.getElementById('nickname');
    // // var usersex  = document.getElementById('');
    // var academy  = document.getElementById('academy');
    // var qq       = document.getElementById('qq');
    // var winxin   = document.getElementById('weixin');

    var usersex = 0;
    var checkObj = document.getElementsByName("user-sex");
    if (checkObj[1].checked)
    {
        usersex = 1;
    }

    var info = {
        nickname:$("#nickname").val(),
        usersex:usersex,
        academy:$("#academy").val(),
        qq:$("#qq").val(),
        weixin:$("#weixin").val()
    };

    $.ajax({
        type:"POST",
        url:savePersonInfoUrl,
        data:info,
        success:function(data){
            if (data['result'] != 0)
            {
               $('#info').show();
               $('#info').html("保存个人信息成功");
               setTimeout("$('#info').hide()", 2000 );
            }
            else
            {
               $('#info').show();
               $('#info').html("保存个人信息失败");
               setTimeout("$('#info').hide()", 2000 );
            }
            
        }
    })
}

function updateImg(file)
{
    var MAXWIDTH  = 260; 
    var MAXHEIGHT = 180;
    var div = document.getElementById('preview');
    var smallDiv=document.getElementById('smallPreview');

    if (file.files && file.files[0])
    {
        div.innerHTML ='<img id=presentimg>';
        smallDiv.innerHtml='<img id=previewimg>';
        var img = document.getElementById('presentimg');
        var smallImg=document.getElementById('previewimg');

        img.onload = function(){
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            img.width  =  rect.width;
            img.height =  rect.height;
            // img.style.marginLeft = rect.left+'px';
            img.style.marginTop = rect.top+'px';
        }

        smallImg.load = function(){
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            img.width  =  rect.width;
            img.height =  rect.height;
            // img.style.marginLeft = rect.left+'px';
            img.style.marginTop = rect.top+'px';
        }

        var reader = new FileReader();
        reader.onload = function(evt){img.src = evt.target.result; smallImg.src=img.src}
        reader.readAsDataURL(file.files[0]);
    }
    else //兼容IE
    {
        var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
        file.select();
        var src = document.selection.createRange().text;
        div.innerHTML = '<img id=presentimg>';
        smallDiv.innerHtml='<img id=previewimg>';
        var img = document.getElementById('presentimg');
        var smallImg=document.getElementById('previewimg');

        img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
        div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";

        smallImg.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, smallImg.offsetWidth, smallImg.offsetHeight);
        status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
        div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
    }
}

function clacImgZoomParam( maxWidth, maxHeight, width, height ){
    var param = {top:0, left:0, width:width, height:height};
    if( width>maxWidth || height>maxHeight )
    {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;

        if( rateWidth > rateHeight )
        {
            param.width =  maxWidth;
            param.height = Math.round(height / rateWidth);
        }
        else
        {
            param.width = Math.round(width / rateHeight);
            param.height = maxHeight;
        }
    }

    param.left = Math.round((maxWidth - param.width) / 2);
    param.top = Math.round((maxHeight - param.height) / 2);

    return param;
}

