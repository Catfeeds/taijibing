<!DOCTYPE html>
<html>
<head>
	<title>详情</title>
	    <meta charset="UTF-8">
	        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
</head>
<style type="text/css">
	*{
	padding: 0;margin:0;
	}
	.header{
	height: 40px;
	box-shadow: 0 0px 0px #ff9640;
	background: url(/static/images/headerbg11.png) no-repeat;
	background-size: 100% 100%;text-align: center;padding-top: 15px;
	}
	footer button{
	width: 50%;
	padding: 10px;
	height: 100%;
	border: 1px solid #fd9131;
	background-color: white;
	float: left;
	display: inline-block;
	}
	footer button img{
	height:100%;
	}



	.layui-layer-title,.layui-layer-setwin{
	display: none;
	}
/*	.layui-layer-content{
	padding:20px 10px;
	}*/
	.layui-layer-content p{
	margin-top: 15px;
    text-align: center;
	}
	
	
	a {
	color: black;
	text-decoration: none;
	}
	#layui-layer3{
	padding: 30px;
	}
	.layui-layer-buy_bnt .layui-layer-content,.layui-layer-buy_bnt .purchasecancel2{
		padding:0;
	}
	.layui-layer-content{
		    height: inherit;
	}
	.layui-laye{
	  border-radius: 10px 10px 0 0;
	}
	.layui-anim,.layui-laye{
		border-radius: 50px;
	}
</style>
<body>
    <div id="conter" style="padding-bottom: 50px;width: 100%;position: relative;">
    	 <div class="empty_goods" style="display:none;">
                       <div style="width:110px;margin:0 auto;margin-top:60px;">
                           <p style="text-align:center;font-size:18px;color:#e8e8e8;margin-bottom:10px;">暂无商品详情</p>
                           <img src="/static/images/empty_goods.png" style="width:110px;height:auto;"/>
                       </div>
                   </div>

      <div  id="imgUrl" style="margin-top:0px">
<!--          <img src="/static/images/ekuangDetails_1.png" alt="图片跑丢了" style="width: 100%">
          <img src="/static/images/ekuangDetails_2.png" alt="图片跑丢了" style="width: 100%">
          <img src="/static/images/ekuangDetails_3.png" alt="图片跑丢了" style="width: 100%"> -->
   
      </div>
		  

	<footer style="position: fixed;bottom: 0; height: 50px; line-height: 50px;width: 100%">

		<button type="text" class="" id="buy_bnt">
      <img src="/static/images/tel.png " width='30px'>
		</button>
		<button  id="purchase" type="text" style="background-color:#fd9131;color: #fff;font-weight: bold;">立即购买</button>
	<footer>
    	
    </div>
</body>






<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>	
<script type="text/javascript">
var agent_id=<?=json_encode($agent_id)?>; 
var goods_id=<?=json_encode($goods_id)?>; 

    function  Datas(obj,url){
     var csj_data;
    console.log(url);
         if(!obj){
            obj=''
         }
          $.ajax
           ({
               cache: false,
               async: false,
               type: 'get',
               data: obj,
               url: url,
               success: function (data) {
                if(typeof(data)=='string'){
                    data= eval('(' + data + ')');
                 }
                   csj_data = data;
                 }
           });
           //
            return csj_data;
         }
 var  obj= {
 	   agent_id:agent_id,
 	   goods_id:goods_id,
 }        
var $res=Datas(obj,'/index.php/water-shop/get-detail-data');
 console.log($res)


 var data=$res.images[0]; 
var tel=$res.tels; 


// var data = data[0];

//  // if(data.length==0){
//  //    
//  // }else{
var  _Img_Val=[];
    for(var i in data){
    	 if(data[i]){
    	 	_Img_Val.push(data[i]);
    	 	
    	 }
    }


// console.log(_Img_Val);


// console.log(_Img_Val.length);

if(_Img_Val.length>0){
         for(var i in _Img_Val){

   var image=_Img_Val[i]

           if(_Img_Val[i].indexOf("7xpcl7.com2.z0.glb.qiniucdn.com") != -1 ){
             image =   _Img_Val[i].replace('7xpcl7.com2.z0.glb.qiniucdn.com', 'image1.ebopark.com');
           }
         	 $("#imgUrl").append('<img src="'+image+'" alt="图片跑丢了" style="width: 100%">')
         }
}else{
  $(".empty_goods").show();
}
$('#buy_bnt').click(function(){
	    var telnum =tel[0]
	         var telHtml =''
	         if(telnum){
			   talnumData = [telnum.shop_tel1,telnum.shop_tel2]
                for(var i=0;i<talnumData.length;i++){
                        console.log(talnumData[i])
                     if(talnumData[i]!=''){
                     	// telHtml = telHtml +'<a href="tel:'+telnum[i]+'"><p id="">请拨打 :'+telnum[i]+'</p></a><br>';
                     	 telHtml +='<a href="tel:'+talnumData[i]+'"> <p style="background: url(/static/images/btnBgA.png) no-repeat center;background-size: 100% 100%;height: 50px;  border-radius: 50px;  line-height: 50px;">拨打：'+talnumData[i]+' </p></a> '
                     }
                     
                }

      	 var html ='<div style="width:250px;height:350px;background: #fff;border-radius: 15px;overflow: hidden;">' ;
      	     html +='<div  style="height:40px;width:100%;    position: relative;">';
      	     html +='<img src="/static/images/btnBgA.png" alt="" width="350px" style="margin-left: -30px;    margin-top: -11px;">'
      	     html +='   <div  class="cancel"  style="position: absolute;width:30px;height:30px;background: #fff;border-radius:50px;top:13px;right: 15px;text-align: center;">';
      	    html +='   	     <img src="/static/images/ridaus.png" alt="" width="12px;" style="margin-top: 10px;">';
      	    html +='   </div>';
      	    html +='</div>';
      	    html +=' <div style="width:100%;height:100px;padding:20px;text-align: center;  margin-top:15px;  box-sizing: border-box;">';
      	    html +='	  <img src="/static/images/telbfA.png" alt="" height="100%;" >';
      	    html +=' </div>';
      	    html +='  <div class="tel" style="text-align: center;padding: 0 20px 20px 20px;    margin-top: -20px;">'+ telHtml;
      	    html +='   </div>'
      	    html +='  <p class="cancel" style="  width: 80%; background: url(/static/images/btnBgC.png)  no-repeat  center;background-size: 100% 100%;height: 50px;   margin:auto;text-align: center;  border-radius: 50px; line-height: 50px;"> 取消 </p>'
      		html +='</div>';

		        var ii = layer.open({
		                      type: 1,
		                      skin: 'layui-layer-buy_bnt', //样式类名
		                      closeBtn: 0, //不显示关闭按钮
		                      // area: ['300px', '450px'], //宽高
		                      anim: 2,
		                      shade:  [0.8, '#000'],
		                      shadeClose: true, //开启遮罩关闭
		                      content:html
		           });
		        $(".tel p").hover(function(){
		        	   $(this).css('background','url(/static/images/btnBgB.png)  no-repeat  center;background-size: 100%  100%')
		        },function(){
 						$(this).css('background','url(/static/images/btnBgA.png)  no-repeat  center;background-size: 100%  100%')
		        })

		          $(".layui-anim").css("borderRadius",'50px');
		          $(".cancel").click(function(){
		               layer.close(ii);
		          })
	        	}

			});	
$('#purchase').click(function(){
	 var    html ='<div style="width:250px;height:300px;background: #fff;border-radius: 15px;overflow: hidden;">' ;
	     	html +='<div  style="height:40px;width:100%;    position: relative;">';
	   		html +='<img src="/static/images/btnBgA.png" alt="" width="350px" style="margin-left: -30px;    margin-top: -11px;">'
	    	html +='   <div  class="purchasecancel"  style="position: absolute;width:30px;height:30px;background: #fff;border-radius:50px;top:13px;right: 15px;text-align: center;">';
	    	html +='   	         <img src="/static/images/ridaus.png" alt="" width="12px;" style="margin-top: 10px;">';
	    	html +='   </div>';
	        html +='</div>';
	        html +=' <div style="width:100%;height:100px;padding:20px;text-align: center; margin-top:15px;   box-sizing: border-box;">';
	        html +='	  <img src="/static/images/Shopping.png" alt="" height="100%;" >';
	        html +=' </div>';
	        html +='  <div class="tel" style="text-align: center;padding: 0 20px;">';
	        html +=     '<p>此功能即将开通，敬请期待！	</p>'
            html +=         '<p class="purchasecancel"  style="background: url(/static/images/btnBgA.png)  no-repeat  center;background-size: 100%  100%;height: 50px;   border-radius: 50px; line-height: 50px;">  确定</p>'
	        html +='   </div>'
		    html +='</div>';
  var ii =layer.open({
          type: 1,
          skin: 'layui-layer-purchase', //样式类名
           // area: ['250px', '360px'], //宽高
          closeBtn: 0, //不显示关闭按钮

          	shade:  [0.8, '#000'],
          anim: 2,
          shadeClose: true, //开启遮罩关闭
                  content: html,
        });
          $(".tel .purchasecancel").hover(function(){
		        	   $(this).css('background','url(/static/images/btnBgB.png)  no-repeat  center;background-size: 100%  100%')
		        },function(){
 						$(this).css('background','url(/static/images/btnBgA.png)  no-repeat  center;background-size: 100%  100%')
		        })
        $(".layui-anim").css("borderRadius",'50px');
        $(".purchasecancel").click(function(){
               layer.close(ii);
          })
})


</script>
</html>