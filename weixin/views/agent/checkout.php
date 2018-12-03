<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8" />
	<title>测试页面</title>

</head>
<style>
	body {
	    margin: 20px 20%;
	    color:#777;
	    text-align: center;
	}
	#result{
		margin-top: 20px;
	}
	</style>
<body>
<!-- <input type='file' name="uploadImage"  value='图片上传'  accept="image/*"  capture='”camera”'  /> -->



  <a class="weui_btn weui_btn_primary" href="javascript:;" onclick="take_a_photo()">调用微信相机</a>


  <p id='text'> </p>

  <!-- <img src="weixin://resourceid/94e77ea94d43939d2ae228554e2ecd39" alt=""  > -->
  <img src="" alt=""  id='images'>



</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
var datast = <?=json_encode($data)?>;
console.log(datast)
wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: datast.appId,   // 必填，公众号的唯一标识
        timestamp: datast.timestamp, // 必填，生成签名的时间戳
        nonceStr: datast.nonceStr, // 必填，生成签名的随机串
        signature: datast.signature,// 必填，签名，见附录1
        jsApiList: ["chooseImage", "previewImage", "uploadImage", "downloadImage"] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        // 基本思路是，上传图片到微信服务器->下载多媒体接口讲图片下载到服务器->返回服务器存储路径->前台显示
    });
        



// 图片接口
// 拍照、本地选图
var images = {
    localId: [],
    serverId: []
}; 
 
// 拍照或者选择照片
function take_a_photo(){
    wx.chooseImage({
        count: 1, // 默认9，这里每次只处理一张照片
        sizeType: ['original', 'compressed'],   // 可以指定是原图还是压缩图，默认二者都有
        sourceType: [ 'camera'],        // 可以指定来源是相册还是相机，默认二者都有
        success: function (res) {
            images.localId = res.localIds;      // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            $("#images").attr('src',images.localId )
              // alert(images.localId );
                 var localIds = res.localIds; 
             // 上传照片
                      wx.uploadImage({
                          localId: '' + localIds,
                          isShowProgressTips: 1,
                          success: function(res) {
                              serverId = res.serverId;
                              // $(obj).next().val(serverId); // 把上传成功后获取的值附上
                           $.ajax
                           ({cache: false,
                               async: false,
                               type: 'get',
                               data:{'serverId':serverId },
                               url: "save-picture",
                               success: function (data) {
                                    alert(data)
                                    $("#text").text(data)
                        
                               }
                           });
                          }
                      }); 
        } 
    });
}




</script>
</html>
