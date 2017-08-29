<html>
<head>
    <style>
        body{
            padding: 0;
            margin: 0;
        }
        .body {
            float: left;
            height: 35px;
            line-height: 35px;
            width: 100%;
            margin: 6px 0px 10px 0px;
        }

        .body .t1{
            float: left;
            width: 120px;
            text-align: right;
            height: 35px;
            line-height: 35px;
        }
        .body .t2{
            float: left;
            width: 200px;
            text-align: left;
            height: 35px;
            line-height: 35px;
        }
        .text{
            width: 160px;
            height: 25px;
        }
        .modal-body{
            height: 200px;
        }
        .sign{
            color: red;
        }
        .lbtn{
            width: 70px;
            height: 30px;
            line-height: 30px;
            border: none;
            background-color: #1aa5f1;
            margin-left: 45px;
            color: #fff;
            border-radius: 3px;
            font-weight: 300;
        }
    </style>
</head>
<body>
<div class="body">
    <div class="t1">
        <span class="sign">*</span>
        <span>频道名称：</span>
    </div>
    <div class="t2">
        <input id="_categoryname" type="text" maxlength="16" class="text" onchange="_changecategoryname()"/>
    </div>
</div>
<div class="body">
    <div class="t1">
        <span class="sign">*</span>
        <span>频道ID号：</span>
    </div>
    <div class="t2">
        <input id="_categoryid" type="text" maxlength="16" class="text"/>
    </div>
</div>
<div class="body">
    <input class="lbtn" type="button" value="保存" onclick="save()"/>
    <input class="lbtn" type="button" value="关闭" onclick="_close()"/>
</div>
<script type="text/javascript">

    $("#_categoryname").keyup(function(){
        var val=$(this).val();
        $("#_categoryid").val(ConvertPinyin(val));
    });

    function save(){
        if($("#_categoryname").val().length==0){
            alert("频道名称不能为空！");
            $("#_categoryname").focus();
            return false;
        }
        if($("#_categoryid").val().length==0){
            alert("频道ID号不能为空！");
            $("#_categoryid").focus();
            return false;
        }

        var data="name="+ encodeURIComponent($("#_categoryname").val());
        data+="&id="+encodeURIComponent($("#_categoryid").val());
        var ii=layer.msg("操作中……");
        $.getJSON("/index.php?r=goods/savecategory&"+data,function(data){
            layer.close(ii);
            if(data.state!=0){
                layer.alert(data.msg);
                return;
            }
            else{
                bindcategory();
                _close();
            }
        });

    }

    function _close(){
        $('.close').click();
    }
</script>
</body></html>
