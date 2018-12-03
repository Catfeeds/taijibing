<!DOCTYPE html>
<html style="overflow-x:hidden;overflow-y:hidden">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="X-UA-Compatible"content="IE=9; IE=8; IE=7; IE=EDGE">
    <link rel="stylesheet" href="./static/js/zui/css/zui.css"/>
    <link rel="stylesheet" href="./static/js/zui/css/style.css"/>
    <link rel="stylesheet" href="./static/js/datepicker/dateRange.css"/>
    <link rel="stylesheet" href="./static/js/jedate/skin/jedate.css"/>
    <link rel="stylesheet" href="./static/js/page/jquery.pagination.css"/>
     <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
    <style>
        .operateBtn{
            font-size:12px;
            padding:0px 5px;
            color:blue;
        }
        .operateBtn:hover{
            cursor:pointer;
        }
        .du_area_item{
            padding-left:5px;
        }

        .input{
            font-size: 14px;
        }
        .rect{
            width:110px;
            height:100px;
            padding-top: 10px;
            border: 1px solid #DDDDDD;
            background-color: #EBF2F9;
        }
        .rect div{
            float: left;
            width:100%;
            margin:0px 0px;
            cursor: pointer;
        }
        .rect :hover{
            background-color: #FF9900;
        }
        .rect div a{
            margin:1px 8px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="main-title">
    <h2>失效商品管理&nbsp;&nbsp;&nbsp;</h2>
</div>
<div id="sample_2_wrapper" class="dataTables_wrapper form-inline" role="grid" style="padding-left:10px;">
    <table style="margin: 5px 0 10px 0;width: 100%" cellpadding="5px">
        <tr>
            <td style="width: 100px;text-align: left">供应商名称：</td>
            <td style="width: 200px;text-align: left">
                <select id="merchantid" style="width: 180px">
                    <option value="0">请选择</option>
                </select> </td>
            <td style="width: 100px;text-align: right">商品频道：</td>
            <td style="width: 200px">
                <select id="categoryid" style="width: 180px">
                    <option value="0">请选择</option>
                </select>
            </td>
            <td style="width: 80px"></td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 80px;text-align: left">商品名称：</td>
            <td style="width: 200px;text-align: left"><input id="name" type="text" maxlength="25" style="width:180px"/> </td>
            <td style="width: 80px;text-align: right">下架时间：</td>
            <td style="width: 200px">
                <input id="time" type="text" maxlength="11" style="width:180px"/>
            </td>
            <td style="width: 80px;text-align: right"><input type="button" class="btn  select_btn" value="查询" onclick="query()"/> </td>
            <td><input type="button" class="btn  select_btn" value="清空" onclick="cleardata()"/> </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right"><input type="button" class="btn  select_btn" value="+添加商品" onclick="window.location='/index.php?r=goods/addgood'"/></td>
        </tr>
    </table>
    <div class="rect" style="display: none;position: absolute;left: 0px;top: 0px">
        <div onclick="update()"><a>修改商品</a></div>
        <div onclick="shelf()"><a>下架</a></div>
        <div onclick="copy()"><a>复制链接</a></div>
        <div onclick="copytounshelf()"><a>复制到待售商品</a></div>
    </div>
    <table class="table table-striped table-bordered table-hover dataTable" id="sample_2" aria-describedby="sample_2_info">

        <thead>

        <tr role="row">
            <th style="text-align:center;min-width:100px;">序号</th>
            <th style="text-align:center;min-width:140px;">商品名称</th>
            <th style="text-align:center;min-width:120px;">商品频道</th>
            <th style="text-align:center;min-width:140px;">供应商名称</th>
            <th style="text-align:center;min-width:100px;">总库存</th>
            <th style="text-align:center;min-width:100px;">商品销量</th>
            <th style="text-align:center;min-width:120px;">操作人</th>
            <th style="text-align:center;min-width:140px;">上架时间</th>
            <th style="text-align:center;min-width:140px;">下架时间</th>
            <th style="text-align:center;min-width:140px;">操作</th>
        </tr>
        </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all" id="tbody">
        </tbody>
    </table>
    <div id="page" class="m-pagination"></div>
</div>
<div id="selectUserContainer" style="display:none;">

    <div  class="selectUserContainer">
        <div  class="UserContainer">
        </div>
        <div class="form-actions" style="padding-left:0px;text-align:center;background:white;border:0px;">
            <button class="dialogBtn" type="submit" class="btn blue"><i class="icon-ok"></i> 确定</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script src="./static/js/page/jquery.pagination-1.2.7.js"></script>
<script src="./static/js/page/page.js"></script>

<script src="./static/js/datepicker/dateRange.js"></script>
<script>
    var category=<?=json_encode($category)?>;
    var merchant=<?=json_encode($merchant)?>;
    var addr='<?=$preview?>';
</script>
<script type="text/javascript">
    var starttime="";
    var endtime="";
    var goodid="";
    $(function(){
        starttime=new Date().dateAdd('d',-30).Format("yyyy-MM-dd");
        endtime=new Date().dateAdd('d',0).Format("yyyy-MM-dd");

        var dateRange = new pickerDateRange('time', {
            aRecent7Days: '', //最近7天
            defaultText: '至',
            stopToday:false,
            inputTrigger: 'time',
            theme: 'ta',
            success: function (obj) {
                starttime = obj.startDate;
                endtime = obj.endDate;
            }
        });

        query();
        $("#categoryid").empty();
        $("#merchantid").empty();
        $("<option value='0'>请选择</option>").appendTo($("#categoryid"));
        $("<option value='0'>请选择</option>").appendTo($("#merchantid"));

        for(var i=0; i<category.length;i++) {
            var item = category[i];
            $("<option value='" + item["id"] + "'>" + item["name"] + "</option>").appendTo($("#categoryid"));
        }
        for(var i=0; i<merchant.length;i++) {
            var item = merchant[i];
            $("<option value='" + item["id"] + "'>" + item["name"] + "</option>").appendTo($("#merchantid"));
        }


    });

    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1,                 //月份
            "d+": this.getDate(),                    //日
            "h+": this.getHours(),                   //小时
            "m+": this.getMinutes(),                 //分
            "s+": this.getSeconds(),                 //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds()             //毫秒
        };
        if (/(y+)/.test(fmt))
            fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

    Date.prototype.dateAdd = function(interval,number)
    {
        var d = this;
        var k={'y':'FullYear', 'q':'Month', 'm':'Month', 'w':'Date', 'd':'Date', 'h':'Hours', 'n':'Minutes', 's':'Seconds', 'ms':'MilliSeconds'};
        var n={'q':3, 'w':7};
        eval('d.set'+k[interval]+'(d.get'+k[interval]+'()+'+((n[interval]||1)*number)+')');
        return d;
    }

    function cleardata(){
        $("#name").val("");
        $("#categoryid").val("0");
        $("#merchantid").val("0");
        $("#time").val("");
    }

    function expand(obj,id){
        goodid=id;
        var Y = $(obj).offset().top;
        var X = $(obj).offset().left;
        if($(".rect").css("display")=="none") {
            $(".rect").css({
                position: "absolute",
                'top': Y - 36,
                'left': X - 250,
                'z-index': 1000,
                display: "block"
            });
        }
        else{
            goodid="";
            collapse();
        }
    }

    function collapse(){
        $(".rect").css({
            display: "none"
        });
    }

    function update(){
        window.location.href="addgood?id="+goodid;
    }

    function copy(){
        layer.alert({$preview}+goodid);
    }



    function copytounshelf(goodid){
        if(!window.confirm("确认复制该商品吗？")){
            return;
        }
        var ii=layer.msg("操作中……");
        $.getJSON("/index.php?r=goods/copytounshelf&id="+goodid,function(data){
            layer.close(ii);
            if(data.state!=0){
                layer.alert(data.msg);
                return;
            }
            collapse();
        });

    }
    //拉取分页数据
    function query() {
        var stime="";
        var etime="";
        if($("#time").val()!=""){
            stime=starttime;
            etime=endtime+" 23:59:59";
        }
        $("#tbody").empty();
        $("#page").page('destroy');
        var ii = layer.msg('加载中');
        $("#page").page({
            debug: false,
            showInfo: true,
            showJump: true,
            showPageSizes: false,
            remote: {
                url:"/index.php?r=goods/get-sales",
                params: {
                    name:encodeURIComponent($("#name").val()),
                    categoryid:encodeURIComponent($("#categoryid").val()),
                    merchantid:encodeURIComponent($("#merchantid").val()),
                    starttime:encodeURIComponent(stime),
                    endtime:encodeURIComponent(etime),
                    saling:"2"
                },
                success: function (data) {
                    if (data.state != 0) {
                        layer.close(ii);
                        layer.alert(data.msg);
                        return;
                    }
                    $("#tbody").html("");
                    $.each(data.data, function (index, item) {
                        var str="";
                        var r=(eval(item.total)-eval(item.amount)==0?"background-color:#647C9D":"");
                        str+="<div onclick=copytounshelf('"+item.id+"')><a>复制到待售商品</a></div>";
                        var  htmlStr='<tr dataid="'+item.id+'" >' +
                            '<td style="text-align:center;'+r+'" >'+item.num+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+("<a style='margin-right: 5px;font-size: 16px' href='javascript:void(0)' data-id='"+item.id+"' onclick='ex(this)'>+</a>")+("<span>"+item.name+"</span>")+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+(item.categoryname)+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+(item.merchantname)+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+(item.total>=99999999?"":item.total)+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+(item.amount<0?0:item.amount)+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+(item.lastopuser)+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+(item.starttime)+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+(item.endtime)+'</td>' +
                            '<td style="text-align:center;'+r+'" >'+str+'</td>' +
                            '</tr>';
                        $("#tbody").append(htmlStr);

                        var div2="<div style='display:inline-block;width:120px;height: 25px;color: #0000ff;text-align: left'>库存</div>";
                        var div3="<div style='display:inline-block;width:120px;height: 25px;color: #0000ff;text-align: left'>商品销量</div>";
                        var div4="<div style='display:inline-block;width:120px;height: 25px;color: #0000ff;text-align: left'>结算价</div>";

                        var strs="";
                        for(var j=0;  j<item.data.length;j++) {
                            var subitem=item.data[j];
                            var lineStr='<div>';
                            //第一行
                            lineStr+="<div style='text-align:left;padding-left:150px;'><div style='display:inline-block;width:240px;height: 25px;color: #0000ff;text-align: left;'>"+subitem.name+"</div>";
                            lineStr+=div2;
                            lineStr+=div3;
                            lineStr+=div4;
                            lineStr+="</div>";
                            //第一行 end
                            var controlJson=JSON.parse(subitem.data);
                            var itemid=subitem.itemid;
                            var currentItemIndex=-1;
                            var itemObj=null;
                            if(controlJson!=null){
                                for(var itemindex=0;itemindex<controlJson.Items.length;itemindex++){
                                    var itemTemp=controlJson.Items[itemindex];
                                    if(itemTemp.ItemId==itemid){
                                        currentItemIndex=itemindex;
                                        itemObj=itemTemp;
                                    }
                                }
                            }

                            if(itemObj!=null&&currentItemIndex!=-1){
                                if(itemObj.Prices.length==0){
                                    //没有出行时间
                                    lineStr+="<div style='text-align: left;padding-left:150px;'>";
                                    var _div1 = "<div style='display:inline-block;width:240px;height: 25px;color: #333333;text-align: left;'></div>";
                                    var _div2 = "<div style='display:inline-block;width: 120px;height: 25px;color: #333333;text-align: left'>"+(itemObj.DefaultTotal>=99999999?"":itemObj.DefaultTotal)+"</div>";
                                    var _div3 = "<div style='display:inline-block;width:120px;height: 25px;color: #333333;text-align: left'>"+(subitem.sale<0?0:subitem.sale)+"</div>";
                                    var _div4 = "<div style='display:inline-block;width:120px;height: 25px;color: #333333;text-align: left'>"+subitem.costprice+"</div>";
                                    lineStr+=_div1;
                                    lineStr+=_div2;
                                    lineStr+=_div3;
                                    lineStr+=_div4;
                                    lineStr+="</div>";
                                }else{
                                    for(var priceindex=0; priceindex<itemObj.Prices.length;priceindex++){
                                        var  priceItem=itemObj.Prices[priceindex];
                                        lineStr+="<div style='text-align: left;padding-left:150px;'>";
                                        var _div1 = "<div style='display:inline-block;width:240px;height: 25px;color: #333333;text-align: left;'>"+priceItem.StartTime+"至"+priceItem.EndTime+"</div>";
                                        var _div2 = "<div style='display:inline-block;width: 120px;height: 25px;color: #333333;text-align: left'>"+(priceItem.Total>=99999999?"":priceItem.Total)+"</div>";
                                        var _div3 = "<div style='display:inline-block;width:120px;height: 25px;color: #333333;text-align: left'>"+(subitem.sale<0?0:subitem.sale)+"</div>";
                                        var _div4 = "<div style='display:inline-block;width:120px;height: 25px;color: #333333;text-align: left'>"+subitem.costprice+"</div>";
                                        lineStr+=_div1;
                                        lineStr+=_div2;
                                        lineStr+=_div3;
                                        lineStr+=_div4;
                                        lineStr+="</div>";
                                    }
                                }
                            }
                            lineStr+="</div>";
                            strs+=lineStr;
                        }
                        var copyStr='<tr id="c'+item.id+'" style="display: none">' +
                            '<td colspan="10" style="text-align:center;background-color: #f2f2f2;" >'+
                            '<div style="width: 100%;margin-top: 3px" >'+strs+'</div>'+
                            '</td>' ;
                        $("#tbody").append(copyStr);

                    });
                    layer.close(ii);
                }
            }
        });
    }

    function ex(obj) {
        var html = $(obj).html();
        var id=$("#c"+$(obj).attr("data-id"));
        if (html == "+") {
            html = "-";
            id.css("display","");
        }
        else {
            html = "+";
            id.css("display","none");
        }
        $(obj).html(html);
    }
</script>
</body>
</html>

