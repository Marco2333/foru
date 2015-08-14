$(document).ready(function(){
    $(".img-and-detailed-body a.sub-goods").click(function(){
        var v=$(this).next("input").val();
        if(parseInt(v)!=0){
            $(this).next("input").val(parseInt(v)-1);
        }    
    });

    $(".img-and-detailed-body a.add-goods").click(function(){
        var v=$(this).prev("input").val();
        $(this).prev("input").val(parseInt(v)+1); 
    });
    $(".img-and-evaluate-head li").click(function(){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
    });
    $(".img-and-evaluate-head li").first().click(function(){
        $("#goods-img-detailed").removeClass("none");
        $("#evaluate-body").addClass("none");
    });
    $(".img-and-evaluate-head li").last().click(function(){
        $("#goods-img-detailed").addClass("none");
        $("#evaluate-body").removeClass("none");
    });
    $(".goods-info-img .left-pointer").click(function(){

        var liList = $("#good-info-slide ul li");
        if(parseInt($(this).nextAll("input.none").val())+liList.length*78>314){
            var leftValue = parseInt($(this).nextAll("input.none").val())-78; 
            $(this).nextAll("input.none").val(leftValue);
            $("#good-info-slide ul").css("left",leftValue+"px");  

            $(".goods-info-img .right-pointer").removeClass("inactive-pointer");  
        }
        
        if(parseInt($(this).nextAll("input.none").val())+liList.length*78<=314){
            $(this).addClass("inactive-pointer");
        }
        else{
             $(this).addClass("inactive-pointer");
        }

        // alert(parseInt(left.substr(0,left.length-2)));
        // $("#good-info-slide ul").css("left",parseInt(left.substr(0,left.length-2))-78+"px");
    });

    $(".goods-info-img .right-pointer").click(function(){
        // var left = $("#good-info-slide ul").css("left");
        if(parseInt($(this).nextAll("input.none").val())<0){
            var leftValue = parseInt($(this).nextAll("input.none").val())+78; 
            $(this).nextAll("input.none").val(leftValue);
            // alert(parseInt(left.substr(0,left.length-2)));
            $("#good-info-slide ul").css("left",leftValue+"px");
     
            $(".goods-info-img .left-pointer").removeClass("inactive-pointer");
        }
        if(parseInt($(this).nextAll("input.none").val())>=0){
             $(this).addClass("inactive-pointer");
        }
    });

    $("#good-info-slide li").click(function(){
        $(".goods-info-img dt img").attr("src",$(this)
            .children("img").first().attr("src"));
    });

    $(".put-cart").click(function(){
        var info = {
            campusId:$("#campusId-none").val(),
            foodId:$("#foodId-none").val(),
            count:$("#goods-count").val()
        };

        $.ajax({
            type:"POST",
            url:"../../../../../../Home/Index/getSessionPhone",
            success:function(res){
               if(res.status != "success"){
                   window.location.href="../../../../../../Home/Login/index";
               }else{
                    $.ajax({
                        type:"POST",
                        url:"../../../../../../Home/Index/addToShoppingCar",
                        data:info,
                        success:function(res){
                            if (res['result'] != 0)
                            {
                                 var offset = $("#shopping-cart").offset();
                                 var img = $(".put-cart").parents(".goods-info-index")
                                 .children(".goods-info-img").find('img').attr('src');
                                 var flyer = $('<img class="u-flyer" src="' + img + '">');
                                 flyer.fly({
                                     start : {
                                          left : $(".goods-info-img img").first().offset().top, //开始位置（必填）#fly元素会被设置成position: fixed
                                          top : $(".goods-info-img img").first().offset().left //开始位置（必填）
                                      },
                                      end : {
                                          left : offset.left + 10, //结束位置（必填）
                                          top : offset.top + 10, //结束位置（必填）
                                          width : 0, //结束时宽度
                                          height : 0 //结束时高度
                                      },
                                      onEnd : function() {//结束回调
                                          $(this).remove();
                                      }
                                 });
                            }
                            else
                            {
                                alert("您的宝贝加入购物车失败！");
                            }
                        }
                    });
               }
            }
        });
    });

    $(".buy-now").click(function(){
        var info = {
            campusId:$("#campusId-none").val(),
            foodId:$("#foodId-none").val(),
            count:$("#goods-count").val()
        };

        $.ajax({
            type:"POST",
            url:"../../../../../../Home/Index/getSessionPhone",
            success:function(res){
               if(res.status != "success"){
                   window.location.href="../../../../../../Home/Login/index";
               }else{
                   $.ajax({
                       type:"POST",
                       url:"../../../../../../Home/Index/payNow",
                       data:info,
                       success:function(data){
                           if (data['result'] != 0)
                           {
                               window.location.href="../../../../../../Home/Person/goodsPayment?orderIds="+data['ordersId']+"&campusId="+$.cookie('campusId');
                           }
                           else
                           {
                               alert("网络不给力啊！");
                           }
                       }
                   })
               }
           }
       });
       
    });

    $(".put-cart").click(function() {
  
    });
});