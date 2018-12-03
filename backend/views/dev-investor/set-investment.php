<!DOCTYPE html>
<html style="overflow-x:hidden;overflow-y:hidden">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="X-UA-Compatible"content="IE=9; IE=8; IE=7; IE=EDGE">
    <link rel="stylesheet" href="./static/js/zui/css/zui.css"/>
    <link rel="stylesheet" href="./static/js/zui/css/style.css"/>
    <link rel="stylesheet" href="./static/css/addgood.css"/>
    <link rel="stylesheet" href="./static/js/jedate/skin/jedate.css"/>

    <link rel="stylesheet" href="./static/js/datepicker/dateRange.css"/>

    <link rel="stylesheet" href="./static/js/page/jquery.pagination.css"/>
    <link rel="stylesheet" href="./static/css/chosen.css"/>
   <link rel="stylesheet" href="./static/css/Common.css?v=1.0"/>
    <style>
        body{
            height:100%;
            width:100%;
            overflow:auto;
        }
        #good_sub_type_c {
            min-width: 1000px;    min-height: 10px;
        }
                .chosen-container {
            margin-left: 10px;
        }
        .ftitle{
            width: 100px
        }
    </style>
</head>
<body>



<div class="content_middle">
    <!--    <div class="f1">-->
    <!--        <input type="button" class="btn select_btn" value="+添加新频道" onclick="openUrl()"/>-->
    <!--    </div>-->
  <!--   <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['dev-investor/list'],['class'=>'btn btn-primary'])?></div>
 -->

 <div style="text-align: right;margin-bottom: 10px">
               <a class="btn btn-primary" href="/index.php?r=dev-investor/list&<?=$url?>">返回</a>     
        </div> 
    <div class="main-title">
        <h2>投资设置</h2>
    </div>
    <div  style="">


        <div class="item" style="margin-bottom: 20px;">
            <div class="ftitle"><span class="tip"></span><span class="title">投资商名称：</span></div>
            <input id="agent_id" type="hidden" class="baseinput" value="<?=$id?>"/>
            <div class="fcontent"><input readonly="readonly"  id="investor" type="text" class="baseinput" value="<?=$name?>"/></div>
        </div>

        <div class="item" style="height:auto;">
            <div class="ftitle"><span class="tip">*</span><span class="title">投资设备：</span></div>
            <div class="fcontent" style="height:auto;margin-left: 0px; width: -webkit-calc(100% - 160px); width: -moz-calc(100% - 160px);width: calc(100% - 160px);    margin-top: -10px;">
                <div id="good_sub_type_c">

                </div>
<!--                <div style="padding-left:20px;margin-top:10px;"><lable for="starttime">开始时间:</lable><input type="text" id="originalPrice1"/>&nbsp;&nbsp;<lable for="endtime">结束时间:</lable><input type="text" id="originalPrice2"/></div>-->
                <p><a href="javascript:addGoodType(this);">继续添加</a></p>
            </div>
        </div>

    </div>



    <div class="detail5" style="margin-left: 50px;    padding-bottom: 300px;clear:both">
        <input type="button" class="btn select_btn " value="保存" id='btn' onclick="savegood()"  style="width: initial;
        color: #fff;    background-color: #E46045;    border: none;"/>
    </div>


</div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/chosen.js?v=1.0"></script>  
<script type="text/javascript" src="./static/js/zui/js/zui.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
<script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
<script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/pinyin.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>
<script type="text/javascript" src="./static/js/good/investment-setting.js?v=1.4"></script>
<script type="text/javascript" src="./static/js/address.js"></script>
<script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
<script type="text/javascript">
    var category='';
    var merchant='';
    var baseGood=<?=json_encode($data)?>;
    var sms='';
     // var url='<?=$url?>';

        // console.log(url)
</script>
<script type="text/javascript">

    var num=baseGood.length;


    for(var index= 0;index < baseGood.length;index++){
        // addGoodTypeWithData(index);
       addGoodTypetxtData(index);
    }





function addGoodTypetxtData(index){
     
       var itemAmount=$("#good_sub_type_c").find(".item").length;
        if(isNaN(itemAmount)){
          return;
        }
 // console.log(index)
    var goodList = this;
    // console.log(goodList)
    var currentIndex=itemAmount+1;
    var itemStr=' <div class="item" id="item'+currentIndex+'" itemid="100">'+
                    '<div class="good_sub_type">'+
                    '<select multiply onchange="change1('+currentIndex+')" id="devbrand'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option value="">选择设备品牌</option></select>'+
                    '<select  onchange="change2('+currentIndex+')" id="devname'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option value="">选择设备名称</option></select>'+
                    '<select id="devfactory'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option value="">选择设备厂家</option></select>'+
                    '<div style="display: inline-block;line-height: 0;"><label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="fl">投资区域：</label><select onchange="change3('+currentIndex+')" id="province'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option selected="selected" value="">选择省</option></select>'+
                    '<select id="city'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option value="">选择市</option></select>'+
                    '</div>'+
                    '<div style="display: inline-block;line-height: 0;position: relative;display: inline-block;vertical-align: middle; user-select: none;">'+
                    '<label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="fl">投资数量:&nbsp;&nbsp;</label><input id="realPrice'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:50px;    height: 30px;"/>'+
                    '</div>'+
                    '<div style="display: inline-block;line-height: 0;position: relative;display: inline-block;vertical-align: middle; user-select: none;">'+
                    '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class="fl">投资时间:</label><input id="originalPrice'+currentIndex+'" type="text" class="originalPrice baseinput fl" style="width:130px;"/>'
                    '</div>';

                 itemStr+=    '<div style="display: inline-block;line-height: 0;">'+
                      '<a href="javascript:void(0);"  class="delGoodType" style="margin-left:5px;float:left;height:25px;line-height: 25px;">删除</a>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
            $("#good_sub_type_c").append($(itemStr));
            // $('#devbrand'+currentIndex+'').chosen();
          // 添加商品品牌数据
          // $('#realPrice'+currentIndex).val();
              $('#devbrand'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             $('#devname'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             $('#devfactory'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             $('#province'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             $('#city'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
          $.get('./?r=dev-investor/get-devbrand',function(data){
             var html="";
             $(data).each(function(i,v){
                if(v){
                    // console.log(v)
                    if(v.BrandNo==baseGood[index].brand_id){
                        html+="<option selected='selected' value='"+v.BrandNo+"'>"+ v.BrandName+"</option>"
                    }else {
                        html += "<option value='" + v.BrandNo + "'>" + v.BrandName + "</option>"
                    }
                }
             });
             // console.log(html)
                   $('#devbrand'+currentIndex).html('');
                    $(html).appendTo('#devbrand'+currentIndex);
                    $('#devbrand'+currentIndex).trigger("chosen:updated");
               // goodList.devbrand.trigger("chosen:updated");
              // goodList.real.chosen({no_results_text: "没有找到"}); //初始化chosen
        });

       var brand_id=baseGood[index].brand_id;
          if(brand_id){
            // console.log(4)
            //添加商品名称数据
            $.get('./?r=dev-investor/get-dev',{'devbrand_id': brand_id},function(data){
                // console.log(data);
                if(data!=''){
                    var html = "<option value=''>设备名称</option>";
                    $(data).each(function(i,v){
                        if(v){
                            if(v.name==baseGood[index].name){
                               html+="<option selected='selected' value='"+v.name+"'>"+ v.name+"</option>"
                            }else{
                               html+="<option value='"+v.name+"'>"+ v.name+"</option>"
                            }
                        }
                    });
                    //console.log(html);
                    $('#devname'+currentIndex).html('');
                    $(html).appendTo('#devname'+currentIndex);
                    $('#devname'+currentIndex).trigger("chosen:updated");
                }else{
                    var html = "<option value=''>设备名称</option>";
                    $('#devsname'+currentIndex).html('');
                     $('#devname'+currentIndex).trigger("chosen:updated");
                }
            });
        }else{
            var html = "<option value=''>设备名称</option>";
            $('#devname'+currentIndex).html('');
            $(html).appendTo('#devname'+currentIndex);
              $('#devname'+currentIndex).trigger("chosen:updated");
        }

        //添加设备厂家数据
        $.get('./?r=dev-investor/get-devfactory',function(data){
//            console.log(data);
            var html="";
            $(data).each(function(i,v){
//                console.log(v);
                if(v){
                    if(v.Id==baseGood[index].factory_id){
                        html+="<option selected='selected' value='"+v.Id+"'>"+ v.Name+"</option>"
                    }else {
                       html += "<option value='" + v.Id + "'>" + v.Name + "</option>"
                    }
                }
            });
//            console.log(html);
            $(html).appendTo('#devfactory'+currentIndex);
             $('#devfactory'+currentIndex).trigger("chosen:updated");
            //console.log(data);
        });
                //选中省
        if(address!=''){
            //填充省市的数据

            var html='';

            if(baseGood[index].province=='全国'){
                html += '<option selected="selected" value="全国">全国</option>';
            }else{
                html='<option value="全国">全国</option>';
            }

            $(address).each(function(){
                if(this.name==baseGood[index].province){
                    html += '<option selected="selected" value="'+this.name+'">'+this.name+'</option>';
                }else{
                    html += '<option value="'+this.name+'">'+this.name+'</option>';
                }
            });
            $(html).appendTo('#province'+currentIndex);
              $('#province'+currentIndex).trigger("chosen:updated");
        }
       //选中市
        var province = baseGood[index].province;//获取当前选中的省
        if(province != ''){
            if(province=='全国'){
                var option = '<option value="全部">全部</option>';
                $("#city"+currentIndex).html(option);
                   $('#city'+currentIndex).trigger("chosen:updated");
            }else{
                //获取当前省对应的市 数据

                $(address).each(function(){
                    if(this.name == province){
                        var option = '<option value="全部">全部</option>';
                        $(this.city).each(function(){

                            if(this.name==baseGood[index].city){
                                option += '<option selected="selected" value="'+this.name+'">'+this.name+'</option>';
                            }else{
                                option += '<option value="'+this.name+'">'+this.name+'</option>';
                            }

                        });
                        $("#city"+currentIndex).html(option);
                         $('#city'+currentIndex).trigger("chosen:updated");

                    }
                });
            }

        }else{
            $("#city"+currentIndex).html('<option value="">选择市</option>');
             $('#city'+currentIndex).trigger("chosen:updated");
        }

//                 //投资时间弹框
        jeDate({
            dateCell:"#originalPrice"+currentIndex,
            // format:"YYYY-MM-DD",
            isinitVal:true,
//        isTime: true
        });
        $("#realPrice"+currentIndex).val(baseGood[index].number);//投资设备台数
            $("#originalPrice"+currentIndex).val(baseGood[index].time);//时间
        $(".delGoodType").unbind();
        $(".delGoodType").on("click",function(){
            $(this).parents(".item").eq(0).remove();
        });
}
</script>




</body>
</html>

