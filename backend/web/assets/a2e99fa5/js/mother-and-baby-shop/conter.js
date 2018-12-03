

//添加商品型号
function  addGoodType(){
   var itemAmount=$("#good_sub_type_c").find(".item").length;
    // alert(itemAmount);
    if(isNaN(itemAmount)){
        return;
   }
    var currentIndex=itemAmount+1;
    var itemStr=' <div class="item" style="    position: relative;" id="item'+currentIndex+'" itemid="100">'+
           '<p class="exchang">上移<img src="/static/images3/arrowA.png" alt=""></p>'+
        '<div class="good_sub_type" style="margin-left:50px;">'+
        '<select onchange="change1('+currentIndex+')" name = "category1_id" id="category1_id'+currentIndex+'" type="text" class="realPrice baseinput " style="width:100px;margin-right:15px"><option value="">商品属性</option></select>'+
        '<select onchange="change5('+currentIndex+')" name = "category2_id" id="category2_id'+currentIndex+'" type="text" class="realPrice baseinput " style="width:100px;margin-right:15px"><option value="">商品二级分类</option></select>'+

        '<select onchange="change2('+currentIndex+')" id="goodsbrand'+currentIndex+'" type="text" class="realPrice baseinput " style="width:100px;margin-right:15px"><option value="">商品品牌</option></select>'+
        '<select onchange="change3('+currentIndex+')" id="goodsname'+currentIndex+'" type="text" class="realPrice baseinput " style="width:100px;margin-right:15px"><option value="">商品名称</option></select>'+
        '<select  id="goodsvolume'+currentIndex+'" type="text" class="realPrice baseinput " style="width:100px;margin-right:15px"><option value="">商品容量</option></select>'+
        '<label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="">商品结算价</label><input id="realPrice'+currentIndex+'" type="text" class="realPrice baseinput " style="width:50px;"/>'+
        '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品原价</label><input id="originalPrice'+currentIndex+'" type="text" class="originalPrice baseinput " style="width:50px;"/>'+
        '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品库存</label><input id="goodsstock'+currentIndex+'" type="text" class="originalPrice baseinput " style="width:50px;"/>'+

        // '<label for="sort'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;排序</label><input id="sort'+currentIndex+'" type="text" name="sort" class="originalPrice baseinput " style="width:50px;"/>'+
        '<a href="javascript:void(0);"  class="delGoodType" style="margin-left:5px;height:25px;line-height: 25px;">&nbsp;&nbsp;&nbsp;删除</a>'+
        '</div>'+
        '<div style="clear:both;"></div>'+
        '</div>';
       $("#good_sub_type_c").append($(itemStr));

	    $('#category1_id'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
	    $('#category2_id'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
	    $('#goodsbrand'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
	    $('#goodsname'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
	    $('#goodsvolume'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    //添加商品分类数据
        var html="";
        $(type1).each(function(i,v){
            if(v){
                html+="<option value='"+v.Id+"'>"+ v.Name+"</option>"
             }
        });
        $(html).appendTo('#category1_id'+currentIndex);
	      $('#category1_id'+currentIndex).trigger("chosen:updated");
	      $(".delGoodType").on("click",function(){
	        $(this).parents(".item").eq(0).remove();
	    });
}


//商品分类改变时，获取对应的商品品牌
function change1(no){
    var category_id=$('#category1_id'+no+' option:selected').attr('value');
      // console.log(category_id)
    if(category_id) {
 // console.log(type2)
        var html = "<option value=''>选择二级分类</option>";
        $(type2).each(function(i,v){
            if(v){
            	if(category_id==v.ParentId){
            		  html+="<option value='"+v.Id+"'>"+ v.Name+"</option>"
            	}
             }
        });
        $('#category2_id' + no).html('');
        $(html).appendTo('#category2_id' + no);
        $('#category2_id' + no).trigger("chosen:updated");
        } else {
       $('#category2_id' + no).html('<option value>选择二级分类</option>').trigger("chosen:updated")
       $('#goodsbrand' + no).html('<option value>商品品牌</option>').trigger("chosen:updated");
       $('#goodsname' + no).html('<option value>商品名称</option>').trigger("chosen:updated");
       $('#goodsvolume' + no).html('<option value>商品容量</option>').trigger("chosen:updated");
    }
}
//商品品牌改变时，获取对应商品名称
function change5(no){
   var category_id=$('#category1_id'+no+' option:selected').attr('value');
    var category2_id=$('#category2_id'+no+' option:selected').attr('value');
if (category2_id) {
// console.log(category2_id)
    var objCategory = {
        'category2_id': category2_id,
        'category1_id': category_id
    };
    var ii=layer.msg('加载品牌...', {time: 0 });
     $.get('./?r=mother-and-baby-shop/get-brands',objCategory , function (data) {
            	var data = stringArr(data)
            	layer.close(ii)
            		// console.log(data)
            		if(data.state==-1){
            			layer.msg(data.msg);
            			return;
            		}
                 if (data.datas.length) {
                     var html = "<option value=''>选择品牌</option>";
                       $(data.datas).each(function (i, v) {
                       	     
                          if (v) {
                          	var v =nullUndefined(v) ;
                              html += "<option value='" + v.BrandNo + "'>" + v.BrandName + "</option>"
                            }
                       })
                         $('#goodsbrand' + no).html('');
                         $(html).appendTo('#goodsbrand' + no).trigger("chosen:updated");
                         $('#goodsname'+no).html("<option value=''>选择商品</option>").trigger("chosen:updated");;
                         $('#goodsvolume' + no).html("<option value=''>选择容量</option>").trigger("chosen:updated");;
                 }            
            })
      }else{
       $('#goodsbrand' + no).html('<option value>商品品牌</option>').trigger("chosen:updated");
       $('#goodsname' + no).html('<option value>商品名称</option>').trigger("chosen:updated");
       $('#goodsvolume' + no).html('<option value>商品容量</option>').trigger("chosen:updated");
		}
} 
//商品品牌改变时，获取对应商品名称
function change2(no){
    //var goodsname=$('#goodsname'+no+' option:selected').attr('value');
    var category_id=$('#category1_id'+no+' option:selected').attr('value');
    var category2_id=$('#category2_id'+no+' option:selected').attr('value');
    var brand_id=$('#goodsbrand'+no+' option:selected').attr('value');
           //添加商品名称数据
    if(brand_id){
    var objCategory = {
        'category2_id': category2_id,
        'category1_id': category_id,
        'brand_id':brand_id
    };
    // console.log(objCategory)
    var ii=layer.msg('加载名称...', {time: 0 });
    $.get('./?r=mother-and-baby-shop/get-goods',objCategory,function(data){
    	layer.close(ii)
		    var data = stringArr(data)
			// console.log(data)
			if(data.state==-1){
				layer.msg(data.msg);
				return;
			}
			if (data.datas.length) {
                     var html = "<option value=''>选择品牌</option>";
                       $(data.datas).each(function (i, v) {
                          if (v) {
                          	var v =nullUndefined(v) ;
                              html += "<option value='" + v.id + "'>" + v.name + "</option>"
                            }
                       })
             $('#goodsname' + no).html('');
             $(html).appendTo('#goodsname' + no).trigger("chosen:updated");
             $('#goodsvolume' + no).html("<option value=''>选择容量</option>").trigger("chosen:updated");;
              }
        });
    }else{
    	$('#goodsname' + no).html('<option value>商品名称</option>').trigger("chosen:updated");
        $('#goodsvolume' + no).html('<option value>商品容量</option>').trigger("chosen:updated");
    }
}
//商品名称改变时，获取对应商品的容量
function change3(no){
    var goodsnameText=$('#goodsname'+no+' option:selected').text();
    var goodsname=$('#goodsname'+no+' option:selected').attr('value');
    var category_id=$('#category1_id'+no+' option:selected').attr('value');
    var brand_id=$('#goodsbrand'+no+' option:selected').attr('value');
    var category2_id=$('#category2_id'+no+' option:selected').attr('value');

    if(category_id!=1){//茶吧机默认选中其他
        var html="<option value=''>其它</option>";
        $('#goodsvolume'+no).html('');
        $(html).appendTo('#goodsvolume'+no).trigger("chosen:updated");
    }else{
        if(goodsname){
    //         //添加商品名称数据
    //          //添加商品名称数据
            var objCategory = {
            'category2_id': category2_id,
            'category1_id': category_id,
            'brand_id':brand_id,
            'goods_name':goodsnameText
             };
              var ii=layer.msg('加载容量...', {time: 0 });
              
            $.get('./?r=mother-and-baby-shop/get-volume',objCategory,function(data){
          	layer.close(ii)
          	var data = stringArr(data)
      			// console.log(data)
      			if(data.state==-1){
      				layer.msg(data.msg);
      				return;
      			}
				if (data.datas.length) {
	                     var html = "<option value=''>选择容量</option>";
	                       $(data.datas).each(function (i, v) {
	                          if (v) {
	                          	var v =nullUndefined(v) ;
	                              html += "<option value='" + v.volume + "'>" + v.volume + "</option>"
	                            }
	                       })
	              $('#goodsvolume' + no).html('');
	              $(html).appendTo('#goodsvolume' + no).trigger("chosen:updated");
	              }

            });
        }
    }
}

// josn序列化
function stringArr(data){
    var dataNo='';
     if(typeof(data)=='string'){
            dataNo=  jQuery.parseJSON(data);
      }else{
            dataNo = data;
      }
      return dataNo;
}

// 未定义显示为空
function nullUndefined(data){
    // var dataArr= data;
    for(var i in data){
        if(data[i]==null||data[i]==undefined||data[i]==NaN){
          data[i]= ''
       }
    }
     return data; 
}

 initQiniu();
function initQiniu(){
    $.getJSON('/index.php?r=goods/getqiniukey',function(data){
           // console.log(data)
        if(data.state==0){
            var key=data.result;
            initUploader(key,'image1');
            initUploader(key,'image2');
            initUploader(key,'image3');
            initUploader(key,'image4');
            initUploader(key,'image5');
            initUploader(key,'image6');
            initUploader(key,'image7');
        }
    });
}


 function exchangep(a,b){
                    var n = a.next(), p = b.prev();
                     a.insertAfter(b);
                     b.insertBefore(a);
                    
}; 
$(document).on('click','.exchang',function(){
        var nextObj = $(this).parent().prev();
        var  prevObj= $(this).parent();
        exchangep(nextObj,prevObj)
})

function initUploader(key,id){
    var cpts = Qiniu.uploader({
        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
        browse_button: id+'btn',         // 上传选择的点选按钮，**必需**
        uptoken : key, // uptoken 是上传凭证，由其他程序生成
        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
        unique_names: true,              // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
        domain:'7xpcl7.com2.z0.glb.qiniucdn.com',
        // domain:'7xodpu.com1.z0.glb.clouddn.com',//test
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
                // alert(src)
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