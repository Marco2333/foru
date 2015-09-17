$(function(){

   if(screen.width < 700) {
    	window.location.href = "../../../../fuwebapp/index.php";
   }
   $('#slide-wrapper').carousel();
    
   $.get(
   		'/index.php/Home/Index/getCampus',
   		function(data){
           $.cookie("campusId", data.campusId, { expires: 7 });
   		}
   	);      
});
