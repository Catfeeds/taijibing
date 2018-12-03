<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */
use feehi\widgets\ActiveForm;
$this->title = "";
?>
    <link rel="stylesheet" href="./static/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="./static/css/style.min862f.css"/>
    <link rel="stylesheet" href="./static/css/chosen.css"/>
   <link rel="stylesheet" href="./static/css/Common.css?v=1.0"/>
<style type="text/css" media="screen">
	#CouponMoney{
	background: #363643;
	}
    body{
        padding:10px;
    }
    input{
    text-align: left;
    background-color: #2D3136;
    }
    .chosen-container.chosen-with-drop .chosen-drop{
        width: 100%;
    }
    .form-control, .single-line {
    background-color: #363643;
    background-image: none;
    border: 1px solid #666;
    border-radius: 1px;
    color: inherit;
    display: block;
    padding: 6px 12px;
    -webkit-transition: border-color .15s ease-in-out 0s, box-shadow .15s ease-in-out 0s;
    transition: border-color .15s ease-in-out 0s, box-shadow .15s ease-in-out 0s;
    width: 100%;
    font-size: 14px;
}
.btn-white {
    color: inherit;
    background: #363643;
    border: 1px solid #e7eaec;
}
</style>
<div class="row">
    <div class="col-sm-12">
         <div style="padding:10px 30px">
             <img src="/static/images3/sidebar.png" alt="" width=20 >
             <span class="font-size-S">&nbsp;充值</span>
             <div class="pull-right" style="text-align: right;margin-bottom: 10px">
                 <a class="btn btn-primary returnA" href="/index.php?r=supplier/list<?=$url?>">返回</a>
            </div>
       </div>
        <div class="ibox" style="border-radius: 3px;">
        
            <div class="ibox-content" style="border: none; border-radius: 5px;">



                <div  class="form-horizontal" > 

                    <div class="form-group field-ordersuccess-waterbrand">
                        <label class="col-sm-2 control-label" for="ordersuccess-waterbrand">选择品牌</label>
                        <div class="col-sm-10">
                            <select name="BrandId" id='BrandId'>
                                <option value="">选择品牌</option>
                            </select>
                        </div>

                    </div>                  
                    <div class="row" style="margin-top: 20px;margin-bottom: 20px">
                        
                         <label class="col-sm-2 control-label" for="ordersuccess-waterbrand">选择商品</label>
                        <div class="col-sm-10">
                            <select name="GoodsId" id="GoodsId">
                                <option value="">选择商品</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group field-TotalMoney">
                          <label class="col-sm-2 control-label" for="TotalMoney">应付金额</label>
                    <div class="col-sm-10">
                        <input type="text" id="TotalMoney" class="form-control" name="" maxlength="10" placeholder="单位：元">
                        <div class="help-block m-b-none"></div>
                    </div>

                    </div>                 
                    <!-- <input type="hidden" name="OrderSuccess[Fid]" value="31"> -->
                    <!-- <div class="hr-line-dashed"></div> -->
                    <div class="form-group field-OrderMoney">
                    <label class="col-sm-2 control-label" for="OrderMoney">支付金额</label>
                    <div class="col-sm-10"><input type="text" id="OrderMoney" class="form-control" name="OrderSuccess[OrderMoney]" maxlength="10" placeholder="单位：元">
                    <div class="help-block m-b-none"></div></div>

                    </div>                <!-- <div class="hr-line-dashed"></div> -->
                    <div class="form-group field-CouponMoney">
                    <label class="col-sm-2 control-label" for="CouponMoney">优惠金额</label>
                    <div class="col-sm-10"><input type="text" id="CouponMoney" class="form-control" name="OrderSuccess[CouponMoney]" maxlength="10" placeholder="单位：元" readonly="readonly">
                    <div class="help-block m-b-none"></div></div>

                    </div>
                    <div class="col-sm-12" style="margin-top: 20px;margin-bottom: 20px">
                    <span style="margin-left: 80px;font-size: 14px">规格：</span>
                    <span id="add_volume"><label style="margin-left: 40px"><input type="radio" name="OrderSuccess[Volume]" value="0" checked="checked">0L</label></span>
                    <div class="help-block m-b-none"></div>
                    </div>
                    <!--            <div class="hr-line-dashed"></div>-->
                    <!-- <div class="hr-line-dashed"></div> -->
                    <div class="form-group field-ordersuccess-amount">
                    <label class="col-sm-2 control-label" for="ordersuccess-amount">购买数量</label>
                    <div class="col-sm-10"><input type="text" id="ordersuccess" class="form-control" name="OrderSuccess[Amount]" maxlength="10">
                    <div class="help-block m-b-none"></div></div>
                    </div>                <!-- <div class="hr-line-dashed"></div> -->
                    <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                    <button class="btn btn-primary submit" type="submit">保存</button>
                    <!-- <button class="btn btn-white" type="reset">重置</button> -->
                    </div>

                    </div>            
                </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>
    <script type="text/javascript" src="/static/js/Common2.js?v=1.1"></script> 
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>    
<script>
       var brands =<?=json_encode($brands)?>;
       var goods =<?=json_encode($goods)?>;
       var Volume =<?=json_encode($Volume)?>;
       var logic_type =<?=json_encode($logic_type)?>;
       var Fid =<?=json_encode($Fid)?>;
       var BrandId =<?=json_encode($BrandId)?>;
       var GoodsId =<?=json_encode($GoodsId)?>;
       var url ='<?=$url?>';

       // console.log(Volume);

       if(Volume=='--'){
        Volume==''
       }

</script>
<script>
// 设备品牌型号
addresEquipmente({
     devbrand:'BrandId',
     devbrand_data:brands,
     devname:'GoodsId',
     devname_data:goods,
     where:{
        devbrand:BrandId,
        devname:GoodsId
     }
});
  var goodsd =   $("#GoodsId option:selected").text();
  // if(logic_type==1){

    // console.log(BrandId)
    // console.log(goodsd)
  init_volume(BrandId,goodsd)
  // }else{
  //   // $("#add_volume").parent('.col-sm-12').hide();
  // }


  


$('select').change(function(event) {
    /* Act on the event */
      var brand =   $("#BrandId").val();
        var goods =  $("#GoodsId option:selected").text();
      // if(brand&&goods&&logic_type==1){
        init_volume(brand,goods)
      // }
    // $("#add_volume").html('');

});

 //自动计算优惠金额
    $('#TotalMoney').blur(function(){
        free()
    });
    $('#OrderMoney').blur(function(){
        free()
    });
    function free(){
        var t=$('#TotalMoney');
        var o=$('#OrderMoney');
        var TotalMoney=t.val();//应付
        var OrderMoney=o.val();//实付金额
        checknum(TotalMoney,t);
        checknum(OrderMoney,o);
        var CouponMoney=TotalMoney-OrderMoney;//优惠金额
        $('#CouponMoney').val(CouponMoney);//优惠金额

    }
    function checknum(num,obj) {
        if (isNaN(num)) {
            alert("请输入数字");
            obj.val('');
            obj.focus();
            return false;
        }
    }

function init_volume(BrandId,GoodsId){
    // console.log(BrandId)
    // console.log(GoodsId)
      $.get('./index.php?r=supplier/get-volume',{'BrandId':BrandId,'GoodsName':GoodsId},function(data){
           if(typeof(data)=='string'){
                data=  jQuery.parseJSON(data);
           }
            // console.log(data)
           if(data.state==-1){
              layer.msg(data.msg);
              return;

           }else{
            

                $("#add_volume").html('');
                var html='';
                $(data.volume).each(function(i,v){
          // console.log(v.volume)
                    if(v.volume){

                            if(Volume==v.volume*1){
                                html+="<label style='margin-left: 40px'><input type='radio' checked name='volume' value='"+ v.volume*1+"'>"+ v.volume*1+ v.unit+"</label>"
                            }else{

                                 // console.log(Volume)
                                    html+="<label style='margin-left: 40px'><input type='radio' name='volume' value='"+ v.volume+"'>"+ v.volume*1+ v.unit+"</label>"
                            }
                 
                    }
                });
 // console.log(html)
                $('#add_volume').append(html);


           }

      })
}

function goodsopi(string){
// console.log(string)
var typel=''
 for(var i=0;i<goods.length;i++){
       var item =goods[i] ;
       // console.log(item.brand_id)

       if(item.id==string){
          typel=item.category_id

// console.log(item.id);


       }

  }  
  return typel; 
}


$(".submit").click(function(){


if($("#ordersuccess").val()<=0){
    layer.msg('购买数量不能小于0');
      return false;
    }

    var obj={
        Fid:Fid,
        logic_type:logic_type,
        BrandId:$("#BrandId").val(),
        GoodsName:$("#GoodsId option:selected").text(),
        TotalMoney:$("#TotalMoney").val(),
        OrderMoney:$("#OrderMoney").val(),
        CouponMoney:$("#CouponMoney").val(),
        Amount:$("#ordersuccess").val(),
    }
//BrandId
var  logic_typeop = goodsopi($("#GoodsId").val());
 // console.log($("#GoodsId").val())
 // console.log(logic_typeop)
// if(logic_typeop==1){
    obj.Volume =$("#add_volume input[type='radio']:checked").val();
// }

// console.log(obj)

   for (var z in obj) {
      if (obj[z] == null||obj[z]==undefined||obj[z]=='') {
          layer.msg("参数不完全");
              return;
      }
    }
    // console.log(obj)
       $.get('./index.php?r=supplier/save-recharge',obj,function(data){
        if(typeof(data)=='string'){
             data=  jQuery.parseJSON(data);
           }
           // console.log(data)
            if(data.state==0){
                //询问框
              layer.open({
                content: '保存成功'
                ,btn: ['确定']
                ,yes: function(index){
                  window.location.href=$(".returnA").attr('href')+url;
                  layer.close(index);
                }
              });
                // window.location.href=$(".returnA").attr('href');
            }else{
            layer.msg(data.msg);
           }
       })
})



</script>
