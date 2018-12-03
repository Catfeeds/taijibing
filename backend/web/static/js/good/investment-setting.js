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
        domain:'image1.ebopark.com',
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
                var src="http://image1.ebopark.com/"+res.key;
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
    //console.log(goodType);
    for(var index=0;index<datas.length;index++){
        var items=datas[index];

        if(items.devbrand==''||items.devname==''
            ||items.devfactory==''||items.province==''||items.city==''
            ||items.number==''||items.time==''){
            alert("请添加完整的数据");
            return false;
        }

        if(isNaN(items.number) || items.number<=0 || items.number%1!==0){
            alert("投资数量必须是正整数");
            return false;
        }
    }

    var id=$('#agent_id').val();
    var name=$('#investor').val();

    var data="id="+encodeURIComponent(id);//设备投资商id
    data+="&name="+encodeURIComponent(name);//设备投资商name
    data+="&subgoodtypes="+encodeURIComponent(getSubGoodTypeJson());//商品数据 数组

       // console.log(getSubGoodTypeJson());
    var ii=layer.msg("操作中……");
    var obj ={
         id:id,
         name:name,
         subgoodtypes:getSubGoodTypeJson(),
    }
    $.post("/index.php?r=dev-investor/save-investment",obj,function(data){
        // alert(data.state)
     
        if(data.state!=0){
            layer.alert(data.msg);
            return;
        }
        else{
            //layer.alert('添加成功');
            alert('添加成功');
     window.location.replace("/index.php?r=dev-investor/list");
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
function addGoodType($this){

  
    var itemAmount=$("#good_sub_type_c").find(".item").length;
  console.log(itemAmount)
    
    if(isNaN(itemAmount)){
    return;
    }
        var goodList = this;
        var currentIndex=itemAmount+1;
    var itemStr=' <div class="item" id="item'+currentIndex+'" itemid="100" num="'+currentIndex+'">'+
        '<div class="good_sub_type">'+
        '<select onchange="change1('+currentIndex+')" id="devbrand'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option value="">设备品牌</option></select>'+
        '<select onchange="change2('+currentIndex+')" id="devname'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option value="">设备名称</option></select>'+
        '<select id="devfactory'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option value="">设备厂家</option></select>'+
        '<div style="display: inline-block;line-height: 0;"><label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="fl">投资区域：</label><select onchange="change3('+currentIndex+')" id="province'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option selected="selected" value="">选择省</option></select>'+
        '<select id="city'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:90px;margin-right:15px"><option value="">选择市</option></select></div>'+
      '<div style="display: inline-block;line-height: 0;position: relative;display: inline-block;vertical-align: middle; user-select: none;">'+

        '<label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="fl">投资数量:&nbsp;&nbsp;</label><input id="realPrice'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:50px;"/>'+
        '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class="fl">投资时间:</label><input id="originalPrice'+currentIndex+'" type="text" class="originalPrice baseinput fl" style="width:130px;"/>'+
        '<a href="javascript:void(0);"  class="delGoodType" style="margin-left:5px;float:left;height:25px;line-height: 25px;">删除</a>'+
        '</div></div>'+
        '<div style="clear:both;"></div>'+
         '</div>';
         $("#good_sub_type_c").append($(itemStr));
            this.devbrand=$('#devbrand'+currentIndex);
          this.devname=$('#devname'+currentIndex);
          this.devfactory=$('#devfactory'+currentIndex);
          this.province=$('#province'+currentIndex);
          this.city=$('#city'+currentIndex);

        $('#devbrand'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        $('#devname'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        $('#devfactory'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        $('#city'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        $('#province'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        // $this.devbra=$('#devbrand'+currentIndex);
        // goodList.devbra.chosen({no_results_text: "没有找到"}); //初始化chosen
              //添加商品品牌数据
         $.get('./?r=dev-investor/get-devbrand',function(data){
                var html="";
                $(data).each(function(i,v){
                    if(v){
                       html+="<option value='"+v.BrandNo+"'>"+ v.BrandName+"</option>"
                    }
                 });
                 $(html).appendTo('#devbrand'+currentIndex);
                    $('#devbrand'+currentIndex).trigger("chosen:updated");
                  //console.log(data);
            });
             //添加设备厂家数据
            $.get('./?r=dev-investor/get-devfactory',function(data){
                var html="";
                $(data).each(function(i,v){
                    if(v){
                        html+="<option value='"+v.Id+"'>"+ v.Name+"</option>"
                    }
                });
                $(html).appendTo('#devfactory'+currentIndex);
                $('#devfactory'+currentIndex).trigger("chosen:updated");
                //console.log(data);
            });



                jeDate({
                    dateCell:"#originalPrice"+currentIndex,
                    isinitVal:true,
                   // isTime: true
                });
                               //地址数据-------------------------------
                if(address!=''){
                //填充省市的数据
                    var html='<option value="全国">全国</option>';
                    $(address).each(function(){
                    html += '<option value="'+this.name+'">'+this.name+'</option>';
                });
                $(html).appendTo('#province'+currentIndex);
               $('#province'+currentIndex).trigger("chosen:updated");
                }

     $(".delGoodType").unbind();
        $(".delGoodType").on("click",function(){
            $(this).parents(".item").eq(0).remove();
        });
}



//商品品牌改变时，获取对应的商品
function change1(no){
    var devbrand_id=$('#devbrand'+no+' option:selected').attr('value');

    //if(category_id) {
        if (devbrand_id) {
            //添加对应品牌的设备商品数据
            $.get('./?r=dev-investor/get-dev', {'devbrand_id': devbrand_id}, function (data) {
                //console.log(data);
                if (data != '') {
                    var html = "<option value=''>设备名称</option>";
                    $(data).each(function (i, v) {
                        if (v) {
                            html += "<option value='" + v.name + "'>" + v.name + "</option>"
                        }

                    });
                    // console.log(html);
                    $('#devname' + no).html('');
                    $(html).appendTo('#devname' + no);
                  $('#devname' + no).trigger("chosen:updated");



                } else {
                    var html = "<option value=''>设备名称</option>";
                    $('#devname' + no).html('');
                    $(html).appendTo('#devname' + no);
                    $('#devname' + no).trigger("chosen:updated");
                    //清空后面的下拉框数据
                    //$('#goodsname'+no).html("<option value=''>选择商品</option>");
                    //$('#goodsfactory'+no).html("<option value=''>选择厂家</option>");
                }

            });
        } else {
            var html = "<option value=''>设备名称</option>";
            $('#devname' + no).html('');
            $(html).appendTo('#devname' + no);
            $('#devname' + no).trigger("chosen:updated"); 
            //清空后面的下拉框数据
            //$('#goodsname'+no).html("<option value=''>选择商品</option>");
            //$('#goodsfactory' + no).html("<option value=''>选择厂家</option>");
        }
    //}
}


//商品品牌改变时，获取对应商品名称
function change2(no){
    //var goodsname=$('#goodsname'+no+' option:selected').attr('value');
    var category_id=$('#goodscategory'+no+' option:selected').attr('value');
    var brand_id=$('#goodsbrand'+no+' option:selected').attr('value');

    if(brand_id){
           //添加商品名称数据
        $.get('./?r=goods/get-goods',{'category_id':category_id,'brand_id':brand_id},function(data){
            if(data!=''){
                var html="<option value=''>选择商品</option>";
                $(data).each(function(i,v){
                    if(v){
                        html+="<option value='"+v.name+"'>"+ v.name+"</option>"
                    }

                });
                $('#goodsname'+no).html('');
                $(html).appendTo('#goodsname'+no);
                $('#goodsname' + no).trigger("chosen:updated"); 
                //清空后面的下拉框数据
                //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
                $('#goodsfactory'+no).html("<option value=''>选择厂家</option>");
                $('#goodsfactory' + no).trigger("chosen:updated");

            }else{
                var html="<option value=''>选择商品</option>";
                $('#goodsname'+no).html('');
                $(html).appendTo('#goodsname'+no);
                 $('#goodsname' + no).trigger("chosen:updated"); 
                //清空后面的下拉框数据
                //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
                $('#goodsfactory'+no).html("<option value=''>选择厂家</option>");
                 $('#goodsfactory' + no).trigger("chosen:updated");
            }

        });
    }else{
        var html="<option value=''>选择商品</option>";
        $('#goodsname'+no).html('');
        $(html).appendTo('#goodsname'+no);
        $('#goodsname' + no).trigger("chosen:updated"); 
        //清空后面的下拉框数据
        //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
        $('#goodsfactory'+no).html("<option value=''>选择厂家</option>");
        $('#goodsfactory' + no).trigger("chosen:updated"); 
    }

}

//（选中）省，读取该省对应的市，更新到市下拉框
function change3(no){

        var province = $("#province"+no+' option:selected').attr('value');//获取当前选中的省

        if(province != ''){

            if(province == '全国'){

                $("#city"+no).html('<option value="全部">全部</option>');
                  $('#city' + no).trigger("chosen:updated");

            }else{
                //获取当前省对应的市 数据
                $(address).each(function(){
                    if(this.name == province){
                        var option = '<option value="全部">全部</option>';
                        $(this.city).each(function(){
                            option += '<option value="'+this.name+'">'+this.name+'</option>';
                        });
                        $("#city"+no).html(option);
                         $('#city' + no).trigger("chosen:updated");
                    }
                });
            }


        }else{
            $("#city"+no).html('<option value="">选择市</option>');
            $('#city' + no).trigger("chosen:updated");
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

    var length=typeList.length;
    var index=1;
    while(length<itemAmount){
        //console.log(length);
        //console.log(itemAmount);
        var typeObj={};
        typeObj.devbrand=$("#devbrand"+index).find("option:selected").attr('value');//设备品牌
        typeObj.devname=$("#devname"+index).find("option:selected").attr('value');//设备名称
        typeObj.devfactory=$("#devfactory"+index).find("option:selected").attr('value');//设备厂家
        typeObj.province=$("#province"+index).find("option:selected").attr('value');//省
        typeObj.city=$("#city"+index).find("option:selected").attr('value');//市
        typeObj.number=$("#realPrice"+index).val();//投资设备台数
        typeObj.time=$("#originalPrice"+index).val();//时间

        //避免删除后有些数据保存不了
        if(typeObj.devbrand!=undefined&&typeObj.devname!=undefined
            &&typeObj.devfactory!=undefined&&typeObj.province!=undefined
            &&typeObj.city!=undefined&&typeObj.number!=undefined
            &&typeObj.time!=undefined){
            typeList.push(typeObj);
        }
        length=typeList.length;
        index++;

    }

    return JSON.stringify(typeList);
}




