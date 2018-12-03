<?php
use yii\widgets\LinkPager;
error_reporting( E_ALL&~E_NOTICE );
?>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
    <link rel="stylesheet" href="./static/css/newTheme/newTheme.css"/>

    <style>
    	.search span{
	display: inline-flex;
}
.search span label{
	width:80px;
	    margin-top: 5px;
}
.search span {
    width: initial;
    /* display: -webkit-inline-box; */
}
.search span>input,search_brands {
    width: 150px;
    margin-left: 10px;
    background-color: #2C2B37;
    border: #2C2B37;
    padding: 5px;
}
#water_brands,#water_names{
    width:150px;
    height:30px;
    text-align: center;

    background-color: #2C2B37;  
}
.row>div{
    margin-top:10px;
}
    </style>
    <div class="wrapper wrapper-content">
        <div class="search " >
            <form action="/index.php?r=logic-user/factory-list" method="post">
                    <div class="container-fluid">
                         <div class="row" style="text-align: right;">
                                
                                  <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                     <span><label>名称:</label><input type="text" placeholder="请输入名称" id="username" name="username" value="<?=$username?>"/></span> 
                                  </div>
                                  <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6"> 
                                       <span >
                                            <label>手机号:</label>
                                            <input type="text" placeholder="请输入手机号" id="mobile" value="<?=$mobile?>" name="mobile"/>
                                        </span>
                                </div>
                                 <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6"> 
                                         <select class="control-label" name="water_brand"  id="water_brands">
                                                <option value="" >选择品牌</option>
                                            </select>
                                </div>
                                 <div class="col-lg-2 col-md-6 col-sm-46 col-xs-6"> 
                                        <select class="control-label" name="water_name"  id="water_names">
                                                <option value="" >选择商品型号</option>
                                        </select>
                                </div>
                                  <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                      <label >地区:</label>
                                        <div class="multiple-choice">
                                            <select class="control-label" name="province"  id="province">
                    <option value="" selected>请选择</option>
                    </select>
                                            <select class="control-label" name="city" id="city">
                                                <option value="">请选择</option>
                                            </select>
                                            <select class="control-label" name="area" id="area">
                                                <option value="">请选择</option>
                                            </select>
                                             <input type="submit" class="btn" value="查询"/ style="    line-height: 0;border:none">
                                        </div>
                                  </div>
                         </div>
                    </div>
            </form>
        </div>

        <table class="table table-hover" style="background:white;"  style="margin-top:-45px">
            <thead>
            <th style="width: 5%">序号</th>
            <?= $role_id==1?'<th style="width: 8%">登录账号</th>':''?>
            <th style="width: 6%">名称</th>
            <th  style="width: 9%">所在地区</th>
            <th style="width: 10%">地址</th>
            <th style="width: 8%">联系人</th>
            <th style="width: 6%">联系电话</th>
            <th style="width: 6%">品牌</th>
            <th style="width: 6%">商品名称</th>
            <th style="width: 4%">容量(L)</th>
            <th style="width: 6%">条码余数</th>
            <?= $role_id==1?"<th style='width: 10%'><a id='sort' href=''>最近操作时间</a></th>":''?>
            <th style="width: 10%">条码记录</th>
            <?= $role_id==1?'<th style="width: 6%">操作</th>':''?>
            </thead>
            <tbody>
            <?php

            if($role_id==1){
                $str='';
                $no=1;
                foreach($model as $key=>$val)
                {

                        $str.= "<tr>
                        <td>".$no."</td>
                        <td>".$val["LoginName"]."</td>
                        <td>".$val["Name"]."</td>
                        <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                        <td>".$val["Address"]."</td>
                        <td>".$val["ContractUser"]."</td>
                        <td>".$val["ContractTel"]."</td>
                        <td>".$val['BrandName']."</td>
                        <td>".$val['goodsname']."</td>
                        <td>".$val['Volume']."</td>
                        <td>".$val['LeftAmount']."</td>
                        <td>".$val["RowTime"]."</td>
                        <td><a href='/index.php?r=recharge/list&pid=".$val["Id"]."&BrandName=".$val["BrandName"]."&goodsname=".$val["goodsname"]."&Volume=".$val["Volume"]."' style='color:#00CADC'>条码充值记录</a><br/>
                        <a href='/index.php?r=saoma/flist&pid=".$val["Id"]."&BrandName=".$val["BrandName"]."&goodsname=".$val["goodsname"]."&Volume=".$val["Volume"]."'style='color:#00C38F' >条码使用记录</a></td>
                        <td><a href='./?r=recharge/create&fid=".$val["Id"]."&BrandName=".$val["BrandName"]."&goodsname=".$val["goodsname"]."&Volume=".$val["Volume"]."' style='color:#D05626'>充值&nbsp;&nbsp;</a>

                        </tr>";//<a href='./?r=factory/update&id=".$val["Id"]."'>修改</a>&nbsp;&nbsp;
                        $no++;//<a href='./?r=recharge/see&fid=".$val["Id"]."' style='color:#D05626'>查看品牌</a></td>



                }
                echo $str;
            }else{

                $str='';
                $no=1;
                foreach($model as $key=>$val)
                {
                    $str.= "<tr>
                        <td>".$no."</td>
                        <td>".$val["Name"]."</td>
                        <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                        <td>".$val["Address"]."</td>
                        <td>".$val["ContractUser"]."</td>
                        <td>".$val["ContractTel"]."</td>
                        <td>".$val['BrandName']."</td>
                        <td>".$val['goodsname']."</td>
                        <td>".$val['Volume']."</td>
                        <td>".$val['LeftAmount']."</td>
                        <td><a href='/index.php?r=recharge/list&pid=".$val["Id"]."'style='color:#00CADC'>条码充值记录</a><br/><a href='/index.php?r=saoma/flist&waterfname=".$val["Name"]."''style='color:#00C38F'>条码使用记录</a></td>
                        </tr>";
                $no++;
                }
                echo $str;
            }

            ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script>
    var data =<?=json_encode($address)?>;
    var province='<?=$province?>';
    var city='<?=$city?>';
    var area='<?=$area?>';
    var sort='<?=$sort?>';
    var water_brand='<?=$water_brand?>' || '';
    var water_name='<?=$water_name?>'|| '';
    var water_brands=<?=json_encode($water_brands)?>;
    var water_names=<?=json_encode($water_names)?>;

 
</script>
<script>
// 渲染品牌型号
$(function(){
    if(water_brands){
             for(var i=0; i<water_brands.length; i++){
             $("#water_brands").append(' <option value="'+water_brands[i].BrandName+'" gmoney="'+water_brands[i].BrandNo+'">'+water_brands[i].BrandName+'</option>')
          }
    }
     if(water_names){
         for(var i=0; i<water_names.length; i++){
             // if(water_names[i].name == water_name){
             //     $("#water_names option").eq(i).attr("selected","selected")
             //   }
             $("#water_names").append(' <option value="'+water_names[i].name+'">'+water_names[i].name+'</option>')
          }
    }
 $("#water_brands").change(function(){
    if(!$(this).val()){
        for(var i=0; i<water_names.length; i++){
             $("#water_names").append(' <option value="'+water_names[i].name+'">'+water_names[i].name+'</option>')
          }
        return;
    }
     var date =  $(this).find("option:selected").attr("gmoney");
      $("#water_names").empty();
      $("#water_names").append('<option value="">请选择</option>');
         for(var i=0; i<water_names.length; i++){
            // console.log(water_names.brand_id)
             if(date ==water_names[i].brand_id ){
               $("#water_names").append(' <option value="'+water_names[i].name+'">'+water_names[i].name+'</option>')
             }
     }


});
})
// 

   

    //排序
    $('#sort').click(function(){
        sort++;
        $(this).attr('href','./?r=logic-user/factory-list&sort='+sort);

    });
    $(function(){
        $('.pagination a').click(function(){
            var username=$('#username').val();
            var mobile=$('#mobile').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();
            var page_size=$('#page_size option:selected').val();
            var water_brands = $('#water_brands option:selected').val();
            var water_names = $('#water_names option:selected').val();
            var href=$(this).attr('href');

            $(this).attr('href',href+'&username='+username+'&mobile='+mobile+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&per-page='+page_size+'&water_brand='+water_brands+'&water_name='+water_names);
//                var href2=$(this).attr('href');
//                alert(href2)
        });
    });


    $(function(){
        initProvince();
        initListener();
        initAddress();


    });
    function initAddress() {
        $("#province").val(province);
        initCityOnProvinceChange();
         $("#city").val(city);
        initThree();
        $("#area").val(area); 
         $("#water_brands").val(water_brand)
         $("#water_names").val(water_name)
    }
    function getAddressIdByName(_name) {
        _name = $.trim(_name);
        if (_name == "") {
            return 0;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            var name = $.trim(item.Name);
            if (name != "" && name == _name) {
                return item.Id;
            }
        }
        return 0;
    }
    function initListener() {
        $("#province").on("change", function () {
            initCityOnProvinceChange();
        });
        $("#city").on("change", function () {
            initThree();
        });
        $("#queryBtn").on("click",function(){
            query();
        });
    }
    function initCityOnProvinceChange() {
        var pid = getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#city").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#city").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
                initThree()
            }
        }
    }
    function initThree() {
        var pid = getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#area").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }
    function initProvince() {
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId == 0) {
                $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }
</script>

<?php
echo "<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>";
echo "
<dev style='float:left;margin-top: 22px;margin-left: 50px ;   text-align: center;width: 100%; color:#BABABF'>

<nav aria-label='Page navigation' style='     display: initial;  margin-top: -25px;padding-right: 20px;'>
  <ul class='pagination pagination-sm' id='Circula' style=' margin: -5px;'>
    <li  >
      <a href='#' aria-label='Previous'>
        <span aria-hidden='true'>&laquo;</span>
      </a>
    </li>
    <li class='hort'><a href='#'>1</a></li>
    <li  class='hort'><a href='#'>2</a></li>
    <li  class='hort'><a href='#'>3</a></li>
    <li  class='hort'><a href='#'>4</a></li>
    <li  class='hort'><a href='#'>5</a></li>
    <li>
      <a href='#' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
<span style='margin-left: auto'>跳转：<input style='width: 50px;background: #292834;border-radius: 5px;border: none;text-align: center;' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=logic-user/factory-list' id='butn' style='    background: #292834;color:#BABABF; border-radius: 5px;padding: 5px 20px;'>确定</a></span>
每页显示：
<select type='text' name='page_size' id='page_size' style='width:50px;background-color:#292834;border-radius:5px;border:none'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;
</dev>"
?>
<script>


    $('#page_size').val(<?=$page_size?>);
$('#btn').click(function () {
  
    var username=$('#username').val();
    var mobile=$('#mobile').val();
    var province=$('#province option:selected').val();
    var city=$('#city option:selected').val();
    var area=$('#area option:selected').val();
    var page_size=$('#page_size option:selected').val();
    var pages=$('#pages').val();
    var href=$(this).attr('href');
    var water_brands = $('#water_brands option:selected').val();
    var water_names = $('#water_names option:selected').val();
    $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&username='+username+'&mobile='+mobile+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&water_brand='+water_brands+'&water_name='+water_names)
})
    // 共有页
var totalCount =<?php echo  $pages->totalCount ?>
// 当前页
var page_size1=<?=$page_size?>;
// 循环页
var current = Math.ceil(totalCount/page_size1)
// 超出5个折叠
        var username=$('#username').val();
        var mobile=$('#mobile').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();
        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
        var href=$(this).attr('href');

 $("#Circula .hort").remove()
    if(current<=7){
        for (var i = 1; i <=current; i++) {
            $("#Circula li:last-child").before('<li class="hort"><a href="./?r=logic-user/factory-list"'+'&page='+i+'&per-page='+page_size+'&username='+username+'&mobile='+mobile+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'>'+i+'</a></li>')
            }
    }
    else{
         var current_num=current;
         for (var i = current-2; i <=current+2; i++) {
                $("#Circula li:last-child").before('<li class="hort"><a href="./?r=logic-user/factory-list"'+'&page='+i+'&per-page='+page_size+'&username='+username+'&mobile='+mobile+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'>'+i+'</a></li>')
        }
        $("#Circula li:nth-last-child(3) a").text("...").attr('href', 'javascript:void(0)');;
        $("#Circula li:nth-last-child(2) a").text("...");
    }




</script>
