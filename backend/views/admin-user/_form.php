<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;

$this->title = "Admin";
?>

<!DOCTYPE html>
<html style="overflow-x:hidden;overflow-y:hidden">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="X-UA-Compatible"content="IE=9; IE=8; IE=7; IE=EDGE">
    <link rel="stylesheet" href="./static/js/zui/css/zui.css"/>
    <link rel="stylesheet" href="./static/js/zui/css/style.css"/>
    <link rel="stylesheet" href="./static/css/addgood.css"/>
    <link rel="stylesheet" href="./static/css/updategood.css"/>
    <link rel="stylesheet" href="./static/js/jedate/skin/jedate.css"/>
    <link rel="stylesheet" href="./static/js/datepicker/dateRange.css"/>
    <link rel="stylesheet" href="./static/js/page/jquery.pagination.css"/>

    <link rel="stylesheet" href="./static/css/plugins/toastr/toastr.min.css"/>

    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">

    <style>
        body{
        width:100%;
        height:100%;
        overflow: auto;
        background: #363643;
        color: #fff;
        }

        .form-control {
        background-color: #1d1f23 !important; ;
        color: #fff;
        }
        select,option{
        color: #fff;
        }

        .form-control {
        background-color: #363643 !important; ;
        color: #fff;
        }
        datalist,datalist option{
        background-color: #2D3136;
        }
        .btn-white{
        display: initial;
        }
        .chosen-container{
                width: initial !important;
                min-width: 150px;
          
        }

     
</style>
</head>
<body >
    
<div class="row">
    <div class="col-sm-12">
        <div class="ibox" style='padding:20px;    min-height: 900px;'>
            <div style="text-align: right;margin-bottom: 10px;margin-top: 20px;margin-right: 15px;"> 
            <?= \yii\bootstrap\Html::a('返回',['admin-user/index'],['class'=>'btn btn-info'])?> 
                                <!-- <a class="btn btn-primary" href="/index.php?r=admin-user/index<?=$url?>">返回</a> -->
                </div>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model['model'], 'url')->textInput(['maxlength' => 64,'id'=>'lb'])->hiddenInput()->label(false); ?>
                <?= $form->field($model['model'], 'name')->textInput(['maxlength' => 64,'placeholder'=>"请输入公司名称"])->label('账户名称') ?>
                <?= $form->field($model['model'], 'contacts')->textInput(['maxlength' => 64,'placeholder'=>"请输入姓名"])->label('联系人') ?>
                <?= $form->field($model['model'], 'tel')->textInput(['maxlength' => 12,'placeholder'=>"请输入手机号或座机号"])->label('联系电话') ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model['model'], 'username')->textInput(['maxlength' => 11,'placeholder'=>"请输入登陆账号（最多11位）"])->label('登陆账号') ?>
                <?= $form->field($model['model'], 'password')->textInput(['maxlength' => 512,'placeholder'=>"请输入密码"])->label('登陆密码') ?>
                <?= $form->field($model['model'], 'repassword')->textInput(['maxlength' => 512,'placeholder'=>"请确认密码"])->label('确认密码') ?>
                <!-- <?= $form->field($model['model'], 'password')->passwordInput(['maxlength' => 512,'placeholder'=>"请输入密码"])->label('登陆密码') ?> 
                <?= $form->field($model['model'], 'repassword')->passwordInput(['maxlength' => 512,'placeholder'=>"请确认密码"])->label('确认密码') ?>-->
                <?= $form->field($model['model'], 'email')->textInput(['maxlength' => 64,'placeholder'=>"请输入邮箱"]) ?>
                <div class="hr-line-dashed"></div>
                <!--地址-->
                <div class="form-group field-adminroleuser-role_id required" style="margin-bottom: 80px">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">地址</label>
                    <div class="col-sm-10" id="check_address">
                        <select class="control-label" name="User[province]" id="province" style="width:150px;margin-right: 20px;   color: #fff;">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="User[city]" id="city" style="width:150px;margin-right: 20px;   color: #fff;">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="User[area]" id="area" style="width:150px;margin-right: 20px;   color: #fff;">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>
                <div class="item"  style="margin-bottom: 15px;">
                    <div class="ftitle"><span class="title"> </span></div>
                    <div class="fcontent" style="padding-left: 0;padding: 5px 0;">
                        <input id="address" name="User[address]" type="text" class="baseinput" placeholder="请输入详细地址"/>
                        <!--                        <input type="button"  class="btn select_btn" style="height: 26px;margin-bottom: 5px;line-height: 15px;margin-left: 0px" value="+标记位置" onclick="get_lat_lng()"/>-->
                        <input type="button"  class="btn select_btn" style="    background: #2d3136;height: 26px;margin-bottom: 5px;line-height: 15px;margin-left: 0px" value="+标记位置" onclick="openMark()"/>
                        <span>经度：</span>

                        <input id="lng" name="User[lng]" readonly unselectable="on" type="text" class="baseinput" style="width: 80px"/>

                        <span>纬度：</span>

                        <input id="lat" name="User[lat]" readonly unselectable="on" type="text" class="baseinput" style="width: 80px"/>
                        <span class="mark">（用于部分商品前端显示距离）</span>
                    </div>
                </div>

                <!--账户类型-->
                <div class="form-group field-adminroleuser-role_id required" style="margin-bottom: 180px;">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">账户类型</label>
                    <div class="col-sm-2">
                        <select class="control-label" name="User[type]" id="type" style="width:150px;margin-right: 20px">
                            <option  value="">请选择</option>
                            <option value="管理员">管理员</option>
                            <option value="供应商">供应商</option>
                            <option value="设备厂家">设备厂家</option>
                            <option value="运营中心">运营中心</option>
                            <option value="服务中心">服务中心</option>
                            <option value="设备投资商">设备投资商</option>
                            <option value="片区中心">片区中心</option>
                            <option value="酒店中心">酒店中心</option>
                        </select>
                    </div>
                    <div id="parent" style="display: none">
                        <label class="col-sm-2 control-label" for="adminroleuser-role_id">所属运营中心</label>
                        <div class="col-sm-2">
                            <select class="control-label" name="User[agent]" id="agent" style="width:150px;margin-right: 20px">
                                <option value="">请选择</option>
                            </select>
                        </div>
                    </div>
                    <div id="belong" >
                        <div style="display: block">
                            <label class="col-sm-2 control-label" for="adminroleuser-role_id">所属片区中心</label>
                            <div class="col-sm-2">
                               <select  name="User[area_center]"  style="width: 150px;" id="dept" class="dept_select"> 
                                    <option value="">无</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <br/>
                <br/>
                <!--
                <div style='clear:both'>
                    <label class='col-sm-2 control-label'>编号</label>
                    <div class='col-sm-10'>
                        <input type="text"  class="form-control" disabled = 'disabled' maxlength="64" placeholder="请输入编号" aria-required="true">
                    </div>
                </div>-->
                     <style type="text/css" media="screen">
                        .btn{
                            margin-top:50px;
                        }

                     </style>


                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<!--<p class='jiuo123'>  测试</p>-->

<div id="qrcode">

</div>

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="./static/js/plugins/toastr/toastr.min.js"></script> -->


<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
<script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
<script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>

<script type="text/javascript" src="./static/js/pinyin.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>
<script type="text/javascript" src="./static/js/qrcode.js"></script>
<script type="text/javascript" src="./static/js/good/updategood.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>

<script type="text/javascript" src="./static/js/zui/js/zui.js"></script>
<script type="text/javascript">

    var category='';
    var merchant='';
    var baseGood='';
    var sms='';
    var data=<?=$model["data"]?>;
    var province='<?=$model["model"]["province"]?>';
    var city='<?=$model["model"]["city"]?>';
    var area='<?=$model["model"]["area"]?>';
    var address='<?=$model["model"]["address"]?>';
    var lat='<?=$model["model"]["lat"]?>';
    var lng='<?=$model["model"]["lng"]?>';
    var type='<?=$model["model"]["type"]?>';
    var agent='<?=$model["model"]["agent"]?>';
    var role_id=<?=$model["role_id"]?>;
    var name='<?=$model["name"]?>';
    var area_center='<?=$model["model"]["area_center"]?>';

    var msg='<?=$model["msg"]?>';
// console.log(agent)
// 地址渲染 


addressResolve(data,province,city,area);

customertypea({
    name:'type',
    where:type
})
$('.dept_select').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
if(area_center){
    $('#belong').css("display",'block');
   $("#dept").val(area_center)
$('.dept_select').trigger("liszt:updated");
}
</script>
<script type="text/javascript">
    $("#initamount").onlyNum();
</script>
<script>
 $('#agent').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
// 
// $("#agent").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen

    $('#address').val(address);
    $('#lng').val(lng);
    $('#lat').val(lat);
    $('#type').val(type);
// alert(type)
    if(type=='服务中心'||type=='酒店中心'){
        $('#parent').show();

        $('#agent').append("<option selected='selected' value="+agent+">"+agent+"</option>");
        $('#agent').trigger("chosen:updated");
    }

    if(role_id!=3||role_id!=7){
        //选择地址改变时
        $('#check_address select').change(function(){
            $('#type').val('');
            $('#parent').hide();
            $('#belong').hide();
        });
    }
    //账户类型改变时
    $('#type').change(function(){

//        if(data=='服务中心'){
        //获取地址
        var province=$('#province option:selected').attr('value');
        var city=$('#city option:selected').attr('value');
        var area=$('#area option:selected').attr('value');

        if(province==''){
            alert('请选择地址');
            $('#type').val('');
        }else{

            var data=$('#type option:selected').attr('value');

            if(data=='服务中心'||data=='酒店中心'){
                //获取符合该地址的所有运营中心
                var dataobj = data;
                $.get('./?r=admin-user/get-agent',{'province':province,'city':city,'area':area},function(data){
                      // console.log(data)
                    if(data!=''){
                        $("#agent").html('');
                        var html="<option value=''>请选择</option>";
                        $(data).each(function(i,v){
                        html+="<option value="+ v.Name+">"+ v.Name+"</option>";
                        });
                        $(html).appendTo("#agent");
                        $('#agent').trigger("chosen:updated");

                        $('#belong').show();
                        $("#dept_chosen").css('width','150px')
                        $('#parent').show();
                    }
                    if(data==''){
                        $("#agent").html('');
                        html="";
                          for(var i =0;i<data.length;i++){
                             html+="<option value='"+data[i].Name+"'>"+data[i].Name+"</option>"
                          }
                        $(html).appendTo("#agent");
                         $('#agent').trigger("chosen:updated");
                        $('#parent').show();
                        $('#belong').show();
                        $("#dept_chosen").css('width','150px')
                          //$('#belong').show();
                    }
                });
            }else if(data=='片区中心'){


                   $.get('./?r=admin-user/get-agent',{'province':province,'city':city,'area':area},function(data){
                    // console.log(data)
                        if(data){
                        $("#agent").html('');
                          html="";
                        for(var i =0;i<data.length;i++){
                               html+="<option value='"+data[i].Name+"'>"+data[i].Name+"</option>"
                        }
                        $(html).appendTo("#agent");

                         $('#agent').trigger("chosen:updated");
                        $('#parent').show();
                        $('#belong').hide();
                        $("#dept_chosen").css('width','150px')
                          //$('#belong').show();
                    }
                   })
            }

            else{
                $('#agent').val('');
                      $('#agent').trigger("chosen:updated");
                $('#parent').hide();
                $('#belong').hide();
            }


        }
//        alert(data);
    });


    $(function(){
         init();
// alert(454)
 });

    function initAddress(){
        $("#province").val(province);
        initCityOnProvinceChange();
        $("#city").val(city);
        initThree();
        $("#area").val(area);
    }
    function getAddressIdByName(_name){
        _name= $.trim(_name);
        if(_name==""){
            return 0;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            var name= $.trim(item.Name);
            if(name!=""&&name==_name){
                return item.Id;
            }
        }
        return 0;
    }
    function initListener(){
        $("#province").on("change",function(){
            initCityOnProvinceChange();
        });
        $("#city").on("change",function(){
            initThree();
        });
    }
    function initCityOnProvinceChange(){
        var pid=getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#area").empty();
        $("#area").append("<option value=''>请选择</option>");
        $("#city").append("<option value=''>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#city").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
                initThree()
            }
        }
    }
    function initThree(){
        var pid=getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value=''>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#area").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }
    function initProvince(){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId==0){
                $("#province").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }



    //获取经纬度
    function get_lat_lng(){
        var address = $('#address').val();

        if(!address) {
            alert('请输入详细地址');
        }else {


            // 创建地址解析器实例
            var myGeo = new BMap.Geocoder();
            // 将地址解析结果显示在地图上,并调整地图视野
            myGeo.getPoint(address, function (point) {
//                var lg = JSON.parse(JSON.stringify(point)).lng;
//                var lt = JSON.parse(JSON.stringify(point)).lat;

                //将经纬度写进input框
                if(JSON.parse(JSON.stringify(point))==null||JSON.parse(JSON.stringify(point))==null){
                    alert('请输入有效地址');
                    $('#address').val('');
                    $('#address').focus();
                    return false;
                }else{
                    var lg = JSON.parse(JSON.stringify(point)).lng;
                    var lt = JSON.parse(JSON.stringify(point)).lat;

                    $('#lng').val(lg);
                    $('#lat').val(lt);
                }
//        $('#shopcoord').val(JSON.stringify(point));
            }, "成都市");

        }
    }
    function init(){
        var data=$('#type option:selected').attr('value');

        if(data=='服务中心'||data=='酒店中心'&&role_id!=3){//运营中心登陆不执行

            //获取符合该地址的所有运营中心
            $.get('./?r=admin-user/get-agent',{'province':province,'city':city,'area':area},function(data){
                // console.log(data)
                if(data!=''){
                    $("#agent").html('');
                    var html="<option value=''>请选择</option>";
                    $(data).each(function(i,v){
                        html+="<option value="+ v.Name+">"+ v.Name+"</option>";
                    });
                   $(html).appendTo("#agent");
                         $('#agent').trigger("chosen:updated");
                    $('#parent').show();
                }
                if(data==''){
                    $("#agent").html('');
                    html="<option value='太极兵运营中心'>太极兵运营中心</option>";
                    $(html).appendTo("#agent");
                          $('#agent').trigger("chosen:updated");
                    $('#parent').show();
                }
            });
        }else{
          $('#belong').hide();
        }
        $(".btn-primary").click(function(){
             var agentVal =  $('#agent').val();
             var deptVal  =  $('#dept').val();
             var data=$('#type option:selected').attr('value');
             if( data=='酒店中心'){
                 // alert(data)
            
                   if(!agentVal&&agentVal==''){
                       layer.msg('请选择运营中心')
                    return false;
                   }
                  // if(!deptVal&&deptVal==''){
                  //      layer.msg('请选择片区中心')
                  //   return false;
                  //  }
             }
              // return false;
        })
    }
    //如果是运营中心登陆
    if(role_id==3){
        $('#type').html('');
        $('#type').append("<option selected='selected' value='服务中心'>服务中心</option>");
        $('#parent').show();
        $('#agent').html('');
        $('#agent').append("<option selected='selected' value="+name+">"+name+"</option>");
        $('#agent').trigger("chosen:updated");
//        $('#type').css('background-color','#e6e6e6');
//        $('#agent').css('background-color','#e6e6e6');
    }
        //如果是片区中心登陆
   if(role_id==7){
        $('#type').html('');
        $('#type').append("<option selected='selected' value='服务中心'>服务中心</option>");
        $('#belong').show();
 //$('.dept_select').trigger("liszt:updated");
        $('.dept_select').html('')
       $('.dept_select').append("<option selected='selected' value="+name+">"+name+"</option>")
        $('.dept_select').trigger("liszt:updated");
    }else{
        $.get('./index.php?r=admin-user/search-area-center', function(data) {
                     if(data.code){
                    // console.log(data);
                    return;
                 }
                    var obj = eval('(' + data + ')');
                  if(obj){
                    for(var i=0;i<obj.length;i++){
                        $("#dept").append(' <option value="'+obj[i].Name+'">'+obj[i].Name+'</option>')
                    }
                     //  $('.dept_select').trigger("liszt:updated");
                 $('.dept_select').trigger("chosen:updated");
                  }
    });
 }



if(msg){
    // alert(msg)
    setTimeout(function(){
            layer.msg(msg)
    } ,1000);

        var datadas=$('#type option:selected').attr('value');
        if(type=='片区中心'){
         $.get('./?r=admin-user/get-agent',{'province':province,'city':city,'area':area},function(data){
                    // console.log(data)
                        if(data){
                        $("#agent").html('');
                          html="";
                        for(var i =0;i<data.length;i++){
                            


                               if(agent==data[i].Name){
                                   html+="<option  selected='selected' value='"+data[i].Name+"'>"+data[i].Name+"</option>"
                               }else{
                                   html+="<option value='"+data[i].Name+"'>"+data[i].Name+"</option>"
                               }
                        }
                        $(html).appendTo("#agent");

                        $('#agent').trigger("chosen:updated");
                        $('#parent').show();
                        $('#belong').hide();
                        $("#dept_chosen").css('width','150px')
                          //$('#belong').show();
                    }
                   })
        }
 
}

</script>
</body>
</html>

