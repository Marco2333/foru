$(function(){
    $('#slide-wrapper').carousel();
    
   $.get(
   		'/index.php/Home/Index/getCampus',
   		function(data){
           $.cookie("campusId", data.campusId, { expires: 7 });
   		}
   	);      
});
