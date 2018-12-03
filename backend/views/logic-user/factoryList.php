<?php
use yii\widgets\LinkPager;
error_reporting( E_ALL&~E_NOTICE );
?>
 <link rel="stylesheet" href="./static/css/newTheme/newTheme.css"/>

       <link rel="stylesheet" href="./static/css/chosen.css"/>
      <link rel="stylesheet" href="./static/css/Common.css"/>

<style>
 .search span{
    /*display: inline-flex;*/
}
.search span label{
    width:100px;
    margin-top: 5px
}
.search span {
    width: initial;

}
.provincecity  input, select, option {
	width:inherit;
}
 input{
  width:200px;
}
.wrapper .row label {
   padding: 0 10px;
	margin-top: 5px;
    margin-left:-5px;
        width: 100px;
}
.wrapper .row label {
    padding: 0 10px;
 
    margin-top: 5px;
}
#btn,#btnn{
	width: 50px;
    height: 30px;
    display: inline-block;
    line-height: 30px;
    text-align: center;
      background-color: #E46045;
    color: #bb442d;
    padding: 0;
    border:none;
    color: #fff
}
 input{
  width:240px;
}
.Recharge{
color:#DBAF44
}
.RechargeRecord{
  color:#D05626
}
.useRecords{
  color:#00C38F
}

.RechargeRecord:hover,.useRecords:hover,.Recharge:hover{
  background-color: #E46045;
  border-radius: 2px;
    color: rgb(233,233,233);
}

.multiple-choice{
	background:#2D3136;
	border-color:#2D3136;
	margin-left: -4px;
   width: initial;;
    border-radius:4px;
}
.multiple-choice .chosen-container:first-child{
  margin-left: -10px;
}
select {
    min-width: 100px;
    background-color: #2D3136;
    color: #BABABF;
}
    </style>
    <div class="wrapper wrapper-content">
         <div style="float: left; margin-left: 20px;"><img src="/static/images3/sidebar.png" alt="搜索"><span class="font-size-S" style='    font-size: 12px;'>&nbsp;水厂</span></div>
         <div style='clear:both'> </div>
        <div style=" margin-top: 20px;   padding: 33px 15px;" class="condition" >
            <form action="/index.php?r=logic-user/factory-list" method="post">
                    <div class="container-fluid">
                         <div class="row">
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                      <span style=" display: inline-flex;"><label>名称:</label>
                                      	<input type="text" placeholder="请输入名称" id="username" name="username" value="<?=$username?>"/></span> 
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                       <span style=" display: inline-flex;;
">
                                            <label >账号/手机号:</label>
                                           &nbsp; <input type="text" placeholder="请输入 账号/手机号" id="mobile" value="<?=$mobile?>" name="mobile"/>
                                        </span>
                                </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top: 20px;"> 
         								 <label >品牌选择</label>
         								 <div class="multiple-choice">
                                         <select class="control-label " name="water_brand"  id="water_brands">
                                             <option value="" >选择品牌</option>
                                        </select>
                                           <select class="control-label" name="water_name"  id="water_names">
                                                <option value="" >选择商品型号</option>
                                        </select>
                                    </div>
                                </div>
                        
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" class="provincecity"  style="margin-top: 20px;">
                                      <label >地区:</label>
                                        <div class="multiple-choice" style="margin-left:0px">
                                            <select class="control-label" name="province"  id="province">
							                                <option value="" >选择省</option>
							                                </select>
                                            <select class="control-label" name="city" id="city">
                                               <option value="" >选择市</option>
                                            </select>
                                            <select class="control-label" name="area" id="area">
                                                <option value="" >选择区</option>
                                            </select>
                                           
                                        </div>
                                          <input type="submit" class="btn" value="查询"/ id="btnn" style="   line-height: 0; margin-left: 10px;   margin-top: -5px;border:none">
                                  </div>
                          
                         </div>
                    </div>
            </form>
        </div>
  <table class="table table-hover"  >
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
                        <td><a href='/index.php?r=recharge/list&pid=".$val["Id"]."&BrandName=".$val["BrandName"]."&goodsname=".$val["goodsname"]."&Volume=".$val["Volume"]."'class='RechargeRecord' style=''>条码充值记录</a><br/>
                        <a href='/index.php?r=saoma/flist&pid=".$val["Id"]."&BrandName=".$val["BrandName"]."&goodsname=".$val["goodsname"]."&Volume=".$val["Volume"]."'class='useRecords' style='' >条码使用记录</a></td>
                        <td><a href='./?r=recharge/create&fid=".$val["Id"]."&BrandName=".$val["BrandName"]."&goodsname=".$val["goodsname"]."&Volume=".$val["Volume"]."' class='Recharge'>充值&nbsp;&nbsp;</a>

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

                        <td><a href='/index.php?r=recharge/list&pid=".$val["Id"]."&BrandName=".$val["BrandName"]."&goodsname=".$val["goodsname"]."&Volume=".$val["Volume"]."'class='RechargeRecord' style=''>条码充值记录</a><br/>
                        <a href='/index.php?r=saoma/flist&pid=".$val["Id"]."&BrandName=".$val["BrandName"]."&goodsname=".$val["goodsname"]."&Volume=".$val["Volume"]."'class='useRecords' style='' >条码使用记录</a></td>

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
    <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script> 
    <script type="text/javascript" src="/static/js/Common2.js"></script> 
<script>
    var data =<?=json_encode($address)?>;
    var province='<?=$province?>';
    var city='<?=$city?>';
    var area='<?=$area?>';
    var sort='<?=$sort?>';
    var water_brand='<?=$water_brand?>' || '';
    var water_name='<?=$water_name?>'|| '';
    var water_brands=<?=json_encode($water_brands)?>;
    var username='<?=$username?>';
    var mobile='<?=$mobile?>';
    var water_names=<?=json_encode($water_names)?>;
           // 地址渲染方法
  addressResolve(data,province,city,area)
        var where_datas={
            province:province,
            city:city,
            area:area,
            sort:sort,
            water_brand:water_brand || '',
            water_name:water_name || '',
            username:username,
            mobile:mobile
        };
var url='';
for(var i in where_datas){
  if(where_datas[i]==null){
     where_datas[i]=''
  }
  url= url +"&"+ i+'='+where_datas[i]
}
console.log(where_datas)
$(".table  td a").click(function(){
    var _thisURl = $(this).attr('href');
      var Urlobj = encodeURIComponent(url);
    $(this).attr('href',_thisURl+"&Url="+Urlobj)
})









</script>
<script>

var brands_names = function(options,options2,default_par){
	if (!isValid(options))
        return this;
    //默认参数
     var defaluts = {
        brands: 'water_brands',
        names: 'water_names'
     };
    var opts = $.extend({}, defaluts, options);//使用jQuery.extend 覆盖插件默认参数
    var opts2 = $.extend({}, defaluts, options2);//使用jQuery.extend 覆盖插件默认参数
    var addressInfo = this;
    this.brands = $("#" + opts.brands);//省份select对象
    this.names = $("#" + opts.names);//城市select对象
       // 品牌
    this.provInfoInit = function () {
        var proOpts = "";
          addressInfo.names.empty().append("<option value=''>请选择品牌型号</option>");
          $.each(options, function (index, item) {
        if (item) {
            proOpts+=' <option value="'+item.BrandName+'"  data="'+item.BrandNo+'">'+item.BrandName+'</option>'
        }
    });
        // console.log(proOpts)
    addressInfo.brands.append(proOpts);
    addressInfo.brands.chosen({no_results_text: "没有找到",disable_search: true}); //初始化chosen
    addressInfo.names.chosen({no_results_text: "没有找到",disable_search: true});//初始化chosen
    // addressInfo.areaInfo.chosen({no_results_text: "没有找到",disable_search: true});//初始化chosen
    };
        this.namesInfoInit = function () {
    	        var proOpts = "";
    	             addressInfo.names.empty().append("<option value=''>请选择商品型号</option>");
    	            var namesuy =  addressInfo.brands.val();//获取选择的城市值
    	            var BrandName=   getAddressIdByName(namesuy);
    	            $.each(options2, function (index, item) {
				    if (item) {
				    	if(BrandName==item.brand_id){
				    	proOpts+=' <option value="'+item.name+'"  data="'+item.BrandNo+'">'+item.name+'</option>'
				        }
				    	}
				    });

	     addressInfo.names.append(proOpts);  
	     addressInfo.names.trigger("chosen:updated");  
     }
    /*对象初始化方法*/
    this.init = function () {
    	   addressInfo.provInfoInit();
    	    addressInfo.brands.bind("change", addressInfo.namesInfoInit);

    	  if(default_par.water_brand){
			    addressInfo.brands.val(default_par.water_brand);
			    addressInfo.brands.trigger("chosen:updated");
			    addressInfo.namesInfoInit();
			}

			console.log(default_par.water_name)
       if(default_par.water_name){
			    addressInfo.names.val(default_par.water_name);
			    addressInfo.names.trigger("chosen:updated");
			}

  

    }

      //私有方法，检测参数是否合法
    function isValid(options) {
        return !options || (options && typeof options === "object") ? true : false;
    }
     
     function getAddressIdByName(_name) {
            _name = $.trim(_name);
            if (_name == "") {
                return 0;
            }
            for (var index = 0; index < options.length; index++) {
                var item = options[index];
                var name = $.trim(item.BrandName);
                if (name != "" && name == _name) {
                    return item.BrandNo;
                }
            }
            return 0;
        }

           init()
}

var default_par={
	water_brand:water_brand,
	water_name:water_name
}


brands_names(water_brands,water_names,default_par)

$(function(){

    // if(water_brands){
    //          for(var i=0; i<water_brands.length; i++){
    //             $("#water_brands").append(' <option value="'+water_brands[i].BrandName+'" gmoney="'+water_brands[i].BrandNo+'">'+water_brands[i].BrandName+'</option>')
    //        }
    // }
 if(water_names){
       for(var i=0; i<water_names.length; i++){
         // if(water_names[i].name == water_name){
         //     $("#water_names option").eq(i).attr("selected","selected")
         //   }
         $("#water_names").append(' <option value="'+water_names[i].name+'"gmoney="'+water_names[i].brand_id+'">'+water_names[i].name+'</option>')
      }

}







 $("#water_brands").change(function(){
  
     if(!$(this).val()){

   
           $('option:not(:first-child)', $("#water_names")).remove();
  		  
          for(var i=0; i<water_names.length; i++){
             $("#water_names").append(' <option value="'+water_names[i].name+'"gmoney="'+water_names[i].brand_id+'">'+water_names[i].name+'</option>')
          }
        return;
     }


     var date =  $(this).find("option:selected").attr("gmoney");
      $("#water_names").empty();
      $("#water_names").append('<option value="">请选择</option>');
         for(var i=0; i<water_names.length; i++){
            // console.log(water_names.brand_id)
             if(date ==water_names[i].brand_id ){
               $("#water_names").append(' <option value="'+water_names[i].name+'"gmoney="'+water_names[i].brand_id+'">'+water_names[i].name+'</option>')
             }
        }


});




})


    //排序
    $('#sort').click(function(){
        sort++;
        $(this).attr('href','./?r=logic-user/factory-list&sort='+sort);
//            alert($(this).attr('href'));

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
// console.log(water_names)
        var _water_brands =  $("#water_brands  option:selected").attr('gmoney');
       if(_water_brands){
           

             $('option:not(:first-child)', $("#water_names")).remove();
            for(var i=0; i<water_names.length; i++){
         if(water_names[i].brand_id ==_water_brands){

             $("#water_names").append(' <option value="'+water_names[i].name+'">'+water_names[i].name+'</option>')

           }
      }
       }





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
function  initWater(){
      var pid = getAddressIdByName($("#water_brands").val());
          $("#water_names").empty();
          $("#water_names").append("<option value='' selected>请选择</option>");
          if (pid == 0) {
            return;
         }
          if (item.PId != 0 && item.PId == pid) {
                $("#water_names").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
                initThree()
            }
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

         // $("#water_names").on("change",function(){
         //     initWater();
         // });

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
echo "";
echo "<from actio='./?r=logic-user/factory-list' method='post'><dev style='float:left;margin-top: 22px;margin-left: 50px; padding-bottom:150px;   height: 100px;'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=logic-user/factory-list' id='btn'>确定</a></span>
</dev></from>"

?>
<script>

    $('#page_size').val(<?=$page_size?>);

        $('#page_size').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
$('#btn').click(function () {

    var username=$('#username').val();
    var mobile=$('#mobile').val();
    var province=$('#province option:selected').val();
    var city=$('#city option:selected').val();
    var area=$('#area option:selected').val();
    var water_brands = $('#water_brands option:selected').val();
    var water_names = $('#water_names option:selected').val();
    var page_size=$('#page_size option:selected').val();
    var pages=$('#pages').val();
    var href=$(this).attr('href');
    $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&username='+username+'&mobile='+mobile+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&water_brand='+water_brands+'&water_name='+water_names)

})

</script>
