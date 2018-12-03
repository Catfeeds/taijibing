<?php
use yii\widgets\LinkPager;
use feehi\widgets\Bar;
?>
   <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<div class="wrapper wrapper-content">

    <form action="./?r=tea-brand/list" method="post">
        关键词：<input id="search" placeholder="请输入名称、品牌或厂家"  value="<?=$search?>"  type="text" name="search">
        <input type="submit" value="搜索" >
    </form>

    <?= Bar::widget([
        'template' => '{create}'
    ])?>
    <table class="table table-hover" >
        <thead>
        <th style="width:5%">序号</th>
        <th style="width:8%">商品名称</th>
        <th style="width:8%">商品品牌</th>
<!--        <th style="width:8%">设备厂家</th>  <td>".$val["devfactory_name"]."</td>-->
        <th style="width:8%">设备升级类型</th>
<!--        <th style="width:8%">设备图片</th>-->
        <th style="width:8%">卡片厂家</th>
        <th style="width:12%"><a id="sort" href="">添加时间</a></th>
        <th style="width:12%"><a id="sort2" href="">修改时间</a></th>
        <th style="width:8%">操作</th>
        </thead>
        <tbody>
        <?php
        $str='';
        $no=1;
        foreach($model as $key=>$val)
        {
            $updatetime=$val["updatetime"]>1?date('Y-m-d H:i:s',$val["updatetime"]):'';
            $str.= "<tr>
                        <td>".$no."</td>
                        <td>".$val["name"]."</td>
                        <td>".$val["BrandName"]."</td>

                        <td>".$val["type"]."</td>

                        <td>".$val["cardfactory"]."</td>
                        <td>".date('Y-m-d H:i:s',$val["addtime"])."</td>
                        <td>".$updatetime."</td>
                        <td>
                            <a href='./?r=tea-brand/update&id=".$val["id"]."')>修改</a>
                            <a href=javascript:deleteWaterBrand('".$val["id"]."')>删除</a>
                        </td>
                     </tr>";
            $no++;
        }
        echo $str;
        ?>
        </tbody>
    </table>
    <table>
      
    </table>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/layer/layer.js"></script>
    <script>
        var search='<?=$search?>';
        var sort=<?=$sort?>;
        var sort2=<?=$sort2?>;
    </script>
<script>

    //排序(添加时间)
    $('#sort').click(function(){
        sort++;

        var search=$('#search').val();

        $(this).attr('href','./?r=tea-brand/list&sort='+sort+'&search='+search);
//            alert($(this).attr('href'));

    });

    //排序（修改时间）
    $('#sort2').click(function(){
        sort2++;

        var search=$('#search').val();

        $(this).attr('href','./?r=tea-brand/list&sort2='+sort2+'&search='+search);
//            alert($(this).attr('href'));

    });


    $(function(){
        $('.pagination a').click(function(){

            var search=$('#search').val();
            var page_size=$('#page_size option:selected').val();
            var href=$(this).attr('href');

            $(this).attr('href',href+'&search='+search+'&sort='+sort+'&sort2='+sort2+'&per-page='+page_size);
//                var href2=$(this).attr('href');
//                alert(href2)
        });
    });




    function deleteWaterBrand(brandno){
        if(confirm("你确认要删除吗？")){
            var ii=layer.msg("操作中……");
            $.getJSON("/index.php?r=tea-brand/delete&id="+brandno,function(data){

                layer.close(ii);
                if(data.state!=0){
                    layer.alert(data.desc);
                    return;
                }
                layer.alert("操作成功",function(){
                    window.location.reload(true);
                });
            });
        }else{
            return
        }


    }
//    function updateWaterBrand(brandno){
//       window.location.href="/index.php?r=water-brand/update&brandno="+brandno;
//    }
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
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=tea-brand/list' id='butn'>确定</a></span>
</dev>"

?>
<script>
    //分页
    $('#page_size').val(<?=$page_size?>);
    $('#butn').click(function () {
        var search=$('#search').val();

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&search='+search+'&sort='+sort+'&sort2='+sort2);
        var href2=$(this).attr('href');
//            alert(href2);

    });
</script>
