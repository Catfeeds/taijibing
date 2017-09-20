<?php
use yii\widgets\LinkPager;
use feehi\widgets\Bar;
?>

<div class="wrapper wrapper-content">

    <form action="./?r=tea-brand/list" method="post">
        关键词：<input id="search" placeholder="请输入名称、品牌或厂家"  value="<?=$search?>"  type="text" name="content">
        <input type="submit" value="搜索" >
    </form>

    <?= Bar::widget([
        'template' => '{create}'
    ])?>
    <table class="table table-hover" style="background:white;">
        <thead>
        <th style="width:5%">序号</th>
        <th style="width:8%">商品名称</th>
        <th style="width:8%">商品品牌</th>
        <th style="width:8%">设备厂家</th>
        <th style="width:8%">品牌编号</th>
        <th style="width:8%">设备图片</th>
        <th style="width:8%">卡片厂家</th>
        <th style="width:8%">添加时间</th>
        <th style="width:8%">修改时间</th>
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
                        <td>".$val["devfactory_name"]."</td>
                        <td>".$val["BrandNo"]."</td>
                        <td>查看</td>
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
    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script>

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
<?= LinkPager::widget(['pagination' => $pages]); ?>
