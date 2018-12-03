/**
 * Created by pengjixiang on 17/3/10.
 */
var op=1;
var sid="0";
$(document).ready(function(){

    $("#name").keyup(function(){
        var val=$(this).val();
        $("#id").val(ConvertPinyin(val));
    });
    //query();
    //initQiniu();
    if(baseGood.length<1){
        addGoodType();
    }


});

function initQiniu(){
    $.getJSON('/index.php?r=goods/getqiniukey',function(data){
        if(data.state==0){
            var key=data.result;
            initUploader(key,'image1');
            initUploader(key,'image2');
            initUploader(key,'image3');
            initUploader(key,'image4');
            initUploader(key,'image5');
            initUploader(key,'image6');

        }
    });
}

function initUploader(key,id){
    var cpts = Qiniu.uploader({
        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
        browse_button: id+'btn',         // 上传选择的点选按钮，**必需**
        uptoken : key, // uptoken 是上传凭证，由其他程序生成
        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
        unique_names: true,              // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
        domain:'7xpcl7.com2.z0.glb.qiniucdn.com',
        //domain:'7xodpu.com1.z0.glb.clouddn.com',//test
        max_file_size: '100mb',             // 最大文件体积限制
        flash_swf_url: '__PUBLIC__/js/qubuy/Moxie.swf',  //引入 flash,相对路径
        max_retries: 3,                     // 上传失败最大重试次数
        chunk_size: '4mb',                  // 分块上传时，每块的体积
        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
        init: {
            'FilesAdded': function(up, files) {
                plupload.each(files, function(file) {
                    // 文件添加进队列后,处理相关的事情
                });
            },
            'BeforeUpload': function(up, file) {
                // 每个文件上传前,处理相关的事情
                //$.showPreloader('上传中……');
            },
            'UploadProgress': function(up, file) {
                // 每个文件上传时,处理相关的事情
            },
            'FileUploaded': function(up, file, info) {
                //$.hidePreloader();
                var res = JSON.parse(info);
                var imgkey=res.key;
                var src="http://7xpcl7.com2.z0.glb.qiniucdn.com/"+res.key;
                $("#"+id).attr("src",src);
            },
            'Error': function(up, err, errTip) {
                //上传出错时,处理相关的事情
            },
            'UploadComplete': function() {
                //队列文件处理完毕后,处理相关的事情
            },
            'Key': function(up, file) {
                var key = "";
                // do something with key here
                return key
            }
        }
    });
}


function savegood(){

    var goodType=getSubGoodTypeJson();//选择商品的内容
    var datas=JSON.parse(goodType);

    for(var index=0;index<datas.length;index++){
        var items=datas[index];
        if(items.devinvestor==''||items.devbrand=='' ||items.devname==''){
            alert("请添加完整的数据");
            return false;
        }
    }

    //var id=$('#agent_id').val();
    //var name=$('#investor').val();

    var data="agent_id="+encodeURIComponent(id);//服务中心id
    data+="&name="+encodeURIComponent(name);//服务中心name
    data+="&subgoodtypes="+encodeURIComponent(getSubGoodTypeJson());//商品数据 数组

    var ii=layer.msg("操作中……");

    $.getJSON("/index.php?r=logic-user/save-dev&"+data,function(data){
        //alert(data);

        if(data.state!=0){
            layer.alert(data.msg);

            return;
        }
        else{
            //layer.alert('添加成功');
            alert('添加成功');

            window.location.replace("/index.php?r=logic-user/agentslist");
            //window.location.replace("/index.php?r=goods/update&id="+$("#id").val());
            //window.location.href("/index.php?r=goods/list");
            //window.history.back(-1);
        }
    });


}


function existDetail(){
    var tips=$("#tips").val();
    var spxq=$("#spxq").attr("src");
    var xj=$("#xj").attr("src");
    if($.trim(tips)==""&& $.trim(spxq)==""&& $.trim(xj)==""){
        return 0;
    }
    return 1;
}
var imgsrc="";
function showimg(title,obj){
    var title="预览"+title;
    imgsrc=$("#"+obj).attr("src");
    if(imgsrc==""||imgsrc==null){
        alert("请先上传图片！");
        return;
    }
    $.get("img","",function(msg){
        (new $.zui.ModalTrigger({custom: msg,title:title})).show();
    });
    $("#"+obj+"span").css("display","none");
}

function delimg(obj){
    $("#"+obj).removeAttr("src");
    $("#"+obj+"span").css("display","");
}

function bindcategory(){
    $.ajax({
        type: "POST",
        url: "./bindcategory?ajax=1",
        dataType:"json",
        data:"",
        success: function (data) {
            var array=data.data;
            $("#categoryid").empty();
            $("<option value='0'>请选择</option>").appendTo($("#categoryid"));
            for(var i=0; i<array.length;i++) {
                var item = array[i];
                $("<option value='" + item["id"] + "'>" + item["name"] + "</option>").appendTo($("#categoryid"));
            }

            layer.close(ii);
            $(".close").click();
        }
    });

}

function openUrl(){
    var title="频道管理";
    $.get("/index.php?r=goods/category","",function(msg){
        (new $.zui.ModalTrigger({custom: msg,title:title})).show();
    });

}

function addAttr(){
    var title="添加属性值";
    $.get("control","",function(msg){
        (new $.zui.ModalTrigger({custom: msg,title:title})).show();
    })
}

function addAttrControl(type,title){
    //$("div[ctype='"+type+"']").css("display","block");
    $("div[ctype='"+type+"']").show();
    switch(Number(type)){
        case 1:addOutDate();break;
        case 3:addGoodsDesc();break;
        case 11:addPickingUpMethods();break;
    }
    $("div[ctype='"+type+"']").find(".title").html(title+"：");
}

function openMark(){
    var title="地图标记";
    $.get("/index.php?r=goods/mark&name="+encodeURIComponent($("#address").val()),"",function(msg){
        (new $.zui.ModalTrigger({custom: msg,title:title})).show();
    })
}

function mark(point){
    $("#lat").val(point.lat);
    $("#lng").val(point.lng);
}


function query(){
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

    $(".content_top .f2 div select").change(function(){
        var c=$("#categoryid").find("option:selected").text();
        var m=$("#merchantid").find("option:selected").text();
        var l=$("#logictype").find("option:selected").text();
        $(".f3 span").html("您当前选择的是："+c+" > "+m+" >"+l);
        if(c=="请选择"||m=="请选择"||l=="请选择") {
            $("#nextstep").attr("disabled","disabled");
            return;
        }
        $("#nextstep").attr("disabled",false);
    });

    var id=GetQueryString("id");
    if(!id) {
        op=1;
        $("#mytitle").html("添加商品&nbsp;&nbsp;&nbsp;");
    }
    else
    {
        op=2;
        $("#mytitle").html("修改商品&nbsp;&nbsp;&nbsp;");
        var ii=layer.msg("加载中……");
        $.ajax({
            type: "POST",
            url: "./listgood?ajax=1",
            dataType:"json",
            data:"id="+id,
            success: function (data) {
                layer.close(ii);
                if(data.state!=0){
                    //layer.alert(data.msg);
                    return;
                }
                var item=data.data[0];
                $("#name").val(item["name"]);
                $("#id").val(item["id"]);
                $("#title").val(item["title"]);
                $("#merchantid").val(item["merchantid"]);
                $("#categoryid").val(item["categoryid"]);
                $("#logictype").val(item["logictype"]);

                $("input[name='f1']").each(function(obj){
                    if($(obj).attr("value")==item["expresstype"]){
                        $(obj).attr("checked","checked");
                    }
                });
                $("#initamount").val(item["initamount"]);
                $("#originalprice").val(item["originalprice"]);
                $("#saleprice").val(item["saleprice"]);
                $("#shophours").val(item["shophours"]);
                $("#tel").val(item["tel"]);
                $("#address").val(item["address"]);//lng lat
                $("#tips").val(item["tips"]);
                $("#memberdiscounttype").val(item["memberdiscounttype"]);
                $("#memberdiscountval").val(item["memberdiscountval"]);
                $("#endtime").val(item["endtime"]);


                if(data.msg[0]){
                    var msg=data.msg[0];
                    $("#MsgTailOfMerchant").val(msg["msgtailofmerchant"]);
                    $("#MsgTailOfUser").val(msg["msgtailofuser"]);
                }
                sid=item["id"];
                next();
            }
        });
    }
}

function next(){
    $(".content_top").css("display","none");
    $(".content_middle").css("display","");
}



//添加商品型号
function  addGoodType(){

    var itemAmount=$("#good_sub_type_c").find(".item").length;
    //alert(itemAmount);
    if(isNaN(itemAmount)){
        return;
    }
    var currentIndex=itemAmount+1;


    var itemStr=' <div class="item" id="item'+currentIndex+'" itemid="100" num="'+currentIndex+'">'+
        '<div class="good_sub_type">'+
        '<select onchange="change1('+currentIndex+')" id="devinvestor'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">设备投资商</option></select>'+
        '<select onchange="change2('+currentIndex+')" id="devbrand'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">设备品牌</option></select>'+
        '<select id="devname'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">设备名称</option></select>'+
        '<a href="javascript:void(0);"  class="delGoodType" style="margin-left:5px;float:left;height:25px;line-height: 25px;">删除</a>'+
        '</div>'+
        '<div style="clear:both;"></div>'+
        '</div>';

    //添加设备投资商数据
    $.get('./?r=logic-user/get-devinvestor',{'province':province,'city':city,'area':area},function(data){
        //console.log(data)
        var html="";
        $(data).each(function(i,v){
            if(v){
                html+="<option value='"+v.agent_id+"'>"+ v.investor+"</option>"
            }

        });
        $(html).appendTo('#devinvestor'+currentIndex);

        //console.log(data);
    });



    $("#good_sub_type_c").append($(itemStr));
    $(".delGoodType").unbind();
    $(".delGoodType").on("click",function(){
        $(this).parents(".item").eq(0).remove();


    });


}



//设备投资商改变时，获取对应的品牌
function change1(no){
    var agent_id=$('#devinvestor'+no+' option:selected').attr('value');
//console.log(agent_id);
    //if(category_id) {
        if (agent_id) {
            //添加对应品牌的设备商品数据
            $.get('./?r=logic-user/get-devbrand', {'agent_id': agent_id}, function (data) {
                //console.log(data);
                if (data != '') {
                    var html = "<option value=''>设备品牌</option>";
                    $(data).each(function (i, v) {
                        if (v) {
                            html += "<option value='" + v.BrandNo + "'>" + v.BrandName + "</option>"
                        }

                    });
                    //console.log(html);
                    $('#devbrand' + no).html('');
                    $(html).appendTo('#devbrand' + no);
                    //清空后面的下拉框数据
                    $('#devname'+no).html("<option value=''>设备名称</option>");



                } else {
                    var html = "<option value=''>设备品牌</option>";
                    $('#devbrand' + no).html('');
                    $(html).appendTo('#devbrand' + no);
                    //清空后面的下拉框数据
                    $('#devname'+no).html("<option value=''>设备名称</option>");

                }

            });
        } else {
            var html = "<option value=''>设备品牌</option>";
            $('#devbrand' + no).html('');
            $(html).appendTo('#devbrand' + no);
            //清空后面的下拉框数据
            $('#devname'+no).html("<option value=''>设备名称</option>");
        }
    //}
}


//设备品牌改变时，获取对应设备名称
function change2(no){
    //var goodsname=$('#goodsname'+no+' option:selected').attr('value');
    var agent_id=$('#devinvestor'+no+' option:selected').attr('value');
    var brand_id=$('#devbrand'+no+' option:selected').attr('value');

    if(brand_id){
           //添加商品名称数据
        $.get('./?r=logic-user/get-dev',{'agent_id':agent_id,'brand_id':brand_id},function(data){
            if(data!=''){
                var html="<option value=''>设备名称</option>";
                $(data).each(function(i,v){
                    if(v){
                        html+="<option value='"+v.id+"'>"+ v.goodsname+"</option>"
                    }

                });
                $('#devname'+no).html('');
                $(html).appendTo('#devname'+no);
                //清空后面的下拉框数据
                //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
                //$('#goodsfactory'+no).html("<option value=''>设备名称</option>");

            }else{
                var html="<option value=''>设备名称</option>";
                $('#devname'+no).html('');
                $(html).appendTo('#devname'+no);
                //清空后面的下拉框数据
                //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
                //$('#goodsfactory'+no).html("<option value=''>设备名称</option>");
            }

        });
    }else{
        var html="<option value=''>设备名称</option>";
        $('#devname'+no).html('');
        $(html).appendTo('#devname'+no);
        //清空后面的下拉框数据
        //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
        //$('#goodsfactory'+no).html("<option value=''>设备名称</option>");
    }

}



function getSubGoodTypeJson(){
    var itemAmount=$("#good_sub_type_c").find(".item").length;
    if(isNaN(itemAmount)){
        return "";
    }
    if(itemAmount==0){
        return "";
    }
    var objArr=$("#good_sub_type_c").find(".item");
    //var length=(num+itemAmount)*10;//避免删除后有些数据保存不了(后面需要优化)

    var typeList=[];
    //for(var index=1;index<=objArr.length;index++){
    //for(var index=1;index<=length;index++){//避免删除后有些数据保存不了
    //    var typeObj={};
    //    //typeObj.typename=encodeURIComponent($("#typename"+index).val());
    //    typeObj.devinvestor=$("#devinvestor"+index).find("option:selected").attr('value');//设备品牌
    //    typeObj.devbrand=$("#devbrand"+index).find("option:selected").attr('value');//设备名称
    //    typeObj.devname=$("#devname"+index).find("option:selected").attr('value');//设备厂家
    //    //typeObj.province=$("#province"+index).find("option:selected").attr('value');//省
    //    //typeObj.city=$("#city"+index).find("option:selected").attr('value');//市
    //    //typeObj.number=$("#realPrice"+index).val();//投资设备台数
    //    //typeObj.time=$("#originalPrice"+index).val();//时间
    //    //typeObj.Tatol=$("#Tatol"+index).val();
    //    //typeObj.itemId=$(objArr[index-1]).attr("itemid");
    //    //typeObj.num=$(objArr[index-1]).attr("num");
    //
    //    //if(typeObj.typename==""||isNaN(typeObj.realPrice)){
    //    //    continue;
    //    //}
    //
    //    //避免删除后有些数据保存不了
    //    if(typeObj.devinvestor!=undefined&&typeObj.devbrand!=undefined
    //        &&typeObj.devname!=undefined){
    //        typeList.push(typeObj);
    //    }
    //
    //
    //}
    var length=typeList.length;
    var index=1;
    while(length<itemAmount){
        var typeObj={};
        typeObj.devinvestor=$("#devinvestor"+index).find("option:selected").attr('value');//设备品牌
        typeObj.devbrand=$("#devbrand"+index).find("option:selected").attr('value');//设备名称
        typeObj.devname=$("#devname"+index).find("option:selected").attr('value');//设备厂家

        //避免删除后有些数据保存不了
        if(typeObj.devinvestor!=undefined&&typeObj.devbrand!=undefined
            &&typeObj.devname!=undefined){
            typeList.push(typeObj);
        }
        length=typeList.length;
        index++;

    }


    return JSON.stringify(typeList);
}




