$(function(){
    $(".drop-down-left,.drop-down-layer").hover(function(){
        $(".drop-down-layer").show();
    },function(){
        $(".drop-down-layer").hide();  
    });
    $("#search").on('click',function(){

    		$search = $("input[name='keyword']").val();

        if($search != "" ) {

          record = $.cookie("record");
          if(record == null) {
             
              var record = $search;
              
              // var recordString = JSON.stringify(record); //JSON 数据转化成字符串

              $.cookie("record", record);
          }
          else {
              // alert("not null");
              // var newrecord = JSON.parse(myCookie); //字符串转化成JSON数据
              
              var recordList = record.split(",");
              var newrecord = "";
              for(var i=0;i<recordList.length;i++){
                if(recordList[i] != $search.trim()){
                  newrecord += recordList[i] + ",";
                }
              }
              newrecord += $search.trim();
            
              recordList = newrecord.split(",");
              if(recordList.length > 6){                  
                  // newrecord = "";
                  // for(var i=1;i<recordList.length;i++){

                  // }
                  newrecord = newrecord.substr(newrecord.indexOf(",")+1);
              }
              // record[record.length] = $search;
              $.cookie("record", newrecord);    
          } 
        }
    		window.location.href="/foryou/index.php/Home/Index/goodslist?search="+$search;
    });
    
    $("#search-record li").click(function(){
        alert("dd");
        // $("#header-search input").val($(this).text());
    });
    
    $("#header-search input").focus(function(){
        record = $.cookie("record");

        if(record != null){

          var recordList = record.split(",");

          $("#search-record option").remove();
          for(var i = recordList.length-1;i>=0;i--){
            $("<option>").val(recordList[i]).appendTo( $("#search-record"));
          } 
        }

    });

    // $(".rm-record").click(function(){
    //      alert("dd");
    //      $.cookie("record", "",{ expires: -1});
    //      $("#search-record option").remove();
    // });

    // $("#search-record").focus(function(){
    //       $("#search-record").removeClass("height-none");
    // });
    // $("#search-record").blur(function(){
    //     alert("c");
    //      $("#search-record").addClass("height-none");
    // });
    // $("#search-record").mousedown(function(){
    //      // alert("d");
    //      $("#search-record").removeClass("height-none");
    // });

     // $('p').mousedown(function(){
     //            alert('mousedown function is running !');
     //          });
    // $("#header-search input").blur(function(){
    //      var act = document.activeElement;
    //      console.log(act);
    //      // if(act != "search-record"){
    //      //      $("#search-record").addClass("height-none");
    //      // }
    // });

     $("#location").change(function(){
         var $campusId=$(this).children('option:selected').val();
         $.cookie("campusId", $campusId,{ expires: 7 });
         window.location.reload();
     });

     $("input[name='keyword']").on('keydown',function(e){
       if(e.keyCode==13){
          $search=$("input[name='keyword']").val();

          if($search != null && $search != ""){

            record = $.cookie("record");
            if(record == null) {
               
                var record = $search;
                
                // var recordString = JSON.stringify(record); //JSON 数据转化成字符串

                $.cookie("record", record);
            }
            else {
                var recordList = record.split(",");
                var newrecord = "";
                for(var i=0;i<recordList.length;i++){
                  if(recordList[i] != $search.trim()){
                    newrecord += recordList[i] + ",";
                  }
                }
                newrecord += $search.trim();
              
                recordList = newrecord.split(",");
                if(recordList.length > 6){                  
                    // newrecord = "";
                    // for(var i=1;i<recordList.length;i++){

                    // }
                    newrecord = newrecord.substr(newrecord.indexOf(",")+1);
                }
                // record[record.length] = $search;
                $.cookie("record", newrecord);  
            } 
            window.location.href="/foryou/index.php/Home/Index/goodslist?search="+$search;
          }
        }
     });
})
String.prototype.trim = function() {
	   return this.replace(/(^\s*)|(\s*$)/g, '');
}
