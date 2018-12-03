<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
    <style type="text/css">
 .ta_ipt_text_s .ta_dateRangeSelected {
  
    line-height: inherit !important;
}
.ta_calendar table thead tr th{
        background: #292834;
         border:none;
}

 .tablehot{
width:5px;
height:5px;
background-color: #E46045;
border-radius: 50px;
margin-top: 10px;   
}
.table tbody  .tablehot{
    background-color: #4AD8D9;
}


    </style>
<div class="wrapper">
           <div class="header" >
               <img src="/static/images3/sidebar.png" alt="搜索" >
               <span class="font-size-S">&nbsp;扫码记录详情</span>
           </div>	
          <div style="text-align: right;margin-bottom: 10px">  <?= \yii\bootstrap\Html::a('返回',['saoma/list'],['class'=>'glyphicon glyphicon-chevron-left btn btn-primary'])?></div>
    <div class="condition">
        
        <form method="post" action="/index.php?r=saoma/detail&DevNo=<?=$DevNo?>">
            <input type="hidden" name="DevNo" value="<?=$DevNo?>">
            <span class="labelText" >
                <label>搜索:</label>
                <input type="text" placeholder="请输入关键词.用户姓名.服务中心等" id="content" name="content" value="<?=$content?>"/>
            </span>
            <span class="labelText">
                <label>时间段:</label>
                <input type="text" placeholder="请选择时间段" name="selecttime" id="selecttime" />
            </span>
               <span style="padding-left:5px;margin-top: 10px;display:none">
                <label>地区:</label>
                 <select class="control-label" name="province"  id="province">
                     <option value="">请选择省</option>
                 </select>
                 <select class="control-label" name="city" id="city">
                    <option value="">请选择市</option>
                </select>
                <select class="control-label" name="area" id="area">
                    <option value="">请选择区</option>
                </select>

        </span>  
            <br/>
            <br/>


      <label>搜索商品</label>
     <div class="wrap_line" style="    display: initial;">
        <select id="factory"  name="factory_id">
             <option value="">选择水厂</option>
        </select>

        <select id="waterbrand"  name="water_brandno">
            <option value="">选择水品牌</option>
        </select>

            <select id="water_goods"  name="water_goods_id" >
                <option value="">选择水商品</option>
            </select>
             <select id="water_volumes"  name="water_volume" >
                <option value="">选择水容量</option>
            </select>

    </div>
            <input style="padding-left:10px;" type="submit" value="查询" id="btn"/>
        </form>
    </div>

  
    <div style="clear:both;"></div>
        <table class="table table-hover"">
            <thead>
            <th> <p class="tablehot"></p> </th>
            <th>序号</th>
            <th>水厂条码</th>
            <th>设备编号</th>
            <th>水厂</th>
            <th>水品牌</th>
            <th>商品名称</th>
            <th>商品容量(L)</th>
            <th>所在区域</th>
            <th>位置信息</th>
            <th>设备商品型号</th>
            <th>设备品牌</th>
            <th>设备厂家</th>
            <th>设备投资商</th>
            <th>服务中心</th>
            <th>运营中心</th>
            <th>入网属性</th>
            <th>用户类型</th>
            <th>用户姓名</th>
            <th>手机号</th>
            <th><a id="sort" href="">扫码时间</a></th>
            </thead>
            <tbody>
            <?php
            $str='';
            $no=1;
            foreach($model as $key=>$val)
                {
                $str.= "<tr>
                                  <th> <p class='tablehot'></p> </th>
                            <td>".$no."</td>
                            <td>".$val["BarCode"]."</td>
                            <td>".$val["DevNo"]."</td>
                            <td>".$val["factoryName"]."</td>
                            <td>".$val["water_brand"]."</td>
                            <td>".$val["water_name"]."</td>
                            <td>".$val["Volume"]."</td>
                            <td>".$val["Province"]."-".$val["City"]."-".$val["Area"]."</td>
                            <td>".$val["Address"]."</td>
                            <td>".$val["goodsname"]."</td>
                            <td>".$val["BrandName"]."</td>
                            <td>".$val["devfactoryname"]."</td>
                            <td>".$val["investor"]."</td>
                            <td>".$val["agentname"]."</td>
                            <td>".$val["agentpname"]."</td>
                            <td>".$UserType[$val["UseType"]]."</td>
                            <td>".$CustomerType[$val["CustomerType"]]."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["Tel"]."</td>
                            <td>".$val["RowTime"]."</td>
                        </tr>";
                $no++;
            }
            echo $str;
            ?>
            </tbody>
        </table>
        <table>

        </table>

    <script>
        var content='<?=$content?>';
        var selecttime='<?=json_encode($selecttime)?>';
        var factory=<?=json_encode($factory)?>;
        var water_brands=<?=json_encode($water_brands)?>;
        var water_goods=<?=json_encode($water_goods)?>;
        var water_volumes=<?=json_encode($water_volumes)?>;
       
         var factory_id='<?=$factory_id?>';
         var water_brandno='<?=$water_brandno?>';
         var water_goods_id='<?=$water_goods_id?>';
         var water_volume='<?=$water_volume?>';
         var DevNo=<?=$DevNo?>;
         var sort=<?=$sort?>;


 



    </script>
<script type="text/javascript">
$(function(){
      RenderingAgent(factory, $("#factory"))
      Renderingdev(water_brands, $("#waterbrand")) ;
       Renderingdevgoods(water_goods, $("#water_goods"))
    
       initDev( $("#waterbrand"), $("#water_goods"),water_goods)  

          Renderingdevvolume(water_volumes,  $("#water_volumes"))
          $("#water_volumes").val(water_volume)
       // initDevgoods($("#water_goods"), $("#waterbrand"),water_brands)  
    $("#factory").val(factory_id)
    $("#waterbrand").val(water_brandno)
    $("#water_goods").val(water_goods_id)
    

})



     // 角色选择渲染
    function RenderingAgent($data, $id) {
      for (var index = 0; index < $data.length; index++) {
        var item = $data[index];


        if (item.ParentId) {
          $id.append("<option value='" + item.Id + "' data ='" + item.ParentId + "' >" + item.Name + "</option>");
        } else {
          $id.append("<option value='" + item.Id + "'>" + item.Name + "</option>");
        }
      }
    }

   function Renderingdev($data, $id) {
      for (var index = 0; index < $data.length; index++) {
        var item = $data[index];

            var brand = item.BrandNo
        var Name =item.BrandName
       

        $id.append("<option value='" + brand + "' datei =" + brand + ">" + Name + "</option>");
        

      }
    }

   function Renderingdevgoods($data, $id) {
      for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
           var brand =  item.brand_id;
        var Name =  item.name ; 
 
        $id.append("<option value='" + item.id + "' datei="+brand+">" + Name + "</option>");
        

      }
    }
function Renderingdevvolume($data, $id) {
      for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
        var volume =  item.volume ; 
        var waterbrand = $("#waterbrand").val()
       var water_goods = $("#water_goods option:selected").text()

       if(waterbrand&&water_goods){
        if(waterbrand==item.brand_id&&water_goods==item.name){
            $id.append("<option value='" + volume + "'>" + volume + "</option>");
        }
      } else{
           $id.append("<option value='" + volume + "'>" + volume + "</option>");
        }
        

      }
    }
 $("#water_goods").on("change", function() {
         $("#water_volumes").empty();
        $("#water_volumes").append("<option value='' selected>请选择容量</option>");
        // $Id2.append("<option value='' selected>请选择商品</option>");
        Renderingdevvolume(water_volumes,  $("#water_volumes"))
      // Renderingdevgoods(water_goods, $("#water_goods"))
  });


function initDev($Id1, $Id2, $data) {
      $Id1.on("change", function() {
      

        if ($(this).val() == '') {
           Renderingdevgoods(water_goods, $("#water_goods"))
          return;
        }

        var _thisId = $('option:selected',this).attr("datei"); 

        $Id2.empty();
         $("#water_volumes").empty();

        $("#water_volumes").append("<option value='' selected>请选择容量</option>");
        $Id2.append("<option value='' selected>请选择商品</option>");

        for (var i = 0; i < $data.length; i++) {
          var item = $data[i];
          var brand =item.brand_id
          var Name =item.name
                 console.log(item)
          if (_thisId == brand) {
              $Id2.append("<option value='" + item.id + "' datei =" + brand + ">" + Name + "</option>");
          }
        }
      });
}
function initDevgoods($Id1, $Id2, $data) {
      $Id1.on("change", function() {
        if ($(this).val() == '') {
           // Renderingdevgoods( $data,$Id2)
          return;
        }
        var _thisId = $('option:selected',this).attr("datei"); 
        var _thisvalval=$(this).val()
        var _thisvaltext=$('option:selected',this).text()
        // $Id2.append("<option value='' selected>请选择商品</option>");

        for (var i = 0; i < $data.length; i++) {
          var item = $data[i];
          var brand =item.BrandNo
          var Name =item.BrandName
           if (_thisId == brand) {
                // $Id2.append("<option value='" + Name + "'>" + Name + "</option>");
                 $Id2.val(Name)
           }
        }
        for(var y=0;y<water_volumes.length;y++){
            var item = water_volumes[y];  
    
 
            if(item.brand_id==_thisId  && item.name==_thisvaltext){
                  $("#water_volumes").append("<option value='" + item.volume + "'>" + item.volume + "</option>")
                   $("#water_volumes").val(item.volume)
            }
              
               }



      });
}








    //排序
    $('#sort').click(function(){
        sort++;

        var content=$('#content').val();
        var selecttime=$('#selecttime').val();

        $(this).attr('href','./?r=saoma/detail&sort='+sort+'&content='+content+'&selecttime='+selecttime+'&DevNo='+DevNo);

    });


    $(function(){
        $('.pagination a').click(function(){

            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();
            var page_size=$('#page_size option:selected').val();

            var href=$(this).attr('href');

            $(this).attr('href',href+'&content='+content+'&sort='+sort+'&selecttime='+selecttime+'&DevNo='+DevNo+'&per-page='+page_size);
//                var href2=$(this).attr('href');
//                alert(href2)
        });
    });



    $(function(){

        var dateRange = new pickerDateRange('selecttime', {
            aRecent7Days : '', //最近7天
            isTodayValid : true,
            //startDate : '2013-04-14',
            //endDate : '2013-04-21',
            //needCompare : true,
            //isSingleDay : true,
            //shortOpr : true,
            defaultText : '至',
            inputTrigger : 'selecttime',
            theme : 'ta',
            success : function(obj) {
//                startTimeStr = obj.startDate;
//                endTimeStr = obj.endDate;
            }
        });
        $("#selecttime").val('<?=$selecttime?>');
    });




</script>

</div>







<?php
echo "";
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=saoma/detail' id='butn'>确定</a></span>
</dev>"
?>


<script>
    //分页
    $('#page_size').val(<?=$page_size?>);
    $('#butn').click(function () {
        var content=$('#content').val();
        var selecttime=$('#selecttime').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&selecttime='+selecttime+'&sort='+sort+'&DevNo='+DevNo);
        var href2=$(this).attr('href');
//            alert(href2);

    });
</script>