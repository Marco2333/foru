$(function(){
    $('#slide-wrapper').carousel();
    
    if($.cookie('campusId')==null){
       $.cookie("campusId", 1, { expires: 7 });
    }
});
