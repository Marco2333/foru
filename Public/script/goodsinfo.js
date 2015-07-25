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
});
