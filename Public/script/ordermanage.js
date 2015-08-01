$(function(){
    var status = $(".tab-div").attr("data-status");
    $(".tab-div > .button").removeClass("active");
    $(".tab-div > .button:eq("+(parseInt(status)-1)+")").addClass("active");
    $("#person-nav-side li").removeClass("active");
    $("#person-nav-side li:eq("+(parseInt(status)-1)+")").addClass("active");

    $(".tab-div > .button").click(function(){
        $(this).siblings().removeClass("active");
        $(this).addClass("active"); 

        // $("#person-nav-side li").removeClass("active");
        // var prevAll = $(this).prevAll();
        // $("#person-nav-side li:eq("+prevAll.length+")").addClass("active");

    });

    $("#person-nav-side li").click(function(){
    	$(this).siblings().removeClass("active");
    	$(this).addClass("active");

    	// $(".tab-div > .button").removeClass("active");
    	// var prevAll = $(this).prevAll();
    	// $(".tab-div > .button:eq("+(prevAll.length-1)+")").addClass("active");
    });

});

function getOrderList(){
	
}


