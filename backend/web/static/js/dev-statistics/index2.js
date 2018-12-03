
if(role_id!=1&&LoginName!='admin'){
    LoginObj = {
      role_id:role_id,
      LoginName:LoginName
    }
}

 // 同期

      $.get('./index.php?r=dev-statistics/sales-detail',LoginObj, function(data) {
         // console.log('同期参数')
         // console.log(LoginObj)
        /*optional stuff to do after success */
        // console.log(data)
      // layer.close(ii)  
        if(data){
          var data=JSON.parse(data) ;  //返回一个新对象
         // console.log(data);
              $("#dev_register").text(data.dev_register);
               $("#dev_init").text(data.dev_init);
             $("#dev_growth").text((data.dev_register-data.dev_init)>0?(data.dev_register-data.dev_init):0);
               $("#dev_total").text(data.dev_total);
              $("#add_today").html(percenttage(data.add_today,data.add_yesterday));
              $("#add_seven_days").html(percenttage(data.add_seven_days,data.add_fourteen_days));
              $("#add_thirty_days").html(percenttage(data.add_thirty_days,data.add_sixty_days));
              $("#init_today").html(percenttage(data.init_today,data.init_yesterday));
              $("#init_seven_days").html(percenttage(data.init_seven_days,data.init_fourteen_days));
              $("#init_thirty_days").html(percenttage(data.init_thirty_days,data.init_sixty_days));
               $("#add_today_today").html(percenttage(data.add_today-data.init_today,data.add_yesterday-data.init_yesterday));
               $("#add_seven_days_days").html(percenttage(data.add_seven_days-data.init_seven_days,data.add_fourteen_days-data.init_fourteen_days));
               $("#add_thirty_days_days").html(percenttage(data.add_thirty_days-data.init_thirty_days,data.add_sixty_days-data.init_sixty_days));
        }
      });
$("#IsTurnOut").change(function(){
    var  startDate_this = $(this).val();
        if(startDate_this==1){
           $("#time1sub").val(GetDateStr(0,1))
           $("#time2sub").val(GetDateStr(0,1))   
        }else if(startDate_this==2){
           $("#time1sub").val(GetDateStr(-6,1))
           $("#time2sub").val(GetDateStr(0,1))   
        }else if(startDate_this==3){
           $("#time1sub").val(GetDateStr(-29,1))
           $("#time2sub").val(GetDateStr(0,1))   
        }else{
           $("#time1sub").val(GetDateStr(-6,1))
           $("#time2sub").val(GetDateStr(0,1)) 
        }
        $("#date_demo").text('请选择时间段')
salesDetailLine()
})
$("#dev_state").change(function(){
    salesDetailLine()
});
var appendfIsTurnOut =this;
   this.IsTurnOut=$("#IsTurnOut");
$("#dev_state").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
$("#IsTurnOut").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen

$("#removerSub").click(function() {
      // $("#adddate").val('')
     $("#search").val('')

        $("#time1sub2").val(GetDateStr(-6,1))
        $("#time2sub2").val( GetDateStr(-0,1))
       // $('.dataUlLI .activer').removeClass('activer');  
       // $('.dataUlLI li').eq(2).addClass('activer');  
      $("#date_demo2").text('请选择时间段')
})





$(document).on('click',".connect",function(){
  var ii= layer.msg("加载中……");
   var sort_this = Number($(this).attr('date')) ;
   var sort_text = $(this).text() ;
  // alert(sort_text)
      sort_this++
      if(sort_this>2){
        sort_this=1
      }
      $(".connect").attr('date',sort_this);
     console.log( Number($(this).attr('date')) )


    var obj={
      starttime:$("#time1sub2").val(),
      endtime:$("#time2sub2").val(),
      search:$("#search").val(),
      column:'ActiveTime',
      role_id: LoginObj.role_id,
      LoginName: LoginObj.LoginName,
      sort:sort_this,
   }


     rendering(obj);

})


salesDetailLine()


function salesDetailLine(){
  var obj ={
     starttime:$("#time1sub").val(),
     endtime:$("#time2sub").val(),
     dev_state:$("#dev_state").val(),
      role_id: LoginObj.role_id,
      LoginName: LoginObj.LoginName,
  }
 

// 图标接口
  $.get('./index.php?r=dev-statistics/sales-detail-line',obj, function(data) {
    /*optional stuff to do after success */
       // console.log('图表参数')
       // console.log(obj)
         var dataArr = data.line_datas;
           if($("#dev_state").val()==3){
              // 当有注销设备的时候
               if(dataArr.init.length){
                   // dataArr=dataArr.init;
                   dataArr= arrayObjUnique(dataArr.add,dataArr.init)
               }else{
                 dataArr=dataArr.add;
               }
           }
         // console.log(dataArr)
         javaData(dataArr)
   });
}

console.log(LoginObj)
  var obj={
      starttime:$("#time1sub2").val(),
      endtime:$("#time2sub2").val(),
      search:$("#search").val(),
      sort:$(".connect").attr('date'),
      column:'ActiveTime',
      role_id: LoginObj.role_id,
     LoginName: LoginObj.LoginName,
   }


rendering(obj);
renderingTotal(obj)
$("#submit").click(function(){
  // alert($(".connect").attr('date'))
   var obj={
      starttime:$("#time1sub2").val(),
      endtime:$("#time2sub2").val(),
      search:$("#search").val(),
      sort:$(".connect").attr('date'),
      role_id: LoginObj.role_id,
      LoginName: LoginObj.LoginName,
      column:$(".navdata").attr('column')
   }
   console.log(obj)
   rendering(obj)
   renderingTotal(obj)
})
function   renderingTotal(parameter){
      $.ajax
       ({cache: false,
           async: false,
           type: 'post',
           data:parameter,
           url: "./?r=dev-statistics/get-user",
           success: function (data) {
             // console.log('表格参数')
             // console.log(parameter)
                 var objdata = JSON.parse(data);
              
                 total=objdata.total*1;
                  paging({
                      pageNo: 1,
                      totalPage: Math.ceil(total / 10),
                      totalLimit: 10,
                      totalSize: total,
                      callback: function(num, nbsp) {
                            var obj={
                                starttime:$("#time1sub2").val(),
                                endtime:$("#time2sub2").val(),
                                search:$("#search").val(),
                                sort:$(".connect").attr('date'),
                                column:$(".navdata").attr('column'),
                                offset: num * nbsp - nbsp,
                                limit: nbsp,
                                role_id: LoginObj.role_id,
                                LoginName: LoginObj.LoginName,
                             }

                               // console.log(parameter)
                               rendering(obj)
                      }
                })
    
           }
       });
};

function   rendering(parameter){
// console.log(parameter)
       var ii= layer.msg("加载中……");
      $.ajax
          ({
           cache: false,
           async: false,
           type: 'post',
           data:parameter,
          url: "./?r=dev-statistics/get-user",
           success: function (data) {
                layer.close(ii)  
                 var objdata = JSON.parse(data);
                 console.log(objdata)
                 total=objdata.total*1;
                 dev_listdata(objdata.users,objdata.all_use_type)
           }
       });
}


function  dev_listdata(data,use_type){
  // console.log(use_type)
function custType(Type) {
    // console.log(Type)
  // var CustomerType;
  if (Type == 1) {
    Type= '家庭';
  } else if (Type == 2) {
    Type = '办公';
  } else if (Type == 3) {
    Type= '集团';
  } else if (Type == 4) {
    Type= '酒店';
  } else if (Type == 99) {
    Type = '其他';
  }else{
    Type ==Type
  }
      // console.log(CustomerType)  
   return Type;
}

// alert(4)


function head_Arr(){

    var connect_date = $(".connect").attr('date')||2;
    var tableTheadOneData   =['序号','用户姓名','联系电话','设备编号','设备商品型号','设备品牌','地址','购水套餐','用户类型','激活时间'];
    var tableTheadTwoData   =['序号','用户姓名','联系电话','设备编号','设备商品型号','设备品牌','服务中心','购水套餐','用户类型','激活时间'];
    var tableTheadThreeData =['序号','用户姓名','联系电话','设备编号','设备商品型号','设备品牌','运营中心','用户类型','激活时间'];
    var tableTheadFourData = ['序号','用户姓名','联系电话','设备编号','设备商品型号','设备品牌','运营中心','用户类型','激活时间'];
    var tableTheadFiveData = ['序号','设备投资商','联系电话','设备编号','设备商品型号','设备品牌','地址','购水套餐','激活时间'];
    var tableTheadSixData =  ['序号','用户姓名','联系电话','设备编号','设备商品型号','设备品牌','服务中心','入网属性','用户类型','激活时间'];
    var tableTheadSevenData =['序号','片区中心','联系电话','地区','家庭用户','公司用户','集团用户','其它','酒店','总设备数'];
  var tableThead=tableTheadOneData;
  if(role_id==5){
    tableThead=tableTheadOneData;
  }else if(role_id==3||role_id==7){
    tableThead=tableTheadTwoData;
  }else if(role_id==4||role_id==6){
    tableThead=tableTheadThreeData;
  }
  else if(role_id==10){
    tableThead=tableTheadFiveData;
  }

  var html = ' <tr>';
// console.log(tableThead)

   for(var y=0;y<tableThead.length;y++){
       var head_item = tableThead[y];
       // console.log(head_item)
          if(role_id){
             if(y>=tableThead.length-1){
                 html+='<th ><a href="javascript:void(0)"><p class="connect"  date="'+connect_date+'">'+head_item+'<p></a></th>';
             }else{
               html+='<th ><p>'+head_item+'<p></th>';
             }
          }
   }

    html+='</tr>';

    console.log(role_id)
$("#table thead").html(html);

}

function use_typeArr(type,use_type){
    var use_typeObj=''
     for(var j=0;j<use_type.length;j++){

      // console.log(use_type[j].code)
        if(type==use_type[j].code){
            use_typeObj=use_type[j].use_type;
            break
        }
     }

return use_typeObj;

}


head_Arr()

$("#tableBoxData").empty();


       for(var i=0;i<data.length;i++){
         var item = data[i];
        for (var z in item) {
                if (item[z] == null) {
                  item[z] = '--'
                }
              }
       var CustomerType = custType(item.CustomerType);
           var bodyHtml = ' <tr>';
             bodyHtml += '<td>'+(i+1)+'</td>';
               bodyHtml += '<td>'+item.Name +'</td>';  
               bodyHtml += '<td>'+item.Tel +'</td>';  
               bodyHtml += '<td>'+item.DevNo +'</td>';  
               bodyHtml += '<td>'+item.GoodsName +'</td>';  
               bodyHtml += '<td>'+item.BrandName +'</td>';

               if(role_id==5||role_id==10){
                 bodyHtml += '<td>'+item.Address+'</td>'; 
               }else if(role_id==3||role_id==7){
                  bodyHtml += '<td>'+item.agentFname +'</td>'; 
               }else if(role_id==4||role_id==6){
                  bodyHtml += '<td>'+item.agentYname +'</td>'; 
               }
              
                if(role_id==5||role_id==3||role_id==10||role_id==7){
                    bodyHtml += '<td>'+ use_typeArr(item.UseType,use_type)+'</td>';
                }
             
               if(role_id!=10){
                   bodyHtml += '<td>'+CustomerType +'</td>'; 
               }
                     


               bodyHtml += '<td>'+item.ActiveTime +'</td>';  



               bodyHtml += '</tr>';
            $("#tableBoxData").append(bodyHtml)

       }



}