<?php
use yii\widgets\LinkPager;
use feehi\widgets\Bar;
?>
 <link rel="stylesheet" href="./static/css/chosen.css"/>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css?v=1">
<div class="wrapper wrapper-content">
    <?= Bar::widget([
        'template' => '{create}'
    ])?>
    <table class="table table-hover"  >
        <thead>
        <th>编号</th>
        <th>代号</th>
        <th>地址名称</th>
        <th><a href="" id="sort">添加时间</a></th>
        <th>所属省市</th>
        <th>操作</th>
        </thead>
        <tbody>
        <?php
        $str='';
        foreach($model as $key=>$val)
        {
            $str.= "<tr><td>".$val["Id"]."</td>
                        <td>".$val["CityNumber"]."</td>
                        <td>".$val["Name"]."</td>
                        <td>".$val["RowTime"]."</td>
                        <td>".$val["parent"]."</td>
                        <td><a href=javascript:deleteAddress('".$val["Id"]."')>删除</a></td>
                        </tr>";
        }
        echo $str;
        ?>
        </tbody>
    </table>
    <!-- <select class="form-control"  id="addresses" > -->
    </select>
    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
    <script>
        var data=<?=$data?>;
        var sort=<?=$sort?>;
    </script>
<script>
    //排序
    $('#sort').click(function(){
        sort++;
        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
        $(this).attr('href','./?r=address/index&sort='+sort+'&page='+pages+'&per-page='+page_size);

    });


    $(function(){
        initAddressSelect();
    });
    function deleteAddress(id){
        var ii=layer.msg("操作中……");
        $.getJSON("/index.php?r=address/delete&id="+id,function(data){
            layer.close(ii);
            if(data.state!=0){
                layer.alert(data.desc);
                return;
            }
            layer.alert("操作成功",function(){
                window.location.reload(true);
            });
        });
    }

    function initAddressSelect(){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId==0){
                $("#addresses").append("<option value='"+item.Id+"'>"+item.Name+"</option>");
                initSec(item.Id);
            }
        }
    }
    function initSec(pid){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#addresses").append("<option value='"+item.Id+"'>------"+item.Name+"</option>");
                initThree(item.Id)
            }
        }
    }
    function initThree(pid){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#addresses").append("<option value='"+item.Id+"'>-----------"+item.Name+"</option>");
            }
        }
    }


</script>

</div>
<?php
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px;padding-bottom: 100px;'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条


&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=address/index' id='butn' style='line-height: 30px;'>确定</a></span>
</dev>"
?>
<script>
    $(function(){
        $('.pagination a').click(function(){

            var page_size=$('#page_size option:selected').val();

            var href=$(this).attr('href');

            $(this).attr('href',href+'&per-page='+page_size+'&sort='+sort);
//                var href2=$(this).attr('href');
//                alert(href2)
        });
    });



    $('#page_size').val(<?=$page_size?>);

            $('#page_size').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#butn').click(function () {

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&sort='+sort);
//        var href2=$(this).attr('href');
//            alert(href2);

    });

</script>
