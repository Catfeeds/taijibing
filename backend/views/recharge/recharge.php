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
             <div class="pull-right" style="text-align: right;margin-bottom: 10px"> <?php
//                if($state==1){
//                   echo \yii\bootstrap\Html::a('返回',['recharge/see','fid'=>$fid],['class'=>'btn btn-primary']);
//                }else{
                    // echo \yii\bootstrap\Html::a('返回',['logic-user/factory-list'],['class'=>'btn btn-primary']);
//                }
                ?>
                        <a class="btn btn-primary" href="/index.php?r=logic-user/factory-list<?=$url?>">返回</a> 
                    
                </div>
       </div>
        <div class="ibox" style="border-radius: 3px;">
        
            <div class="ibox-content" style="border: none; border-radius: 5px;">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model, 'WaterBrand')->dropDownList(\yii\helpers\ArrayHelper::map($water_brands,'BrandNo','BrandName'),['prompt'=>'请选择品牌']) ?>
	                <div class='row' style="margin-top: 20px;margin-bottom: 20px">
                       <div  class="col-sm-2" style="text-align:right">
                       	      <span  style="margin-left: 80px;font-size: 14px">选择商品：</span>
                       </div>
	                 <div  class="col-sm-10">
	                 	<select id="add_goods" name='OrderSuccess[GoodsId]' style='width: 100%;
					    background: #363643;
					    border-color: rgb(229, 230, 231);'>
	                        <option value="">请选择商品</option>
	                     </select>
	                    <div class="help-block m-b-none"></div>
	                 </div>
	                </div>
                <?= $form->field($model, 'TotalMoney')->textInput(['id'=>'TotalMoney','maxlength' => 10 ,'placeholder' =>"单位：元"]) ?>
                 <input type="hidden"       name="OrderSuccess[Fid]" value="<?=$fid ?>"/>
                <!-- <div class="hr-line-dashed"></div> -->
                <?= $form->field($model, 'OrderMoney')->textInput(['id'=>'OrderMoney','maxlength' => 10,'placeholder' =>"单位：元"]) ?>
                <!-- <div class="hr-line-dashed"></div> -->
                <?= $form->field($model, 'CouponMoney')->textInput(['id'=>'CouponMoney','maxlength' => 10,'placeholder' =>"单位：元"]) ?>

                <div class="col-sm-12" style="margin-top: 20px;margin-bottom: 20px">
                    <span style="margin-left: 80px;font-size: 14px">容量：</span>
                    <span id="add_volume">
                     </span>
                    <div class="help-block m-b-none"></div>
                </div>
<!--            <div class="hr-line-dashed"></div>-->
                <!-- <div class="hr-line-dashed"></div> -->
                <?= $form->field($model, 'Amount')->textInput(['maxlength' => 10,]) ?>
                <!-- <div class="hr-line-dashed"></div> -->
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>    
<script>
    var BrandName='<?=$BrandName?>';
    var goodsname='<?=$goodsname?>';
    var Volume='<?=$Volume?>';
    var brands='<?=json_encode($brands)?>';

</script>
<script>




$('.form-group .btn-primary').click(function(){
    if($("#ordersuccess-amount").val()<=0){
    layer.msg('购买数量不能小于0');
        return false;
    }
})

// if(BrandName){
//     $("#ordersuccess-waterbrand").val(BrandName).trigger("chosen:updated");
// }

if( BrandName&&goodsname&& Volume){
        var ordersucces=$("#ordersuccess-waterbrand option")
        optionText( ordersucces,BrandName)
        var BrandNo=$('#ordersuccess-waterbrand  option:selected').val();
        initOrdersuccess(BrandNo)
}



//解决bug充值界面进行一组错误的数据保存后，商品下拉框显示不出当前品牌下的商品
var BrandNo2=$('#ordersuccess-waterbrand  option:selected').val();
if(BrandNo2){
    initOrdersuccess(BrandNo2)
}
$("#ordersuccess-waterbrand").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
$("#add_goods").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen



function  optionText( $id, $data){
       var ordersuccessNUm=$id
        for(var i=0 ;i<ordersuccessNUm.length;i++){
        var ordersuccessOption=ordersuccessNUm.eq(i).text()
        if(ordersuccessOption==$data){
           ordersuccessNUm.eq(i).attr( "selected","selected" )
        }
     // 
    }
}
 //当品牌改变时获取对应的商品
    $('#ordersuccess-waterbrand').change(function(){
              var BrandNo=$(this).val();
            if(BrandNo==''){
                $("#add_goods").empty().append("<option value=>请选择商品</option>").trigger("chosen:updated");
                return ;
            }

              initOrdersuccess(BrandNo)
    });
function  initOrdersuccess(BrandNo){

            $.get('./index.php?r=recharge/get-goods',{'BrandNo':BrandNo},function(data){
                if(data){
                    
                    $("#add_goods").html('');
                    var html="<option value='' selected='selected'>请选择商品</option>";
                    $(data).each(function(i,v){
                        html+="<option value='"+ v.id+"'>"+ v.name+"</option>"
                    });
                  // console.log(html)
                    $('#add_goods').append(html).trigger("chosen:updated");

                }else{
                     $("#add_goods").html("<option value='' selected='selected'>请选择商品</option>");
                     $('#add_goods').trigger("chosen:updated");
                }
                if(goodsname){
                    var ordersucc=$("#add_goods option")
                    optionText( ordersucc,goodsname)
                    initAdd_goods()
                }
            });
        }
        //选择商品改变时，对应选择容量改变
        function   initAdd_goods(){
             var name=$('#add_goods option:selected').text();

            var BrandNo=$('#ordersuccess-waterbrand  option:selected').val();
            $.get('./index.php?r=recharge/get-volume',{'BrandNo':BrandNo,'name':name},function(data){
                if(data){
                    $("#add_volume").html('');
                    var html='';
                    $(data).each(function(i,v){
                        if(v.volume){
                            html+="<label style='margin-left: 40px'><input type='radio' name='OrderSuccess[Volume]' value='"+ v.volume+"'>"+ v.volume+"L</label>"
                        }
                    });
                    $('#add_volume').append(html);
                      $('#add_goods').trigger("chosen:updated");
                }else{
                    $("#add_volume").html('');
                     $('#add_goods').trigger("chosen:updated");
                }
                if(Volume){
                    var add_volume=$("#add_volume input")
                      for(var i=0 ;i<add_volume.length;i++){
                        var VolumeOption=add_volume.eq(i).val()
                        if(VolumeOption==Volume){
                           add_volume.eq(i).attr( "checked","checked" )
                        }
                    }
                }
            });
}
        $('#add_goods').change(function(){
               initAdd_goods()
        });

//    }

    $('#CouponMoney').attr("readOnly","true");
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

 
</script>
