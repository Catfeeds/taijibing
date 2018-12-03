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
    query();
   initQiniu();
 //   addGoodType();

});

function initQiniu(){

    $.getJSON('/index.php?r=goods/getqiniukey',function(data){
      //  console.log(data)
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


    var agent1=$("#categoryid").find("option:selected").attr('value');//运营中心
    var agent2=$("#merchantid").find("option:selected").attr('value');//服务中心
    // if(agent2==0){
    //     alert("账户名称不能为空！");
    //     $("#categoryid").focus();
    //     return false;
    // }


//alert(agent2);

    var name=$.trim($("#name").val());



    if(name.length==0){
        alert("商户店铺名称不能为空！");
        $("#name").focus();
        return false;
    }
    var detail= $.trim($("#title").val());
    if(detail.length==0){
        alert("商户简介不能为空！");
        $("#title").focus();
        return false;
    }
    var tel1= $.trim($("#tel1").val());
    var tel2= $.trim($("#tel2").val());
    if(tel1==""&&tel2==''){
        alert("定水电话不能为空");
        $("#tel1").focus();
        return false;
    }


    var goodType=getSubGoodTypeJson();//选择商品的内容
         var datacszc = eval('(' + goodType+ ')')
console.log(datacszc)


    //if((JSON.parse(goodType)).length==1 && goodsname==''){
    //    alert("您还未添加商品型号!");
    //    return false;
    //}

    //console.log((JSON.parse(goodType)).length);
    //return false;
    // if((JSON.parse(goodType)).length==0){
    //     alert("您还未添加商品型号!");
    //     return false;
    // }
    //var originalprice=$("#originalprice").val();
    //var initamount=$("#initamount").val();
    //if($.trim(initamount)==""||isNaN(initamount)){
    //    initamount=0;
    //}
    //var saleprice =$("#saleprice").val();
    //if($.trim(saleprice)==""){
    //    alert("商品售价不能为空");
    //    return false;
    //}
var image1=  $("#image1").attr("src");
    var image2=  $("#image2").attr("src");
    var image3=  $("#image3").attr("src");
    var image4=  $("#image4").attr("src");
    var image5=  $("#image5").attr("src");
    var image6=  $("#image6").attr("src");
    if($.trim(image1)==""){
        alert("第一张商户店铺图片不能为空");
        return false;
    }
    if($.trim(image1)=="" && $.trim(image2)=="" && $.trim(image3)==""
        && $.trim(image4)=="" && $.trim(image5)=="" && $.trim(image6)==""){
        alert("商户店铺图片不能为空");
        return false;
    }

    var starttime= $.trim($("#starttime").val());
    var endtime= $.trim($("#endtime").val());
    if(endtime==""){
        endtime="22:00";
    }

    if(starttime==''){
        starttime='8:00';
    }

    //if(endtime<now){
    //    alert("下架时间必须大于当前时间");
    //    return;
    //}
    //if(starttime!=""&&endtime!=""&&starttime>endtime){
    //    alert("下架时间必须大于上架时间");
    //    return;
    //}


    var opentime= $.trim($("#opentime").val());
    var closetime= $.trim($("#closetime").val());
    if(closetime==""){
        closetime="2099-1-1 00:00:00";
    }
    var now=(new Date()).Format("yyyy-MM-dd hh:mm:ss");
    if(opentime=''){
        opentime=now;
    }

    if(closetime<now){
        alert("关店时间必须大于当前时间");
        return;
    }
    if(opentime!=""&&closetime!=""&&opentime>closetime){
        alert("关店时间必须大于开店时间");
        return;
    }






    var data="name="+ encodeURIComponent(name);//商户店铺名称
    data+="&tel1="+encodeURIComponent(tel1);//订水电话1
    data+="&tel2="+encodeURIComponent(tel2);//订水电话2
    data+="&agent1="+encodeURIComponent(agent1);//运营中心id
    data+="&agent2="+encodeURIComponent(agent2);//服务中心id
    data+="&starttime="+encodeURIComponent(starttime);//上架时间
    data+="&endtime="+encodeURIComponent(endtime);//下架时间
    data+="&opentime="+encodeURIComponent(opentime);//开店时间
    data+="&closetime="+encodeURIComponent(closetime);//关店时间
    data+="&detail="+encodeURIComponent(detail);//简介
    // //data+="&id="+encodeURIComponent(id);//商户id
    // //data+="&expresstype="+$("input[name='f1']").filter(':checked').attr("value");
    // data+="&goods="+encodeURIComponent(JSON.parse(goodType));//商品数据 数组
    // //data+="&originalprice="+encodeURIComponent(originalprice);
    // //data+="&saleprice="+saleprice;
    // //data+="&shophours="+encodeURIComponent($("#shophours").val());
    // //data+="&tel="+tel;
    // //data+="&lat="+encodeURIComponent($("#lat").val());
    // //data+="&lng="+encodeURIComponent($("#lng").val());
    // //data+="&address="+encodeURIComponent($("#address").val());
    // //data+="&tips="+encodeURIComponent($("#tips").val());
    // //data+="&orderdesctemp=";
    // //data+="&memberdiscounttype="+memberdiscounttype;
    // //data+="&memberdiscountval="+memberdiscountval;
    // //data+="&existsdetail="+existDetail();
    data+="&image1="+encodeURIComponent(image1);
    data+="&image2="+encodeURIComponent(image2);
    data+="&image3="+encodeURIComponent(image3);
    data+="&image4="+encodeURIComponent(image4);//图片地址
    data+="&image5="+encodeURIComponent(image5);
    data+="&image6="+encodeURIComponent(image6);
    // //data+="&xj="+encodeURIComponent(xj);
    // //data+="&spxq="+encodeURIComponent($("#spxq").attr("src"));
    // //data+="&cpts="+encodeURIComponent($("#cpts").attr("src"));
    // data+="&subgoodtypes="+encodeURIComponent(getSubGoodTypeJson());//商品数据 数组
    var ii=layer.msg("操作中……");

//console.log(data)


var data={
       name:encodeURIComponent(name),
       tel1:encodeURIComponent(tel1),
       tel2:encodeURIComponent(tel2),
       agent1:encodeURIComponent(agent1),
       agent2:encodeURIComponent(agent2),
       starttime:encodeURIComponent(starttime),
       endtime:encodeURIComponent(endtime),
       opentime:encodeURIComponent(opentime),
       closetime:encodeURIComponent(closetime),
       detail:encodeURIComponent(detail),
      // goods:encodeURIComponent(JSON.parse(goodType)),
       image1:encodeURIComponent(image1),
       image2:encodeURIComponent(image2),
       image3:encodeURIComponent(image3),
       image4:encodeURIComponent(image4),
       image5:encodeURIComponent(image5),
       image6:encodeURIComponent(image6),
       subgoodtypes:encodeURIComponent(getSubGoodTypeJson())
}

//console.log(data)
     $.post("/index.php?r=goods/save-edit",data,function(data){
    

        if(data.state!=0){
            // console.log(data)
           layer.alert();

    layer.msg('    <div style="padding:20px;    font-size: 25px;">'+data.msg+'</div>');






              layer.close(ii);
            return;
        }
        else{
            // layer.alert("修改成功<div id='div1'></div>");
            layer.msg('    <div style="padding:20px;    font-size: 25px;">修改成功<div id="div1"></div></div>');
            // alert("修改成功");

            window.location.replace("/index.php?r=goods/list");
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
     ShowDiv('MyDiv','fade')
     $("#MyDiv>img").attr("src",imgsrc)

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
            console.log( agent)
    for(var i=0; i<category.length;i++) {
        var item = category[i];
        //alert(item["id"])
        //alert(agent.parent)
        if(item["id"]==agent.parent){
            console.log( item["name"])
            $("<option selected='selected' value='" + item["id"] + "'>" + item["name"] + "</option>").appendTo($("#categoryid"));
        }else{
            $("<option value='" + item["id"] + "'>" + item["name"] + "</option>").appendTo($("#categoryid"));
        }

    }
    for(var i=0; i<merchant.length;i++) {
        var item = merchant[i];

        if(item["id"]==agent.agent){
               console.log( item["name"])
            $("<option selected='selected' value='" + item["id"] + "'>" + item["name"] + "</option>").appendTo($("#merchantid"));
        }else{
            $("<option value='" + item["id"] + "'>" + item["name"] + "</option>").appendTo($("#merchantid"));
        }

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
}//添加商品型号
function  addGoodType(){


    var itemAmount=$("#good_sub_type_c").find(".item").length;
  //  alert(itemAmount);
    if(isNaN(itemAmount)){
        return;
    }
    var currentIndex=itemAmount+1;
    var itemStr=' <div class="item"   style="position: relative;"  id="item'+currentIndex+'" itemid="100">'+
        '<p class="exchang">上移<img src="/static/images3/arrowA.png" alt=""></p>'+
        '<div class="good_sub_type"  style="margin-left:50px;">'+
        '<select onchange="change1('+currentIndex+')" id="category1_id'+currentIndex+'" type="text" class="category1_id realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品属性</option></select>'+
       '<select onchange="change5('+currentIndex+')" id="category2_id'+currentIndex+'" type="text" class="category2_id realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品二级分类</option></select>'+
       
       '<select onchange="change2('+currentIndex+')" id="goodsbrand'+currentIndex+'" type="text" class="goodsbrandName realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品品牌</option></select>'+
        '<select onchange="change3('+currentIndex+')" id="goodsname'+currentIndex+'" type="text" class="goodsname realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品名称</option></select>'+
        '<select  id="goodsvolume'+currentIndex+'" type="text" class="goodsvolume realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品容量</option></select>'+
        
        '<label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="">商品结算价</label><input id="realPrice'+currentIndex+'" type="text" class="realPriceRmb realPrice baseinput " style="width:50px;"/>'+
        '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品原价</label><input id="originalPrice'+currentIndex+'" type="text" class="originalPriceRmb originalPrice baseinput " style="width:50px;"/>'+
        '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品库存</label><input id="goodsstock'+currentIndex+'" type="text" class="goodsstock originalPrice baseinput " style="width:50px;"/>'+
        '<label for="sort'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;排序</label><input id="sort'+currentIndex+'" type="text" class="sort baseinput " style="width:50px;"/>'+
       
        '<a href="javascript:void(0);"  class="delGoodType" style="margin-left:5px;height:25px;line-height: 25px;">&nbsp;&nbsp;&nbsp;删除</a>'+
        '</div>'+
        '<div style="clear:both;"></div>'+
        '</div>';


    $("#good_sub_type_c").append($(itemStr));
    //添加商品分类数据
    $('#category1_id'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#category2_id'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#goodsbrand'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#goodsname'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#goodsvolume'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen



    //添加商品分类数据
    $.get('./?r=goods/get-category',function(data){
        var html="";
        $(data).each(function(i,v){
          //  console.log(v)
            if(v){
                html+="<option value='"+v.category_id+"'>"+ v.Name+"</option>"
            }
        });
        $(html).appendTo('#category1_id'+currentIndex);
    $('#category1_id'+currentIndex).trigger("chosen:updated");
    });

    $(".delGoodType").unbind();
    $(".delGoodType").on("click",function(){
        $(this).parents(".item").eq(0).remove();
    });
}








//商品分类改变时，获取对应的商品品牌
function change1(no){
    var category_id=$('#category1_id'+no+' option:selected').attr('value');
    //if(category_id) {
        if (category_id) {
            //添加商品名称数据

  
            $.get('./?r=goods/get-category2', {'category_id': category_id}, function (data) {
              //  console.log(data);
                var data = eval('(' + data+ ')')
                if (data != '') {
                    var html = "<option value=''>选择二级分类</option>";
                    $(data.datas).each(function (i, v) {
                        if (v) {
                              html+="<option value='"+v.Id+"'>"+ v.Name+"</option>"
                        }
                    });
                    //console.log(html);
                    $('#category2_id' + no).html('');
                    $(html).appendTo('#category2_id' + no);
                    //清空后面的下拉框数据
                    $('#goodsbrand'+no).html("<option value=''>选择商品</option>");
                    $('#goodsname'+no).html("<option value=''>选择商品</option>");
                    $('#goodsvolume' + no).html("<option value=''>选择容量</option>");
                     $('#category2_id'+no).trigger("chosen:updated");
                     $('#goodsbrand'+no).trigger("chosen:updated");
                     $('#goodsname'+no).trigger("chosen:updated");
                     $('#goodsvolume'+no).trigger("chosen:updated");


                } else {
                    var html = "<option value=''>选择二级分类</option>";
                    $('#goodsrand' + no).html('');
                    $(html).appendTo('#goodsbrand' + no);
                    $('#goodsbrand'+no).trigger("chosen:updated");
                    //清空后面的下拉框数据
                    $('#goodsname'+no).html("<option value=''>选择商品</option>");
                    $('#goodsvolume' + no).html("<option value=''>选择容量</option>");
                    $('#goodsname'+no).trigger("chosen:updated");
                    $('#goodsvolume'+no).trigger("chosen:updated");
                }

            });
        } else {
            var html = "<option value=''>选择品牌</option>";
            $('#goodsbrand' + no).html('');
            $(html).appendTo('#goodsbrand' + no).trigger("chosen:updated");
            //清空后面的下拉框数据
            $('#goodsname'+no).html("<option value=''>选择商品</option>").trigger("chosen:updated");
            $('#goodsvolume' + no).html("<option value=''>选择容量</option>").trigger("chosen:updated");
        }
    //}
}
function change5(no){

        var category1_id=$('#category1_id'+no+' option:selected').attr('value');
        var category2_id=$('#category2_id'+no+' option:selected').attr('value');

        if(category2_id){
    
       $.get('./?r=goods/get-brand',{'category1_id':category1_id,"category2_id":category2_id},function(data){
             var data = eval('(' + data+ ')');
              // console.log(data)
                if(data!=''){
                     var html="<option value=''>选择商品</option>";
                     $(data.datas).each(function(i,v){
                       
                          if(v){
                           html+="<option value='"+v.BrandNo+"'>"+ v.BrandName+"</option>"
                         }

                     });
                     $('#goodsbrand'+no).html('');
                      $(html).appendTo('#goodsbrand'+no).trigger("chosen:updated");
                }
                 $('#goodsvolume' + no).html("<option value=''>选择容量</option>").trigger("chosen:updated");



               })
        } else {
            var html = "<option value=''>选择品牌</option>";
            $('#goodsbrand' + no).html('');
            $(html).appendTo('#goodsbrand' + no).trigger("chosen:updated");
            //清空后面的下拉框数据
            $('#goodsname'+no).html("<option value=''>选择商品</option>").trigger("chosen:updated");
            $('#goodsvolume' + no).html("<option value=''>选择容量</option>").trigger("chosen:updated");
        }
}

//商品品牌改变时，获取对应商品名称
function change2(no){
    //var goodsname=$('#goodsname'+no+' option:selected').attr('value');
    var category1_id=$('#category1_id'+no+' option:selected').attr('value');
    var category2_id=$('#category2_id'+no+' option:selected').attr('value');


    var goodsbrand=$('#goodsbrand'+no+' option:selected').attr('value');

    if(goodsbrand){
        //添加商品名称数据
 
        $.get('./?r=goods/get-goods',{'category1_id':category1_id,"category2_id":category2_id,'brand_id':goodsbrand},function(data){

            var data = eval('(' + data+ ')');
              console.log(data)


            if(data!=''){
                var html="<option value=''>选择商品</option>";
                $(data.datas).each(function(i,v){
                    if(v){
                        html+="<option value='"+v.name+"'>"+ v.name+"</option>"
                    }

                });
                $('#goodsname'+no).html('');
                $(html).appendTo('#goodsname'+no).trigger("chosen:updated");
                //清空后面的下拉框数据
                //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
                $('#goodsvolum'+no).html("<option value=''>选择容量</option>").trigger("chosen:updated");

            }else{
                var html="<option value=''>选择商品</option>";
                $('#goodsname'+no).html('');
                $(html).appendTo('#goodsname'+no).trigger("chosen:updated");
                //清空后面的下拉框数据
                //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
                $('#goodsvolum'+no).html("<option value=''>选择容量</option>").trigger("chosen:updated");
            }

        });
    }else{
        var html="<option value=''>选择商品</option>";
        $('#goodsname'+no).html('');
        $(html).appendTo('#goodsname'+no).trigger("chosen:updated");
        //清空后面的下拉框数据
        //$('#goodsbrand'+no).html("<option value=''>选择商品品牌</option>");
        $('#goodsvolum'+no).html("<option value=''>选择容量</option>").trigger("chosen:updated");
    }

}

//商品名称改变时，获取对应商品的容量
function change3(no){
    var goodsname=$('#goodsname'+no+' option:selected').attr('value');
    var category_id=$('#category1_id'+no+' option:selected').attr('value');
    var brand_id=$('#goodsbrand'+no+' option:selected').attr('value');
    var category2_id=$('#category2_id'+no+' option:selected').attr('value');
    if(category_id==2){//茶吧机默认选中其他
        var html="<option value=''>其它</option>";
        $('#goodsvolume'+no).html('');
        $(html).appendTo('#goodsvolume'+no).trigger("chosen:updated");
    }else{
        if(goodsname){
            //添加商品名称数据

            var objData = {'goodsname':goodsname,'category1_id':category_id,'brand_id':brand_id,"category2_id":category2_id};
            console.log(objData)
            $.get('./?r=goods/get-volume',objData,function(data){
             
                  var data = eval('(' + data+ ')');
                     // console.log(data);
                if(data!=''){
                    var html="<option value=''>选择容量</option>";
                    $(data.datas).each(function(i,v){
                        if(v){
                            console.log(v)
                            html+="<option value='"+v.volume+"'>"+ v.volume+"</option>"
                        }

                    });
                    // //console.log(html);
                    $('#goodsvolume'+no).html('').trigger("chosen:updated");
                    $(html).appendTo('#goodsvolume'+no).trigger("chosen:updated");
                }else{
                    var html="<option value=''>选择容量</option>";
                    $('#goodsvolume'+no).html('');
                    $(html).appendTo('#goodsvolume'+no).trigger("chosen:updated");
                }

            });
        }else{
            var html="<option value=''>选择容量</option>";
            $('#goodsvolume'+no).html('');
            $(html).appendTo('#goodsvolume'+no).trigger("chosen:updated");
        }
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
    var typeList=[];
    //for(var index=1;index<=objArr.length;index++){
    //    var typeObj={};
    //    //typeObj.typename=encodeURIComponent($("#typename"+index).val());
    //    typeObj.goodscategory=$("#goodscategory"+index).find("option:selected").attr('value');//分类
    //    typeObj.goodsname=$("#goodsname"+index).find("option:selected").attr('value');//名称
    //    typeObj.goodsbrand=$("#goodsbrand"+index).find("option:selected").attr('value');//品牌
    //    //typeObj.goodsfactory=$("#goodsfactory"+index).find("option:selected").attr('value');//厂家
    //    typeObj.realPrice=$("#realPrice"+index).val();//结算价
    //    typeObj.originalPrice=$("#originalPrice"+index).val();//原价
    //    //typeObj.Tatol=$("#Tatol"+index).val();
    //    //typeObj.itemId=$(objArr[index-1]).attr("itemid");
    //
    //    //if(typeObj.typename==""||isNaN(typeObj.realPrice)){
    //    //    continue;
    //    //}
    //    typeList.push(typeObj);
    //}
    var length=typeList.length;
    var index=1;
  //   console.log(objArr)
    while(length<itemAmount){
        var typeObj={};
       if(index>1000){
        return
       }
       console.log($(".goodsstock").eq(index-1).val()||'')



        typeObj.category1_id=$(".category1_id").eq(index-1).find("option:selected").attr('value');//分类
        typeObj.category2_id=$(".category2_id").eq(index-1).find("option:selected").attr('value');//二级分类
        typeObj.goodsbrand=$(".goodsbrandName").eq(index-1).find("option:selected").attr('value');//品牌
         typeObj.goodsname=$(".goodsname").eq(index-1).find("option:selected").attr('value');//名称
         typeObj.goodsvolume=$(".goodsvolume").eq(index-1).find("option:selected").attr('value')||'';//容量



        typeObj.realPrice=$(".realPriceRmb").eq(index-1).val()||'';//结算价
        typeObj.originalPrice=$(".originalPriceRmb").eq(index-1).val()||'';//原价
        typeObj.goodsstock=$(".goodsstock").eq(index-1).val()||'';//库存
        typeObj.sort=$(".sort").eq(index-1).val()||'';//排序
        //避免删除后有些数据保存不了
        if(typeObj.category1_id!=undefined&&typeObj.goodsname!=undefined
            &&typeObj.goodsbrand!=undefined&&typeObj.goodsvolume!=undefined
            &&typeObj.realPrice!=undefined
            &&typeObj.originalPrice!=undefined&&typeObj.goodsstock!=undefined){
            typeList.push(typeObj);
        }
        length=typeList.length;
        index++;

    }



    return JSON.stringify(typeList);
}



