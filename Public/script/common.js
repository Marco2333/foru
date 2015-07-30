$(document).ready(function(){
 
  $(".drop-down-left,.drop-down-layer").hover(function(){
      $(".drop-down-layer").show();
  },function(){
      $(".drop-down-layer").hide();  
  });

  $("#search").on('click',function(){
      $search = $("input[name='keyword']").val();
      if($search != ""){
          record = $.cookie("record");

          if(record == null) {
              var record = $search;
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
                  newrecord = newrecord.substr(newrecord.indexOf(",")+1);
              }
              $.cookie("record", newrecord);    
          } 
      }
      window.location.href="/foru/index.php/Home/Index/goodslist?search="+$search;
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

  $("#campus-location li").click(function(){

      var $city=$(this).attr('data-city');
      $.cookie("cityId", $city);

      $.post("/foru/index.php/Home/Index/getCampusByCity?cityId="+$city,
         {cityId:$city},
         function(data){

            var campusList = data.campus;
            $("#campus-content ul").empty();
            for(var i=0;i<campusList.length;i++){
                // console.log("cookie:campusId"+$.cookie('campusId'));
                //$("#campus-content ul").append('<empty name="Think.cookie.campusId"><assign name="Think.cookie.campusId" value="1"/></empty><if condition="$vo.campus_id eq cookie('+"campusId"+')"><li data-campusId="'+campusList[i].campus_id+'" class="active">'+campusList[i].campus_name+'</li><else/><li data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li></if>');
                if(campusList.campus_id == $.cookie('campusId')){
                    $("#campus-content ul").append('<li class="active" data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                }else{
                    if(i==0){
                        $("#campus-content ul").append('<li class="active" data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                    }else{
                        $("#campus-content ul").append('<li data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                    }
                } 
                 
                $("#campus-content li").on('click',function(){

                     $(this).siblings().removeClass("active");
                     $(this).addClass("active");

                     var $campusId = $(this).attr('data-campusId');
                     $.cookie("campusId", $campusId);
                     $("#location").text($(this).text());
                }); 
            }         
        });
    });


    $("#campus-content ul li").click(function(){
         var $campusId=$(this).attr('data-campusId');
         $.cookie("campusId", $campusId);
         // console.log($campusId);
    });

    $("input[name='keyword']").on('keydown',function(e){
        if(e.keyCode==13){

          $search=$("input[name='keyword']").val();

          if($search != null && $search != ""){
              record = $.cookie("record");
              if(record == null) {
                  var record = $search;
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
                      newrecord = newrecord.substr(newrecord.indexOf(",")+1);
                  }
                  // record[record.length] = $search;
                  $.cookie("record", newrecord);  
              } 
              window.location.href="/foru/index.php/Home/Index/goodslist?search="+$search;
          }
        }
    });

    $("#location").bind("click",function(){

        $("#campus-background").show(300);

        var $city = $("#campus-location li.active").attr('data-city');
        
        $.cookie("cityId", $city);

        $.post("/foru/index.php/Home/Index/getCampusByCity?cityId="+$city,
          {cityId:$city},
          function(data){

              var campusList = data.campus;
              $("#campus-content ul").empty();
              var flag = false;
              for(var i=0;i<campusList.length;i++){
                  if(campusList[i].campus_id == $.cookie('campusId')){
                      flag = true;
                      $("#campus-content ul").append('<li class="active" data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                  }else{
                      $("#campus-content ul").append('<li data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                  }
              }
              if(flag == false) {
                  $("#campus-content li").first().addClass("active");
              }
                 
              $("#campus-content li").on('click',function(){

                   $(this).siblings().removeClass("active");
                   $(this).addClass("active");

                   var $campusId = $(this).attr('data-campusId');
                   $.cookie("campusId", $campusId);
                   $("#location").text($(this).text());
              }); 
         });         
    });

    $("#campus-main li").click(function(){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
    });

    $("#campus-content li").click(function(){
        $("#location").text($(this).text());
        var $campusId = $(this).attr('data-campusId');
        $.cookie("campusId", $campusId);
    });

    $("#campus-close").bind("click",function(){
        var campus_id = $("#campus-content li.active").attr("data-campusId");
        if(campus_id != null) {
             window.location.href="/foru/index.php/Home/Index/index?campusId="+campus_id;
             $("#location").text($("#campus-content li.active").text());
        }
        $("#campus-background").hide(300);    
    });

    $('#campus-search').bind('input propertychange', function() {

        var searchValue = $("#campus-search").val();

        // if(searchValue == ""){
        //     return;
        // }

        $("#campus-location li").removeClass("active");
        $("#campus-content ul").empty();

        $.ajax({
            type:"POST",
            url:"/foru/index.php/Home/Index/searchCampus",
            data:{
              name:searchValue
            },
            success:function(data){
                if(data.status=='failure') {
                    return;
                }
                else {
                  var campusList = data.campus;
                  for(var i=0;i<campusList.length;i++){
                      $("#campus-content ul").append('<li data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                  }

                  $("#campus-content li").click(function(){
                      $("#location").text($(this).text());
                      $(this).siblings.removeClass("active");
                      $(this).addClass("active");
                      var $campusId = $(this).attr('data-campusId');
                      $.cookie("campusId", $campusId);
                  });
               }  
            }
        });
    }); 

});


String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, '');
}
