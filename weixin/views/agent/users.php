<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/static/css/common.css" />
    <link rel="stylesheet" href="/static/css/coderlu.css?v=1.1"/>
    <title>用户</title>
    <style>
    body,html{
       background-color: #fff
    }
      
          .table-hr{
          border-bottom:1px solid #f3f3f3;
          position: fixed;
          width: 100%;
          top: 0;    
          font-weight: bold;    background: #fff;
          z-index: 998;
              padding-right: 10px;
        /*      background: #f3f3f3 url('/static/images2/163463112660427649.png') no-repeat;
      background-position: 100% ;
      background-size: 100% 140px;*/
          }
          .search{
          text-align: center;padding:10px;height: 50px;position: relative;
          }
          .search .img_btn{
          position: absolute;    padding: 0 5px;
          box-sizing: border-box;
          }
          .search .img_btn p{
          width: 200px;
          position: absolute;
          right: 0;
          background: #fff;
          text-align: left;
          font-size: 14px;
          font-weight: 400;
          line-height: 21px;
          padding: 5px;top: 40px;
          border-radius: 5px;    z-index: 14;
          border: 1px solid #000;    display: none
          }
          .table_tr{
          position: relative;
          }
          .center{
          display: inline-block;width: 100%;
          }
     
          .search .img_btn p>span{
              position: absolute;
              right: 10px;
              top: -10px;
              width: 0;
              height: 0;
              border-left: 7px solid transparent;
              border-right: 7px solid transparent;
              border-bottom: 10px solid #000;  z-index: 15;
          }
          .search input {
              /* height: 30px; */
              border-radius: 17px;
              text-indent: 20px;
              outline: none;
              border: none;
              width: 60%;
              font-size: 12px;
              text-align: center;
              padding-right: 10px;
              background: #f3f3f3;
              height: 25px;
              line-height: 25px;
          }
          .search .inputP{
              position: absolute;
              width: 56%;
              /* padding: 0 10px; */
              /* margin: auto; */
              left: 50%;
              /* padding-right: 17px; */
              top: 15px;
              margin-left: -27%;
              font-size: 12px;font-weight: 400;
              overflow: hidden;
          }
          .search .inputP img{
              width: 13px;
              position: absolute;
              top: 1px;    margin-left: -15px;

          }
     
        .search button,.footer button{
        height: 30px;      width: 100px;
        border-radius: 10px;
        border: none;border-bottom: 3px solid #dddddd;   outline:none; 
        }
       .search button{
   width: 60px;    position: absolute;
    margin-left: 10px;margin-top: 3px;
    /* text-align: right; */
    font-size: 14px;
    border: none;    height: 20px;    font-size: 12px;
    /* padding-right: 10px; */
    /* background: url(/static/images2/Grouping1.png) no-repeat; */
    /* background-position: 5px 5px; */
    /* background-size: 20px; */
    background: #fff;
    border: 1px solid rgba(233,233,233,1);
         }
        .agent_list li,.agent_listTwo li {
            min-height: 110px;
            border-bottom: 1px solid #e8e8e8;
            position: relative;
            padding-bottom: 14px;
            padding-top: 14px;
        }
  .agent_list li:nth-last-of-type(1),.agent_listTwo li:nth-last-of-type(1) {
     border:none;
  }
input[type="checkbox"] + label::before,input[type="radio"] + label::before {
    content: "\a0";
    display: inline-block;
    vertical-align: .2em;
    width: 1.2em;
  /*  height: 1.2em;*/
    margin-right: .2em;
    border-radius: .2em;
    /* background-color: silver; */

    text-indent: .19em;
    line-height: 1.2;
    position: absolute;
    top: 10px;
    right: 10px;
    margin-top: -0.6em;
    background-color: #fff;
    border: 1px solid #999;
    color: #f97241;
}
input[type="checkbox"]:checked + label::before ,input[type="radio"]:checked + label::before {
 content: "\2713";
}
.item-link input[type="checkbox"] + label::before,.item-link input[type="radio"] + label::before {
  z-index: 0
}
.agent_list input {
    position: absolute;
    clip: rect(0, 0, 0, 0);
}
.title>p{
    font-size: 14px;
    /* height: 30px; */
        min-height: 25px;
    line-height: 22px;
    float: left;
    width: 70%;
    padding-left: 2px;
    /*position: relative;*/
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.title:nth-child(1){
  padding-bottom: 12px;
}

.title>.right{
width: 30%;
}

.title> p>span{
  /*position: absolute;    left: -15px;*/
}

.title>p:nth-child(2){
  float:right;position: relative;      overflow: inherit;  
}



.item-link .title> p{
  width: 100% ;
}
/*.title .name{
  overflow: inherit;
    white-space: initial;
}
*/
.title .name span:nth-child(1){
    width: 20px;
    height: 20px;
    top: 5px;
    /* display: inherit; */
    padding: 2px 5px;
    /* border-radius: 50%; */
    background: url(/static/images2/Group7.png) no-repeat;
    margin-right: 10px;
    color: #fff;
    background-size: 100% 100%;
    position: absolute;
    left: -20px;
    line-height: 18px;
    text-align: center;
    float: right;
    font-size: 9px;
}
.title .name  span{
    height: 20px;
    /* display: table-cell; */
    vertical-align: middle;
    padding-right: 5px;
    /* line-height: 14px; */
    /* padding: 00; */
    line-height: 22px;
    /* left: 0; */
    font-weight: bold;
    margin-top: -3px;
}
.title .name  .hierarchy span{
    font-weight: 400;    margin-left: 12px;    font-size: 12px;
}
.item_ab{
position: absolute;
    left: 9em;
    top: 16px;

     height: 75px;
    width: calc(100% - 140px);
}
.agent_icon{
      margin-left: 3.2em;
    margin-top: 5px;
    width: 70px;
    height: 70px;
    /*background: red;*/
    border-radius: 50%;
    overflow: hidden;
}

.agent_icon>img{
   height: 100%;width: 100%;
 }
.right img:nth-child(2){
    position: absolute;
    top: 7px;
    /* right: 10px; */
    width: 15px;    left: 5px;

}


.smallImg{
      transform:rotate(-180deg);
-ms-transform:rotate(-180deg);   /* IE 9 */
-moz-transform:rotate(-180deg);  /* Firefox */
-webkit-transform:rotate(-180deg); /* Safari 和 Chrome */
-o-transform:rotate(-180deg); 
}
.title .name .it_name{
    border-radius: 2px;
    background:none;
    background-color: #FA6B38;
    box-shadow: none;
}
.small{
  position: absolute;
    /*top: 6px;*/
    width: 30px;
    right: 4px;
    height: 20px;
    line-height: 16px;
    border-radius: 3px;
    padding: 3px;
    box-sizing: border-box;
}

/*.item-link li:nth-child(1){
  border-top: 1px solid rgb(250, 107, 56);
}*/
.item-link .agent_icon{
    margin-top: 20px;
    width: 50px;
    height: 50px;
    margin-left: 3.2em !important;
} 


.item-link .item_ab{

   
    left: 120px;
    top: 25px;
    width: calc(100% - 120px);
    padding-right: 15px;
        margin-left: 1em !important;
} 
.item-link
    .table-foot{
        position: fixed;
    z-index: 998;
    right: 0;
    left: 0;
    bottom: 0;
    height: 44px;
    padding-right: 10px;
    padding-left: 10px;
    border-bottom: 0;
    background-color: #f7f7f7;
    -webkit-box-shadow: 0 0 1px rgba(0,0,0,.85);
    box-shadow: 0 0 1px rgba(0,0,0,.85);
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
     }
      .table-foot {
        padding: 0 20px;
    }
    .table-foot p{
        /*float: left;*/
        line-height: 50px;    float: left;
    }  
.title> .hierarchy{
    color: #FA6B38;
    font-size: 10px;
    font-weight: 400;
    text-indent: 10px;
    min-width: 52px;
}
.check{
      position: absolute;
    width: 25px;
    height: 25px;    top: 37px;
    border: 1px solid #FA6B38;

}
.addTo,.addTo2{
    padding: 3px 7px;
    position: absolute;
    right: 47px;
    width: 65px;
    border: 1px solid #f3f3f3;
    border-radius: 50px;
    color: #979797;
        padding: 0px 5px;
    margin: auto;
    border: 1px solid #e3e3e3;
    font-size: 11px;
    text-align: center;
    line-height: 21px;
    background-color:#fff;
}
.addTo2{
  background-color:#f7f7f7;
}
.dialog_container .agent_icon{
  margin-left:0;
  width: 50px;height: 50px;margin-top: 18px;
}
.dialog_container .agent_icon .item_ab{
  left: 6em;;    top: 18px;width: calc(100% - 95px);
}#leader .agent_icon{
  margin-top:20px;
}#dd_membe_list_data{
    padding-left: 25px;
}
.table-foot{border-top:1px solid #f3f3f3;position: fixed;width: 100%; bottom:0;font-weight: bold;background: #fff;z-index: 997;font-size: 13px;}
.layery{
      width: 80%;
    height: 200px;
    background: #fff;
    position: absolute;
    z-index: 1000;
    margin-left: 10%;
    margin-top: 50%;
    border-radius: 2px;
    border: 1px solid #A9A9A9;
    text-align: center;
    padding-top: 40px;
}
</style>
</head>
<body>
  <div class="form" style="position: absolute;width:100%;">
      <div class="table-hr">
           <div class='search'>
               <label>
            <input type="text" name="" value=""  placeholder="">  <!-- //请输入搜索的用户名 -->
            <div class="inputP"><img src="/static/images2/search_img.png" width='15px' alt="">请输入用户名/电话</div>
                  <span>
                <button type="btn" id="searchInit" data=1>编辑</button>
                  <span class="img_btn">
                     <p>点击向下图标  可以显示组员，组内数量，点击向上图标则收起。
                     <span></span>
                    </p> 
                  </span>  
              </span>
              </label>
            </div>
      </div>
    <div class="table_bd" style="margin-top:55px;padding-bottom: 150px;">
        <ul class="agent_list" id='list_data'>
        </ul>
    </div>
    <div class="table-foot">
        <p style="text-align: center">总分组数为：<span style="color:#53B1F9"><?=$total_group?></span>  </p>
        <p style="text-align: center ; float: right;"> 总用户数为：<span  style="color:#FA6B38"><?=$total?></span></p>
    </div>
  </div>
 </body>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js?v=2.0"></script>
<script type="text/javascript" src="/static/js/common.js?v=1.5" ></script>
<script>
var data=<?=json_encode($data)?>;
var total_group=<?=json_encode($total_group)?>;
var total=<?=json_encode($total)?>;
var  search= decodeURI(getQueryString("search"))||'';
console.log(data)
var  Id= <?=json_encode($Id)?>||'0';
var  Ids= <?=json_encode($Ids)?>||'0';
var ids=[];
// console.log(Id)
// console.log(Ids)

if(search){
  $(".search input").val(search)
}else{
  $(".search input").val('')
}
if(search=='null'){
    $(".search input").val('')
}

if(search=='undefined'){
    $(".search input").val('')
}

var info = sessionStorage.getItem('info'); 
var infoi = JSON.parse(info);
console.log(infoi)
 if(infoi.Level!=5){
   $(".search span").hide()
     $(".table-foot p").eq(0).hide()
     $(".table-foot p").eq(1).css('float','inherit').find('span').text(data.result.length)
   }
if(infoi.Level==5){
    listFor(searchFun(data))
}else{
    // listFor(data);
var list=data.result;
    listFor(list)
}
  function getColorBywatervl(_val){
      if(_val<2){
          return "red";
      }else if(_val<=7.5){
          return "#34a0f8";
      }else{
          return "green";
      }
  }

$('.search input').on('input propertychange', function() {



  if(infoi.Level==5){
      listFor(searchFun(data))
  }else{

    var consf = searchFun(data.result)
  
   listFor(searchFun(data.result))
console.log(searchFun(data.result))
  }
});
function  searchFun(data){
   var search=Trim($('.search input').val());
     // console.log(search)
       if(search){
        $(".inputP").hide()
       }else{
           $(".inputP").show()
       }
    var dataD=[]; 
    $.each(data, function(key, value){
           if(infoi.Level==5){
               if(value.Name.indexOf(search) != -1 ){
                   dataD.push(value)
               }else if(value.Tel.indexOf(search) != -1 ){
                dataD.push(value)
               };
            }else{
                   if(value.name.indexOf(search) != -1 ){
                      dataD.push(value)
                 }else if(value.Tel.indexOf(search) != -1 ){
                dataD.push(value)
               }
         

         
       };
    });
    return dataD;
}
$("#searchInit").click(function(e){
   var ifdata = $(this).attr('data');
   if(ifdata==1){
      $(this).text('完成').attr('data',0); 
        $(".addTo,.addTo2").show();
        $(".name,.Group_neme").css('width','50%;');
   }else{
    $(".addTo,.addTo2").hide()
    $(".name").css('width','70%;')
    $(".Group_neme").css('width','30%;')
     $(this).text('编辑').attr('data',1);
   }


    // list_click();
    itemLink()
})

function listFor(data,searchString){
      $("#list_data").empty();
      var searchShow=$("#searchInit").attr('data');
// console.log(searchShow)
      for(var index=0;index<data.length;index++){
         var item=data[index];
         var obj={
               'data':item,//数据表
               'index':index, //列表数 
               'Id':Id,   //组长id
               'Ids':Ids, //组员id数组
               'infoi':1,  //是否隐藏右方
               'searchShow' :searchShow   // 编辑状态
        }
         var html = groupHtml(obj)
        $("#list_data").append(html)  

         if(infoi.Level!=5){
          $(".hierarchy").hide()
         }
      }
      if(searchShow){
         $(".check").hide();
         $(".agent_icon").css({'margin-left':'1em'});

         $(".item_ab").css({'left':'7em','width':'calc(100% - 120px)'});
      }
    if(infoi.Level==5){
        list_click();
        itemLink()  
    }else{
        $(".right").css('display','none')
        $(".title>p").css('width','100%')
    }
}  





function  groupHtml(obj){
  var item=obj.data;
// console.log(item)


  var name= item.name;

  var Tel=item.tel;
  var Address=item.watervl;
     if(infoi.Level==5){
         name=item.Name;
         Tel=item.Tel;
         Address=item.Address;
      }
  var  html='<li  GroupId='+item.GroupId+'  dataid='+item.Id+'  >';
  // html+='<div class="Group_click" data="0">';

   if(obj.Id*1==item.GroupId){
     html+='<div class="Group_click" data=1 >'; 
 }else{
    html+='<div class="Group_click" data=0 >';   
 }
  html+='<div class="agent_icon">';


if(item.HeadPortrait){
   html+='<img src="'+item.HeadPortrait+'" />';
 }else{
   html+='<img src="/static/images2/timg (1).png" />';
 }


  html+='<div>';
  html+='<div class="item_ab" style="left: 7em; width: calc(100% - 120px);">';
  html+='<div class="title">';
  html+='<p class="name" index="1">';
    if(obj.Id*1==item.GroupId){
    html+='<span  class="it_name" style="background:none"><img src="/static/images2/admin_us.png" style="width: 0.5rem;;margin-right: 10px;"></span><span class="NameText">'+Trim(name)+'</span>';
       if(item.GroupId!=0){
             html+='<span class="hierarchy"><img src="/static/images2/625783632253647468.png" style="width:  10px;position: absolute;top: 7px;;margin-right: 10px;" /><span style="text-indent:15px">组长 </span></span>';  
       }

    // console.log(Id*1)
    } else{
    html+='<span style="background: none;"><img src="/static/images2/admin_us.png" style="width: 0.5rem;margin-right: 10px;"></span><span class="NameText">'+Trim(name)+'</span>';
      if(item.GroupId!=0){
             html+='<span class="hierarchy"><img src="/static/images2/625783632253647468.png" style="width:  10px;position: absolute;top: 7px;;margin-right: 10px;" /><span style="text-indent:15px">组长 </span></span>';  
       }
    }
  html+='</p>';



if(item.GroupId!=0){
   if(obj.Id*1==item.GroupId){
    html+='<p class="right Group_neme" style=""> <span class="addTo" style="padding: 0 5px;;width:50px;box-sizing: content-box;text-align:center;display:none">增加成员</span> <span class="small"><span style="position: absolute;right: -25px;top:35px;color:#FA6B38;width:50px;font-size:11px">'+item.num*1+'人</span><img  class="smallImg" src="/static/images2/CombinedShape.png" width="100%"  style="transform: rotate(0deg); -ms-transform: rotate(-0deg); -moz-transform: rotate(-0deg);-webkit-transform: rotate(0deg);-o-transform: rotate(deg);"></span></p>';


 }else{
  html+='<p class="right Group_neme" style=""> <span class="addTo" style="padding:0  5px;width:50px;box-sizing: content-box;text-align:center;display:none">增加成员</span> <span class="small"><span style="position: absolute;right: -25px;top:35px;color:#FA6B38;width:50px;font-size:11px">'+item.num*1+'人</span><img class="smallImg" src="/static/images2/CombinedShape.png" width="100%" /></span></p>';
 }
}else{
   html+='<p class="right Group_neme" style=""> <span class="addTo" style="padding:0  5px;width:50px;box-sizing: content-box;text-align:center;display:none">增加成员</span></p>';
}

  html+='<div style="clear:both;"></div>';
  html+='</div>';
  html+='<div class="title">';
  html+='<p><span style="position:absolute;left:-15px"><img src="/static/images2/talUs.png" style="width: 0.5rem;" /> </span>'+Tel+'</p>';
  html+='</div>';
  html+='<div class="title">';

if(infoi.Level==5){
    html+='<p><span style="position:absolute;left:-15px">';
  html+='<img src="/static/images2/GroupMap.png" style="width: 0.5rem;" /> ';
   html+=' </span>'+Address+'</p>';
}else{
    html+='<p><span  style="position:absolute;left:-15px"> ';
  html+='<img src="/static/images2/536539445301906880.png" style="width: 0.5rem;" /> ';
     html+=' </span>用水量：'+Address+'L</p>';
}
  html+=' </div>';
  html+='</div> ';
  html+=' <div style="clear:both;"></div>';
  html+=' </div>';
  html+='</div>';


  html+='</div>';
 if(obj.Id*1==item.GroupId){
      html+=record(item.GroupId,obj.Ids)
 }
  html+=' <div style="clear:both;"></div>';
  html+='</li>';

  return html;
}


function groupyuan(obj){
  // console.log(4)
  var item=obj.data;
  var name=item.name;
  var Tel=item.tel;
  var Address=item.watervl;
          if(infoi.Level==5){
             name=item.Name;
             Tel=item.Tel;
             Address=item.Address;
          }
      // console.log(obj)    
// console.log(item)
  var _display='block'
  if(obj.searchShow==1){
    _display='none'
  }
  var  html='<li  GroupId='+item.GroupId+'  dataid='+item.Id+'  >';


  html+='<div class="Group_click" data="0">';

  if(obj.Ids==item.Id){
     html+='<span style="position: absolute;left: 30px;top: 50px;color: red;">*</span>';  
  }
  html+='<div class="agent_icon">';
if(item.HeadPortrait){
   html+='<img src="'+item.HeadPortrait+'" />';
 }else{
  html+='<img src="/static/images2/timg (2).png" />';
 }




  html+='<div>';
  html+='<div class="item_ab">';
  html+='<div class="title">';
 var  numo=50;
 var  numo2=50;


      if(obj.Group_neme){
           numo=70
           numo2=30
      }

  html+='<p class="name" index="1" style="width:'+numo+'%;"><span>'+(obj.index+1)+'</span><span class="NameText">'+Trim(name)+'</span><span class="hierarchy"><img src="/static/images2/644024873909418564.png" style="width:  10px;position: absolute;top: 2px;;margin-right: 10px;" /><span style="text-indent:15px"> </span></span></p>';

  html+='<p class="right Group_neme" style="width:'+numo2+'%;">';

      if(obj.Group_neme){
          html+='<span><input type="checkbox" class="awesome" id="awesome'+obj.index+'"/>';
          html+='<label for="awesome'+obj.index+'"></label></span>';
        }else{
          html+='<span class="addTo2" style="padding:0 5px;display:'+_display+';margin:auto;    border: 1px solid #e3e3e3;">选为组长</span></p>';     
        }
  html+='<div style="clear:both;"></div>';
  html+='</div>';
      // if(obj.Group_neme){
  html+='<div class="title">';
  html+='<p><span style="position:absolute;left:-15px"><img src="/static/images2/talUs.png" style="width: 0.5rem;" /> </span>'+Tel+'</p>';
  html+='</div>';
  html+='<div class="title">';
  

  html+='<p><span style="position:absolute;left:-15px">';
  html+='<img src="/static/images2/GroupMap.png" style="width: 0.5rem;" /> ';
   html+=' </span>'+Address+'</p>';

  html+=' </div>';


  //     }else{
  // html+='<div class="title">';
  // html+='<p style="width:50%;"><span style="position:absolute;left:-15px"><img src="/static/images2/GroupMap.png" style="width: 0.5rem;" /> </span>'+Address+'</p>';
  // html+='<p class="right" style="width:50%;"><span><img src="/static/images2/talUs.png" style="width: 0.5rem;" /> </span>'+Tel+'</p>';

  // html+='<div style="clear:both;"></div>';
  // html+='</div>';        
  //     }
  html+='</div>';
  html+='<div style="clear:both;"></div>';
  html+='</div>';
  html+='</div>';
  html+='</div></li>';
  return html;
}

// 点击组长
function  list_click(){ 
$(".small").click(function(e){
  e.stopPropagation();
    var GroupId=$(this).parents('li').attr('GroupId');
     var dataid=$(this).parents('li').attr('dataid');
 // console.log(GroupId)

   var IfShow= $(this).parents('li').find('.Group_click').attr('data'); 
    // console.log(IfShow);
    var nameText= $(this).parents('li').find('.NameText').text();
    var nameIndex= $(this).parents('li').find('.name').attr('index');
// //     // $(this).parents('li').find('input').prop('checked')
    if(GroupId=='0'){
      $.toast('没有组员');
     return;
    }
  // console.log(IfShow)
  if(IfShow==0){


       $(this).parents('li').find('.Group_click').attr('data',1)
        $(this).parents('li').find('.name').find('span').eq(0).html('<img src="/static/images2/admin_us.png" style="width: 0.5rem;margin-right: 10px;">').css({'background':'none'})
       $(this).find('.smallImg').css({'transform':'rotate(-0deg)','-ms-transform':'rotate(-0deg)','-moz-transform':'rotate(-0deg)','-webkit-transform':'rotate(-0deg)','-o-transform':'rotate(-0deg)'})
        var html = record(GroupId,dataid);

      $(this).parents('li').append(html);
   // var searchShow=$("#searchInit").attr('data');
     
  }else{
    $(this).parents('li').find('.Group_click').attr('data',0)
     // $(this).parents('li').find('.name').find('span').eq(0).html(nameIndex).css({'background':'url(/static/images2/Group7.png) no-repeat;','background-size':'100% 100%;'})
  $(this).find('.smallImg').css({'transform':'rotate(-180deg)','-ms-transform':'rotate(-180deg)','-moz-transform':'rotate(-180deg)','-webkit-transform':'rotate(-180deg)','-o-transform':'rotate(-180deg)'});



    $(this).parents('li').find('.link_remover').remove()
}
  // itemLink()
})
}
function itemLink(){
  $('.addTo').click(function(e){
   // console.log(124444)
   var Idname= $(this).parents('li .Group_click').html();
      var GroupId=$(this).parents('li').attr('GroupId');
       var dataid=$(this).parents('li').attr('dataid');
       var searchSt=Trim($('.search input').val());
       var htmlID=$(this).parents('li').html();
    $(GroupId).find(".link_remover").remove();
     $.get('/index.php/agent/add-member-datas',{'Id':dataid,'GroupId':GroupId}, function(data, textStatus) {
      var data=data;
         if(typeof(data)=='string'){
           data= eval('(' + data + ')');
        }
        console.log(data)
// var html ='<div  id="add_member">';
// var _height = window.screen.height;
     var html='<div class="table-hr">';
        html+='<div class="search">';
        html+=' <label>';
        html+='<input type="text" name="" value=""  placeholder="请输入搜索的用户名">';
        html+='<span class="searchSpan" style="display:none">';
        html+='<button type="btn" id="searchInitbtn" data=1>保存</button>';
        html+='</span>';
        html+='</label>';
        html+='</div>';
        html+='</div>';
        html+='<div class="add_member_table_bd" style="padding:0 8px;margin-top:55px;">';
        html+='<ul class="agent_list" id="leader" style="border-bottom: 1px solid #e8e8e8;"><li style="height: 126px;" dataid='+dataid+' GroupId='+GroupId+'>'+Idname+'</li></ul><ul class="agent_list" id="dd_membe_list_data" style="height:'+( window.screen.height-200)+'px;overflow: auto;padding-bottom: 150px;">';
           for(var index=0;index<data.data.length;index++){
            var item=data.data[index];
           var obj={
               'data':item,//数据表
               'index':index, //列表数 
               'link':1,  //是否是组员
               'Id':0,   //组长id
               'Ids':0, //组员id数组
               'infoi':1,  //是否隐藏右方
               'searchShow':1,
               'Group_neme':1
            }
          // html += _html(obj)
           html += groupyuan(obj)
      }
       html+='</ul>';
        html+='</div>';
           
   // html+='</div>';
        var height= window.screen.height;
        // console.log(html)
        // var html=$("#add_member_html").html()
        $.tipsAlertOne(html,function(){
             // console.log(1111)

        },{
          style:'height:100%;top:0px;width:100%;left:0;border-radius: 0;margin: 0;',
           
        })




$('body').find(".dialog_container .small").remove();
$('body').find(".dialog_container .addTo").remove();
$('body').find('.dialog_container .search input').on('input propertychange', function() {
  var val=Trim($(this).val());
    var dataD=[];
    // console.log(val)
     $("#dd_membe_list_data").empty()

//      ids.splice(0,ids.length)
     $.each(data.data, function(key, value){
      // console.log(value)
       if(value.Name.indexOf(val) != -1 ){
           dataD.push(value)
       };
     })
// console.log(dataD)

        // /.log(dataD);
        var html ='';
       for(var index=0;index<dataD.length;index++){
                     var item=dataD[index];
                       var obj={
                               'data':item,//数据表
                             'index':index, //列表数 
                             'link':1,  //是否是组员
                             'Id':0,   //组长id
                             'Ids':0, //组员id数组
                             'infoi':1,  //是否隐藏右方
                             'searchShow':1,
                             'Group_neme':1
                        }
           html += groupyuan(obj)       
        }
    $("#dd_membe_list_data").append(html);


    tips_dialog_title_check()
    })

// 选择组成员
tips_dialog_title_check()
   $('body').find('#searchInitbtn').on('click', function () {
 var idsString=ids.join(',');
// console.log(idsString)
  var GroupId=$('#leader li').attr('dataid');
     // console.log(GroupId)
     if(ids.length<=0){
     $.alert('你还没有选择组员',function(){

     })
      return;
     }



     $.get('/index.php/agent/save-add-member',{'Id':GroupId,'Ids':idsString}, function(data) {
              var data=data;
                  if(typeof(data)=='string'){
                     data= eval('(' + data + ')');
                  }
                  console.log(search)
                    if(data.state==-1){
                       $.toast(data.msg)
                      return;
                  }else{
                    var search=$(".search input").val();

                            console.log(search)

                  var html =  '<div class="layery"><img src="/static/images2/587793514556295510.png" style="width: 2.5rem;"><p>增加成功</p></div>';
                     $("body").append(html);   
                // setTimeout(function () {  
                    location.href="/index.php/agent/users?search="+search+"&Id="+GroupId+"&Ids="+idsString; 
                   // }, 1000);

                    
                      
                  }
          });

   })
function tips_dialog_title_check()
{
   $('body').find('.tips_dialog_content .Group_neme input').on('click', function () {
        // $("body").find(".dialog_container").remove();
        // console.log(1)
        var  dataT = $(this).attr('id')
        // console.log(dataT)
         //
         var dataid= $(this).parents('li').attr('dataid');
 
     var dataOf= document.getElementById(dataT).checked
       if(dataOf){
           ids.push(dataid)
       }else{
          ids.removeArr(dataid)
       }
// console.log(ids);

if(ids.length>0){
  $(".searchSpan").css('display','inherit')
}else{
    $(".searchSpan").css('display','none')
}

  Array.prototype.removeArr = function(val) {
  var index = this.indexOf(val);
  if (index > -1) {
  this.splice(index, 1);
  }
  };
         
   });

}

  })

   
  })

  $(".addTo2").click(function(e){
      // console.log(8)
      e.stopPropagation();
        var searchShow=$("#searchInit").attr('data');
if(searchShow==1){
return;
}
      var _this=$(this)
     var GroupId=$(this).parents('li').attr('GroupId');
     var dataid=$(this).parents('li').attr('dataid');
       // $(this).parent('li').find('input').attr('checked',true);

        // console.log(GroupId)
  
        $.confirmTwo('<div style="width:100%;margin-top: 20px;"><img src="/static/images2/587793514556295510.png" style="width:60px"><p style="margin-top: 12px;">你确定要修改组长吗？</p></div>',{
                   style:'height:285px;top:30%',
                    label:'确定'

        }
        ,function(){
 
            $.get('/index.php/agent/edit-leader',{'Id':dataid,'GroupId':GroupId}, function(data, textStatus) {
                          /*optional stuff to do after getScript */ 
                         var data=data;
                         $.hideIndicator()
                           if(typeof(data)=='string'){
                             data= eval('(' + data + ')');
                          }
                          if(data.state==-1){
                               $.toast(data.msg)
                               // _this.removeAttr('disabled')
                              return;
                          }else{
                            _this.attr('checked',true)
                              $.toast('修改成功');
                             window.location.href="/index.php/agent/users"; 
                          }
                 });
        }
        , function(){
            // console.log(2)
        }
        );
})
}

// 获取组成员
 function record(id,ids){
   var obj={GroupId:id}

   // console.log(ids)

   if(!id||id==0){
    return '';
   }

       $.showPreloader()
   // return
    var html=''
      $.ajax
       ({
           cache: false,
           async: false,
           type: 'get',
           data:obj,
           url: '/index.php/agent/get-group-member',
           success: function (data) {
               $.hidePreloader()
                if(typeof(data)=='string'){
                data= eval('(' + data + ')');
                }
                 // console.log(data)
                  if(data.state==-1){
                    $.toast(data.msg);
                      return;
                  }
         html+=' <div class="link_remover" style="margin-top:15px"> <p></p><ul  class="item-link" style="padding-left:0px;background:#f7f7f7">'

              var searchShow=$("#searchInit").attr('data');
              // console.log(searchShow)
                    for(var index=0;index<data.data.length;index++){
                     var item=data.data[index];
                     var obj={
                           'data':item,//数据表
                           'index':index, //列表数 
                           'link':1,  //是否是组员
                           'Id':id,   //组长id
                           'Ids':ids, //组员id数组
                           'infoi':0,  //是否隐藏右方
                           'searchShow':searchShow
                        }
                        html += groupyuan(obj)
                  }
                     html+=' </ul></div>'
           }
      })


       return html;
 }




  </script>
 
</html>