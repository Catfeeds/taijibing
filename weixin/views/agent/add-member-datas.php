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
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>用户</title>
    <style>
      
.table-hr{border-bottom:1px solid #f3f3f3;position: fixed;width: 100%;top: 0;font-weight: bold;background: #fff;z-index: 10000;}
.search{text-align: center;padding:10px;height: 50px;position: relative;}
.search .img_btn{position: absolute;padding: 0 5px;box-sizing: border-box;}
.search .img_btn p{width: 200px;position: absolute;right: 0;background: #fff;text-align: left;font-size: 14px;font-weight: 400;line-height: 21px;padding: 5px;top: 40px;border-radius: 5px;z-index: 14;border: 1px solid #000;display: none}
.table_tr{position: relative;}
.center{display: inline-block;width: 100%;}
.search .img_btn p>span{position: absolute;right: 10px;top: -10px;width: 0;height: 0;border-left: 7px solid transparent;border-right: 7px solid transparent;border-bottom: 10px solid #000;z-index: 15;}
.search input{height: 30px;    width: 60%;border-radius: 17px;text-indent: 10px;outline:none;border: none;font-size: 12px;text-align: center;padding-right: 10px;background: #f3f3f3 url('/static/images2/search_img.png') no-repeat;background-position: 5px 5px;background-size: 20px;}
.search button,.footer button{height: 30px;width: 100px;border-radius: 10px;border: none;border-bottom: 3px solid #dddddd;outline:none;}
.search button{width: 70px;/*text-align: right;*/font-size: 14px;height: 25px;border:none;color: #FA6B38;background-color: transparent;border-radius:900px;border:1px solid rgba(250,107,56,1);}
.agent_list li{/*height: 110px;*/border-bottom: 1px solid #e8e8e8;position: relative;padding-bottom: 14px;padding-top: 14px;}
input[type="checkbox"] + label::before{content: "\a0";display: inline-block;vertical-align: .2em;width: 1.2em;/* height: 1.2em;*/margin-right: .2em;border-radius: .2em;/* background-color: silver;*/text-indent: .19em;line-height: 1.2;position: absolute;top: 15px;right: 0;margin-top: -0.6em;background-color: #fff;border: 1px solid #999;color: #f97241;z-index: 100}
input[type="checkbox"]:checked + label::before{content: "\2713";}
.agent_list input{position: absolute;clip: rect(0, 0, 0, 0);}
.title>p{font-size: 12px;height: 38px;line-height: 38px;float: left;width: 50%;padding-left: 2px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
.title>p:nth-child(2){float:right;position: relative;text-align: right;}
.title .name span{width: 12px;height: 12px;background-color: #53B1F9;/* display: inherit;*/padding: 2px 5px;border-radius: 50%;margin-right: 10px;color: #fff;box-shadow: 0px 0px 5px #000;}
.item_ab{position: absolute;left: 110px;top: 16px;height: 75px;width: calc(100% - 130px);}
.agent_icon{margin-left: 20px;margin-top: 5px;width: 70px;height: 70px;}
.right img:nth-child(2){position: absolute;top: 12px;right: 10px;}
.title .name .it_name{border-radius: 2px;background-color: #FA6B38;box-shadow: none;}
.small{position: absolute;top: 6px;width: 20px;right: 4px;height: 20px;line-height: 16px;border-radius: 3px;padding: 3px;box-sizing: border-box;}
/*.item-link li:nth-child(1){border-top: 1px solid rgb(250, 107, 56);}*/.item-link .agent_icon{margin-top: 20px;width: 50px;height: 50px;}
.item-link .item_ab{left: 120px;top: 25px;width: calc(100% - 120px);} 
</style>
</head>
<body>
  <div class="form">
      <div class="table-hr">
           <div class='search'>
               <label>
                <input type="text" name="" value=""  placeholder="请输入搜索的用户名">
                  <span>
                <button type="btn" id="searchInit" data=1>保存</button>
                  <span class="img_btn">
                    <p>点击向下图标  可以显示组员，组内数量，点击向上图标则收起。
                     <span></span>
                    </p> 
                  </span>  
              </span>
              </label>
          </div>
      </div>
    <div class="table_bd" style="padding:0 8px;margin-top:55px;">
         <ul class="agent_list" id='list_data'>
        </ul>
    </div>
  </div>
 </body>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js?v=1" ></script>
<script>
var data=<?=$data?>;
var GroupId='<?=$Id?>';
// alert(7)
console.log(GroupId)
   if(typeof(data)=='string'){
      data= eval('(' + data + ')')
   }
console.log(data);
function listFor(data){
      $("#list_data").empty();
      for(var index=0;index<data.length;index++){
         var item=data[index];
         var html = _html(item,index)
        $("#list_data").append(html)
      }
}
 function _html(item,index,link){
        var searchShow=$("#searchInit").attr('data');
            var  html='<li  GroupId='+item.GroupId+'  dataid='+item.Id+'  >';
            html+='<img src="/static/images2/timg (1).png" class="agent_icon" />';
            html+=' <div class="item_ab">';
            html+='<div class="title" >';
            html+='<p  class="name">';
            html+='<span>1</span>'+item.Name;
            html+='</p>';
            html+='<div class="right">';
            html+='<input type="checkbox" id="awesome'+index+'" name="checked" />';
            html+=' <label for="awesome'+index+'"></label>  ';
            html+=' </div>';
            html+='<div style="clear:both;"></div>';
            html+='</div>';
            html+='<div class="title" >';
            html+='<p >';
            html+='<span>';
            html+='<img src="/static/images2/GroupMap.png" style="width: 0.5rem;"> ';
            html+='</span>'+item.Address;
            html+='</p>';
            html+='<p class="right">';    
            html+='<span><img src="/static/images2/talUs.png" style="width: 0.5rem;"> </span>'+item.Tel; 
            html+='</p>';    
            html+='<div style="clear:both;"></div>';    
            html+='</div>';    
            html+='</div>';    
            html+='</li>';    
            html+='';    
          return html;
}
listFor(data)
$('.search input').on('input propertychange', function() {
  var val=Trim($(this).val());
    var dataD=[];
    $.each(data, function(key, value){
       if(value.Name.indexOf(val) != -1 ){
           dataD.push(value)
       };
    })
    listFor(dataD)
})
$("#searchInit").click(function(){
    var strgetSelectValue=[];
    var getSelectValueMenbers = $("input[name='checked']:checked").each(function(j) {
//       // console.log(j)
        if (j >= 0) {
            // strgetSelectValue += $(this).parents('li') .attr('dataid') + ","
            strgetSelectValue.push($(this).parents('li') .attr('dataid') )
        }
    });
      var  Id= decodeURI(getQueryString("Id"));
      var  search= decodeURI(getQueryString("search"));
        var strgetSelectValueop=strgetSelectValue.join(',');

      // alert(strgetSelectValueop)

   $.get('/index.php/agent/save-add-member',{'Id':Id,'Ids':strgetSelectValueop}, function(data) {

              var data=data;
                  if(typeof(data)=='string'){
                     data= eval('(' + data + ')');
                  }
                  // console.log(data)
                    if(data.state==-1){
                       $.toast(data.msg)
                      return;
                  }else{
                        window.location.href="/index.php/agent/users?search="+search+"&Id="+Id+"&Ids="+strgetSelectValue; 
                  }
  });
})


  </script>
</html>