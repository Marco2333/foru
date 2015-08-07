$(function(){
    $('#slide-wrapper').carousel();
    
    // if ($.cookie("rmbUser") == "true") { 
    	
    // }
    if($.cookie('campusId')==null){
       $.cookie("campusId", 1, { expires: 7 });
    }
});
