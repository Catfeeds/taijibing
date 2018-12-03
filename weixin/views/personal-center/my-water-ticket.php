<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
<meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8" />
	<title>电子水票</title>

	<style type="text/css" media="screen">
	body{
		padding: 0;margin:0;

	}

		.header{
			height: 100%;border-top:1px solid #ddd;border-bottom:1px solid #ddd;padding:15px;
		}
		.header p{
			border-bottom: 1px solid #ddd;padding:10px;
		}
        select{
            height: 30px
        }
        table{
            font-size: 10px;
        }
       
        .item_re{
            position: relative;
        }
        .item_ab{
            position: absolute;
    top: 0;
    right: 5px;
    height: 25px;
    width: 50px;
    background: red;
    line-height: 25px;
    text-align: center;
    border-radius: 5px;
    color: #fff;
    top: 50%;
    margin-top: -12.5px;
        }
        .item_re p{
            width: 100%;    float: left;    text-align: center;
        }
        .item_rirht{
           margin-right: 70px;;  float: right;right:0 
        }
        .item_left{
           float: left
        }
          .item{
            border:1px solid #ddd;clear:both;
         }
             .footer{
            position:fixed;
            width:100%;
            bottom:0px;
            height:60px;
            background: #fff;
            padding:20px 10px;
        }
	</style>
</head>
<body>
    <div class='wrapper' style="padding-bottom:150px; ">
    	 <div class="header" style=''>
    	 	  <p><span>水票余额：</span>  <?=$rest_money?>元</p>
    	 	  <p>
    	 	  	<select name="state" id='state'>
                    <option value="">筛选</option>
                    <option value="1">待确认</option>
    	 	  		<option value="2">已完成</option>
    	 	  	</select>
    	 	  	<select name="type" id='type'>
                    <option value="">分类</option>
                    <option value="1">充值</option>
    	 	  		<option value="2">送水</option>
    	 	  	</select>
    	 	  </p>
    	 </div>
         <table style='border-collapse: collapse'>
             <tbody id='item_init'>
                <tr class="item">
                     <td style='width: 10%; min-width: 50px;text-align: center;'>
                         <div class="checkboxBtn">
                           <input type="checkbox" checked="checked"    name="state" value="100" style="display: block;    margin: auto;">
                           <span>充值</span>
                         </div>
                     </td>
                     <td class="item_re">
            <p><span  class="item_left" >时间：<span style="font-size:9px"> 2018-08-31 13:50:49</span> </span> <span class="item_rirht">余额：<span>800</span> 元</span></p>
            <p><span  class="item_left">品牌：<span> 冰川时代</span> </span> <span  class="item_rirht">商品：<span>冰川时代</span> </span></p>

            <p><span class="item_left">容量：<span> 10:00</span> </span><span> 数量：<span> 10:00</span></span> <span  class="item_rirht">单价：<span>800</span> 元</span></p>
                 <div  class="item_ab"  onclick="edit_state()">
                     已完成
                 </div>
                     
                     </td>
                      <div  style="clear:both;">
                
                 </div>
                </tr>
                     
             </tbody>
         </table>
	</div>

    <div class="footer">
    <div style=" position:relative; width:320px;margin:0 auto;height:100%;line-height:60px;">
        <a href="/index.php/personal-center/setting"><img src="/static/images/person.png" style="position:absolute;height:44px;left:0px;top:8px;"/></a>
       <a href="/index.php/personal-center/drink-monitor"><img src="/static/images/drink.png" style="position:absolute;height:50px;left:85px;top:8px;"/></a>
        <a href="/index.php/personal-center/drink-chart"><img src="/static/images/chart.png" style="height:44px;position:absolute;right:100px;top:8px;"/></a>
         <a href="/index.php/personal-center/my-water-ticket"><img src="/static/images/chart.png" style="height:60px;position:absolute;right:0px;top:0px;"/></a>
    </div>
</div>
</body>

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>

<script>
 // GetWhere()
var  rest_money=  <?=json_encode($rest_money)?>;

alert(rest_money);
var  datas=  <?=$datas?>;
var  UserId=  <?=json_encode($UserId)?>;
var  CustomerType=  <?=json_encode($CustomerType)?>;
var  AgentId=  <?=json_encode($AgentId)?>;
list(datas)
console.log(datas)
$("select").change(function(){
     GetWhere()
})

function list(data){
     $("#item_init").empty()
    if(data.length){
          
         for(var i=0;i<data.length;i++){
            var item = data[i]
            var html=''
               
               

                if(item.PayType){
                    html+= '<tr class="item"> ';
                    html+='<td style="width: 10%; min-width: 50px;text-align: center;">';
                    html+='<div>';
                    // html+='<input type="checkbox" checked="checked"    name="" value="" style="display: block;    margin: auto;">';
                    html+='<span>充值</span>';
                    html+='</div>';
                    html+='</td>';
                    html+='<td class="item_re">';
                    html+='<p><span >时间：<span> '+item.RowTime+'</span> </span> <span class="item_rirht">余额：<span>'+item.RestMoney+'</span> 元</span></p>';
                    html+='<p><span>充值方式：<span> '+ RestMoney(item.PayType)+'</span> </span> <span  class="item_rirht">充值金额：<span>'+item.PayMoney+'</span> 元</span></p>';
                    html+='<div  class="item_ab" style="background-color:#ddd">已完成'  
                    html+='</div>';
                    html+='</td>';
                    html+='</tr>';
                }else{
                    html+='<tr class="item">';
                    html+='<td style="width: 10%; min-width: 50px;text-align: center;">';
                    html+='<div>';
                    if(item.State<2){
                      html+='<input type="checkbox"  name="state" value="'+item.Id+'" style="display: block;    margin: auto;">';
                    }
                    html+='<span>送水</span>';
                    html+='</div>';
                    html+='</td>';
                    html+='<td class="item_re">';
                    html+='<p><span  class="item_left">时间：<span>'+item.RowTime+'</span> </span> <span class="item_rirht">余额：<span>'+item.RestMoney+'</span> 元</span></p>';
                    html+='<p><span  class="item_left">品牌：<span> '+item.BrandName+'</span> </span> <span  class="item_rirht">商品：<span> '+item.GoodsName+'</span> </span></p>';

                    html+='<p><span class="item_left">容量：<span> '+item.Volume+'</span> </span><span> 数量：<span> '+item.Amount+'</span></span> <span  class="item_rirht">单价：<span>'+item.Price+'</span> 元</span></p>';

                    
                    if(item.State<2){
                      html+='<div  class="item_ab" onclick="edit_state('+item.Id+')">'+State(item.State);
                    }else{
                        html+='<div  class="item_ab"  style="background-color:#ddd">'+State(item.State);
                    }
                   
                    html+='</div>';

                    html+='</td>';
                    html+='</tr>';
                }

            $("#item_init").append(html)
         }
    }
}

function RestMoney(data){
   if(data==1){
    return '现金'
   }else{
    return '微信'
   }
}
function State(State){
    var Statedata;
    if(State==1){
        Statedata = '待确认';
    }else if(State==2){
       Statedata = '已完成';
    }

    return Statedata;
}


 function GetWhere(){
    var state= $("#state").val();
    var type= $("#type").val();

    if(!state&&!type){
        list(datas);
        return
    }
    var obj={
         state:state,
         type:type,
         UserId:UserId,
         CustomerType:CustomerType,
         AgentId:AgentId,
    }
        console.log(obj)
    // 请求参数：state 状态(1待确认，2已完成)，type 分类（1充值，2送水），UserId，CustomerType，AgentId
     $.get('/index.php/personal-center/my-water-ticket-by-where',obj, function(data) {
         /*optional stuff to do after success */
           // console.log(obj)
           console.log(data)
            var data =data
            if(typeof(data)=='string'){
                data=  jQuery.parseJSON(data);
              }

            if(data.state==0){
                list(data.datas)
              }


     });
 }

function edit_state(Id){
var strgetSelectValue='';
var getSelectValueMenbers = $("input[name='state']:checked").each(function(j) {
 // console.log(j)
    if (j == 0) {
        strgetSelectValue += $(this).val() ;
    }else  if (j > 0){
          strgetSelectValue +="," +$(this).val();
    }else{
        // strgetSelectValue=Id;
    }
})

if(!strgetSelectValue){
    strgetSelectValue=Id;
}
console.log(strgetSelectValue)

 //询问框
  layer.open({
    content: '系统将会完成送水操作，确定已收到商品了吗？'
    ,btn: ['确定', '取消']
    ,yes: function(index){
    $.get('/index.php/personal-center/edit-state',{'ids':strgetSelectValue}, function(data) {
            /*optional stuff to do after success */
            console.log(data)
            var data =data
            if(typeof(data)=='string'){
                data=  jQuery.parseJSON(data);
              }
            var msg = '修改成功';
              if(data.state==0){
                     msg = '修改成功';
              }else{
                 msg = data.msg;
              }
             layer.open({
                content: msg
                ,btn: ['确定']
                ,yes: function(index){
                  location.reload();
                  layer.close(index);
                  
                }
              });
    });
      // location.reload();
      layer.close(index);

    }
  });




}




</script>
</html>

