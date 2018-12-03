<?php
use yii\widgets\LinkPager;
?>
       <link rel="stylesheet" href="./static/css/chosen.css"/>

<link rel="stylesheet" type="text/css" href="./static/css/Common.css">
<!--  <link rel="stylesheet" href="./static/css/Common.css"/> -->
    <div class="wrapper wrapper-content">
        <div style="text-align: right;margin-bottom: 10px">
               <a class="btn btn-primary" href="/index.php?r=dev-investor/list&<?=$url?>">返回</a>     
        </div> 
        <table class="table table-hover" >
            <thead>
            <th style="width: 5%">序号</th>
            <th style="width: 10%">名称</th>
            <th style="width: 9%">投资区域</th>
            <th style="width: 18%">投资设备</th>
            <th style="width: 8%">设备品牌</th>
            <th style="width: 6%">设备厂家</th>
            <th style="width: 8%">投资数量</th>
            <th style="width: 8%">投资时间</th>
            </thead>
            <tbody>
            <?php
            $str='';
            $no=1;
                foreach($model as $key=>$val)
                {
                    $str.= "<tr>
                        <td>".$no."</td>
                        <td>".$val["investor"]."</td>
                        <td>".($val["province"]."-".$val["city"])."</td>
                        <td>".$val["name"]."</td>
                        <td>".$val["BrandName"]."</td>
                        <td>".$val["factory_name"]."</td>
                        <td>".$val["number"]."</td>
                        <td>".$val["time"]."</td>
                        </tr>";
                    $no++;
                }
                echo $str;

            ?>
            </tbody>
        </table>



    </div>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script>
//        var data =<?//=json_encode($address)?>//;
//        var province='<?//=$province?>//';
        var id=<?=$agent_id?>;
        var name='<?=$name?>';
        var url='<?=$url?>';

        console.log(url)
//        var sort=<?//=$sort?>//;
    </script>
    <script>

        $(function(){
            $('.pagination a').click(function(){

                var username=$('#username').val();
                var mobile=$('#mobile').val();
                var province=$('#province option:selected').val();
                var city=$('#city option:selected').val();
                var area=$('#area option:selected').val();
                var page_size=$('#page_size option:selected').val();

                var href=$(this).attr('href');

//                $(this).attr('href',href+'&username='+username+'&mobile='+mobile+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&per-page='+page_size);
                $(this).attr('href',href+'&per-page='+page_size+'&id='+id+'&name='+name);
//                var href2=$(this).attr('href');
//                alert(href2)
            });
        });


        

        $(function(){
//            initProvince();
//            initListener();
//            initAddress();
        });
        function initAddress() {
            $("#province").val(province);
            initCityOnProvinceChange();
            $("#city").val(city);
            initThree();
            $("#area").val(area);
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
            $("#area").empty();
            $("#area").append("<option value='' selected>请选择</option>");
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
       <script type="text/javascript" src="/static/js/jquery.min.js"></script>
        <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>    

<?php
echo "<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>";
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=dev-investor/see' id='butn'>确定</a></span>
</dev>"

?>


<script>
// 
    $('#page_size').val(<?=$page_size?>);
$("#page_size").chosen({no_results_text: "没有找到",disable_search: true}); //初始化chosen
    $('#butn').click(function () {
//        var username=$('#username').val();
//        var mobile=$('#mobile').val();
//        var province=$('#province option:selected').val();
//        var city=$('#city option:selected').val();
//        var area=$('#area option:selected').val();

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&id='+id+'&name='+name);
//        var href2=$(this).attr('href');
//            alert(href2);

    });
    
   
</script>
