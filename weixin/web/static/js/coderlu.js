/**
 * Created by Administrator on 2016/1/25.
 *
 * 1、alert
 */
var dialog_toast_maxTime;
function hideTips() {

    dialog_toast_maxTime -= 500;
    if (dialog_toast_maxTime < 0) {
        $("body").find(".tips_text").remove();
    } else {
        setTimeout(hideTips(), 500);
    }
}
$.alert = function (title, callback,label) {
    if(label==undefined){
        label='确定';
    }
    var tplObj = $('<div class="dialog_container">' +
        '<div class="tips_dialog_content">' +
        '<p class="tips_dialog_title">' + title +
        '</p>' +
        '<div class="tips_dialog_btn">' +
    label +
        ' </div>' +
        ' </div>' +
        '</div>');
    $(tplObj).find('.tips_dialog_btn').on('click', function () {
        $("body").find(".dialog_container").remove();
        callback();
    });
    $("body").append(tplObj);
}
$.tipsAlert = function (title, callback,height) {
    var tplObj = $('<div class="dialog_container">' +
    '<div class="tips_dialog_content" style="height:'+(height==undefined?130:height)+'px;">' +
    '<p class="tips_dialog_title">' + title +
    '</p>' +
    '<div class="tips_dialog_btn" style="color:#189fe9;">' +
    '知道了' +
    ' </div>' +
    ' </div>' +
    '</div>');
    $(tplObj).find('.tips_dialog_btn').on('click', function () {
        $("body").find(".dialog_container").remove();
        callback();
    });
    $("body").append(tplObj);
}

$.tipsAlertOne = function (title, callback,obj) {

$("body").find(".dialog_container").remove();
    var tplObj = $('<div class="dialog_container">' +
    '<div class="tips_dialog_content"  style="'+obj.style+'" >'+
    '<div style="margin-top:-10px">' + title +

    '</div>' +
    '<div class="tips_dialog_btn" style="color:#189fe9;">' +
    '知道了' +
    ' </div>' +
    ' </div>' +
    '</div>');
    $(tplObj).find('.tips_dialog_btn').on('click', function () {
        $("body").find(".dialog_container").remove();
        callback();
    });
    $("body").append(tplObj);
}

$.tipsAlertTwo = function (title, callback,height,callback2) {
    $("body").find(".dialog_container").remove();
    var tplObj = $('<div class="dialog_container">' +
    '<div class="tips_dialog_content" style="height:'+(height==undefined?130:height)+'px;top:0;width:100%;left:0;margin:0;border-radius:0;overflow:auto">' +
    '<div class="tips_dialog_title" style="display:inherit;width:100%">' + title +
    '</div>' +
    '<div class="tips_dialog_btn" style="color:#189fe9;">' +
    '知道了' +
    ' </div>' +
    ' </div>' +
    '</div>');


    $(tplObj).find('.tips_dialog_btn').on('click', function () {
        $("body").find(".dialog_container").remove();
        callback();
    });


    

   
    $("body").append(tplObj);
}
$.confirm = function (title, callback,label,removeBack) {
    if(label==undefined){
        label='确定';
    }
    var tplObj = $('<div class="dialog_container" ng-controller="ctr_dialog_confirm" ng-show="showConfirmDialog">' +
        '<div class="confirm_dialog_content">' +
        '<p class="confirm_dialog_title">' + title +
        '</p>' +
        ' <div class="confirm_dialog_btn_c">' +
        '<div style="float:left;width:50%;" class="confirm_dialog_btn_cancle" >取消 </div>' +
        '<div style="float:left;width:50%;" class="confirm_dialog_btn_sure">'+label+'</div>' +
        '<div style="width:1px;height:40px;background:#f3f3f3;left:50%;position: absolute;margin-top:5px;"></div>' +
        '</div>' +
        '</div>' +
        '</div>');
    $(tplObj).find(".confirm_dialog_btn_cancle").on("click", function () {
        $("body").find(".dialog_container").remove();
        if(removeBack){
            removeBack()  
        }
    });
    $(tplObj).find(".confirm_dialog_btn_sure").on('click', function () {
        $("body").find(".dialog_container").remove();
        callback();
    });
    $("body").append(tplObj);
}
// $.confirmTwo = function (title, callback,label,removeBack,obj) {
$.confirmTwo = function (title, obj,callback,removeBack) {
    $("body").find(".dialog_container").remove();
    
    var tplObj = $('<div class="dialog_container"ng-controller="ctr_dialog_confirm" ng-show="showConfirmDialog">' +
        '<div class="confirm_dialog_content"  style="'+(obj.style?obj.style:'')+'" >' +
        '<div class="confirm_dialog_title">' + title +
        '<p style="clear:both;"></p></div>' +
        ' <div class="confirm_dialog_btn_c" style="height:115px;line-height: 40px;border:none;    line-height: 36px;">' +
       '<div style="float:left;width:60%;height: 36px;float: inherit;margin: auto;border-radius: 50px;color: #fff;background-color: #FA6B38;  border: 1px solid #f3f3f3;" class="confirm_dialog_btn_sure">'+obj.label+'</div>' +
        // '<div style="width:1px;height:40px;background:#f3f3f3;left:50%;position: absolute;margin-top:5px;"></div>' +
          '<div style="float:left;width:60%;height: 36px;float: inherit;margin: auto;border-radius: 50px;border: 1px solid #f3f3f3; margin-top: 20px;" class="confirm_dialog_btn_cancle" >取消 </div>' +
       
        '</div>' +
        '</div>' +
        '</div>');
    $(tplObj).find(".confirm_dialog_btn_cancle").on("click", function () {
        $("body").find(".dialog_container").remove();
        // if(removeBack){
            removeBack()  
        // }
    });
    $(tplObj).find(".confirm_dialog_btn_sure").on('click', function () {
          $("body").find(".dialog_container").remove();
          callback();
    });
    $("body").append(tplObj);




}
$.toast = function (content, time) {
    $("body").find(".tips_text").remove();
    if (!content) {
        return;
    }
    var length = content.length * 14 + 20;
    var tplObj = $('<div class="tips_text" style="z-index:999;width:' + length + 'px;margin-left:-' + Math.round(length / 2) + 'px">' + content + '</div>');
    $("body").append(tplObj);
    if (isNaN(time)) {
        dialog_toast_maxTime = 3000;
    } else {
        dialog_toast_maxTime = time;
    }
    setTimeout("hideTips();", dialog_toast_maxTime);
}
$.showIndicator = function () {
    if ($('.preloader-indicator-modal')[0]) return;
    $("body").append('<div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div>');
};
$.hideIndicator = function () {
    $('.preloader-indicator-overlay, .preloader-indicator-modal').remove();
};
$.showPreloader = function (title) {
    if ($(".modal-overlay")[0]) {
      return;
    }
    var titleStr = title ? title : "加载中...";
    $("body").append(' <div class="modal-overlay modal-overlay-visible">' +
        ' <div class="modal  modal-no-buttons modal-in" style="display: block; margin-top: -78px;">' +
        '<div class="modal-inner">' +
        '<div class="modal-title">' + titleStr + '</div>' +
        '<div class="modal-text">' +
        '<div class="preloader"></div></div></div' +
        '<div class="modal-buttons "></div></div>' +
        '</div>');
}
$.hidePreloader = function () {
    $(".modal-overlay").remove();
};
$.showActionSheet=function(arr,callback){
        if( !isArray(arr)||arr.length==0){
           return;
        }
    var tplObjStr='<div class="dialog_container">' +
        '<div class="list_dialog_content">' +
        '<ul>';
        if(arr.length==1){
            tplObjStr+='<li class="list_dialog_firstli list_dialog_bottomli" index="0">'+arr[0]+'</li>';
        }else{
            for(var i=0;i<arr.length;i++){
                if(i==0){
                    tplObjStr+='<li class="list_dialog_firstli" index="'+i+'">'+arr[i]+'</li>';
                }else if(i==arr.length-1){
                    tplObjStr+='<li class="list_dialog_bottomli" index="'+i+'">'+arr[i]+'</li>';
                }else{
                    tplObjStr+='<li index="'+i+'">'+arr[i]+'</li>';
                }
            }
        }
    tplObjStr+= '</ul>' +
        '<p class="list_dialog_cancle">取消</p>' +
        '</div>' +
        '</div>';
    var telObj=$(tplObjStr);
    $(telObj).find("li").on('click',function(){
        $(".dialog_container").remove();
        var index=$(this).attr("index");
        callback(index);
    });
    $(telObj).find(".list_dialog_cancle").on("click",function(){
        $(".dialog_container").remove();
    });
   $("body").append(telObj);
};