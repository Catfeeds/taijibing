<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport"  content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">

    <meta charset="utf-8"/>
  <title>电子水票</title>
  <link rel="stylesheet" type="text/css" href="/static/js/layer.mobile-v2.0/layer_mobile/need/layer.css">
</head>
<style type="text/css" media="screen">
    *{
        padding: 0;margin:0;
    }
    body{
      background: #f3f3f3
    }
    .nav{
    width: 100%;
    font-size: 15px;
    line-height: 30px;
    background: #fff;
    }
    .regNav{
        display: inline-block;
        width: 30%;
        height: 30px;
        text-align: center;
        font-weight: bold;
        position: relative;
        font-size: 10px;
        font-size:0.9rem;
    }
    .regNav > img{
    position: absolute;
    width: 8px;
    right: -10px;
    top: 6px;
    }
        .nav .ativer{
        color:#FF662E;
    }
    .conter{
      padding: 15px;
      box-sizing: border-box;
    }
    .conter input,    .conter select{
      width: 100%;
      height: 30px;margin-top:10px;    border: none;
      text-indent: 10px;
    }
        .conter input{
          width: -webkit-calc(100% - 40px);width: -moz-calc(100% - 40px);width: calc(100% - 40px);
        }

             .conter   label{
    width: 40px;
    text-align: center;
    display: inline-block;
  }
#DetermineP{
    width: 100%;
    height: 40px;
background: rgb(221, 221, 221);
    margin-top: 40px;
    text-align: center;
    line-height: 40px;
    font-size: 20px;
    font-weight: bold;
    color:#fff;
    }
 select, input{
      font-size: 13px;
    }
</style>
<body>
       <div class="nav">
       <p> 
            <span class='regNav'>
                1.填写基本信息
                <img src="/static/images/you5.png" alt="">
            </span>
            <span class='regNav'>
               2.输入设备信息
                 <img src="/static/images/you5.png" alt="">
            </span>
            <span class='regNav ativer'>
               3.完成登记
            </span>
        </p>
      </div>

    
        
     <div class="conter">
     	
       <select id="pay_type"  name='pay_type'>
          <option value="1" >现金</option>
        <!--  <option value="2" >微信</option>
          <option value="3" >支付宝</option>-->
      </select>
      <br/>
      <input id="money" class='view-list' type="number" name="" value="" placeholder="充值金额"><label>元</label>
      <select id="water_brand" class='view-list'  name='water_brand'><option value="" >请选择品牌</option></select>
      <select id="water_goods" class='view-list'  name="water_goods"><option value="" >请选择商品</option></select>
      <select id="water_volume" class='view-list'  name = "water_volume"><option value="" >请选择容量</option></select>
      <input type="number" readonly unselectable="on" id="water_price"  placeholder="单价" name="water_price" value="" ><label>元</label>
     <input type="number"  class='view-list'  id="water_stock_name"  style="width: -webkit-calc(100% - 70px);width: -moz-calc(100% - 70px);width: calc(100% - 70px);"  placeholder="送水数量"   name="water_stock" value="" ><label style="width:70px;">库存 <span id='water_stock' >0</span></label>
     <input type="number"  class='view-list'  id="use_money" readonly unselectable="on"  placeholder="合计金额" name="use_money" id="use_money" value="" ><label>元</label>
     <input type="number"  readonly unselectable="on"  placeholder="剩余金额" name="" class="rest_money view-list" value="" ><label>元</label>
          <p style="clear:both;" id='DetermineP'>下一步</p>
     </div>

</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script> 

var datas =   JSON.parse(<?=json_encode($datas) ?>);
// console.log(datas)
var data=<?=json_encode($data)?>;
console.log(data)

$(function(){
       $("#money").change(function(event) {
       /* Act on the event */
             if($(this).val()<=0){
              
                layer.open({
                content: '金额不能小于1'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
              });
                $(this).val(1)
                return
              }

     });

       
    if(datas.water_brand){

      console.log(datas.water_brand)
        var cityOpts = "";
          $('#water_brand').empty();
          $('#water_brand').append('<option value="">请选择品牌</option>')
        $.each(datas.water_brand, function (index, item) {
               if(item){
                cityOpts += "<option value='" + item.BrandNo + "'>" + item.BrandName + "</option>";
               }
              // htnl+='<option value='+item.BrandNo+' >'+item.BrandName+'</option>';
        }); 
           $(cityOpts).appendTo('#water_brand')
    }
    if(datas.water_goods){
      $('#water_brand').change(function(){
          var _thisVal= $(this).val();
           var cityOpts = "";
            $('.conter input:not(:first)').val('')

             $('#water_goods').empty()
             $('#water_volume').empty()
                $('#water_goods').append('<option value="">请选择商品</option>')
                $('#water_volume').append('<option value="">请选择容量</option>')
            $.each(datas.water_goods, function (index, item) {
                   if(item.brand_id ==_thisVal ){
                    cityOpts += "<option value='" + item.name + "'>" + item.name + "</option>";
                   }
            }); 

          $(cityOpts).appendTo('#water_goods')
      })
    }
    if(datas.water_volume){

      $('#water_goods').change(function(){
          var _thisVTxt = $('#water_goods option:selected').text();
          var _brandVal= $('#water_brand').val();
                  $('.conter input:not(:first)').val('')
           var cityOpts = "";
           $('#water_volume').empty()
           $('#water_volume').append('<option value="">请选择容量</option>')
            $.each(datas.water_volume, function (index, item) {
                   if(item.brand_id ==_brandVal&&item.name ==_thisVTxt){
                    cityOpts += "<option value='" + item.volume + "'>" + item.volume + "</option>";
                   }
            }); 
              $(cityOpts).appendTo('#water_volume')
      })

    }

     $('#water_volume').change(function(){
        var brandVal = $('#water_brand').val();
        var goodsVal = $('#water_goods').val();
        var volumeVal  = $('#water_volume').val();
        $('.conter input:not(:first)').val('')
        

        $.get('stock-price-when-register?brand_id='+brandVal+'&water_name='+goodsVal+'&water_volume='+volumeVal, function(data) {
          /*optional stuff to do after success */

          var data =  JSON.parse(data)
          // console.log(data)
            if(data.datas){
              $("#water_price").val(data.datas.water_price);
              $("#water_stock").text(data.datas.water_stock);
            }

        });


       $("#money").change(function(event) {
       /* Act on the event */
        $(this).val (Math.round( $(this).val()*100)/100)
    
        // $('.conter input:not(:first)').val('')

        var _val = $(this).val();
        var _water_price_val = $("#water_price").val();
        var _use_money_val = $("#use_money").val();

        if(_water_price_val){
           $(".rest_money").val (_val - _use_money_val);
        }



     });
      $("#water_stock_name").change(function(){

      
         var _val = $(this).val();
         var _val_stock = $("#water_stock").text();
         var _money =  $("#money").val()

         if(!_money){
              layer.open({
                    content: '充值金额不能为空'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                  });
         }
          if(_val*1>_val_stock*1){

                 layer.open({
                    content: '送水数量不能大于库存数量'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                  });
             $(this).val(_val_stock) 
          }
          var water_price = $("#water_price").val();
          var water_stock_name = $("#water_stock_name").val();
          $("#use_money").val(water_stock_name*water_price);
          $("#use_money").val (Math.round(water_price*water_stock_name*100)/100);
          $(".rest_money").val (_money - Math.round(water_price*water_stock_name*100)/100);
      })
     })

  $("#DetermineP").click(function(){
      var obj = {
         pay_type:$("#pay_type").val()||'',
         pay_money:$("#money").val()||'',
         brand_id:$("#water_brand").val()||'',
         water_name:$("#water_goods").val()||'',
         water_volume:$("#water_volume").val()||'',
         amount:$("#water_stock_name").val()||'',
         price:$("#water_price").val()||'',
         use_money:$("#use_money").val()||'',
         rest_money:$(".rest_money").val()||'',
         data:data
      }



      // console.log(obj);
           var dataof  = $(this).attr('dataof')
      $.get('save-account',obj, function(data) {
        /*optional stuff to do after success */
          var data =  JSON.parse(data)
          // console.log(data)
          if(data.state==-1){
                  //  layer.open({
                  //   content: data.mas
                  //   ,skin: 'msg'
                  //   ,time: 2 //2秒后自动关闭
                  // });
                   //信息框
            layer.open({
              content: data.mas
              ,btn: '确定'
              ,yes: function(index){
               location.href='register'; 
              }   
            });
                // location.href='index'; 
             return;
          }
        if(data){
           // console.log(data)
             var DevNo = data.code;
             var BrandName = data.BrandName;
             var GoodsName = data.GoodsName;



            if(!dataof){
              $(this).attr('dataof',1)
               // window.location.href="create-account?"+$.param(params);
                location.href='activate?code='+DevNo+'&BrandName='+BrandName+'&GoodsName='+GoodsName; 
            }
                 
        }
   
 

      });

  })


})

$('input,select').bind('input porpertychange',function(){
       var index = $(".view-list").length;

         for(var i=0;i<index-2;i++){
            if( !$(".view-list").eq(i).val()){
               $("#DetermineP").css("background",'#ddd');
               return;
            }
             $("#DetermineP").css({"background":" url(/static/images/brnW.png) no-repeat",'background-size':' 100% 100%'});
        }
  });
</script>
</html>