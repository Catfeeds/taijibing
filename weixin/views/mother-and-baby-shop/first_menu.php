<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>太极兵订水门店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="/static/css/mui.min.css">
</head>
<style type="text/css">
.bg_color{
  background: #fff;border:none;
     webkit-box-shadow:none; 
     box-shadow: none; 

}


.mui-title span{
    background: url(/static/images2/shop_name.png) no-repeat;
    background-position: 0px 10px;
    background-size: 25px;
    height: 100%;
    display: inline-block;
    padding: 0 30px;
    margin-left: 30px;
    font-size: 18px;
    color: #000;
}
#nav img{width: 100%}
.mui-bar-tab .mui-tab-item.mui-active {
  color: #CA5725;
}
.title_text{
  width:100%;
  color:#000;
  background-color:#f3f3f3;    
  height: 150px;
  margin-top:-150px;
  overflow: hidden;
  transition:margin-top 0.5s;
  -moz-transition:margin-top 0.5s; /* Firefox 4 */
  -webkit-transition:margin-top 0.5s; /* Safari and Chrome */
  -o-transition:margin-top 0.5s; /* Opera */
}
.title_text p{
  color:#000;
}
.mui-slider-indicator .mui-active.mui-indicator {
  background: #fd9b43;
}
.mui-table-view-cell{
  text-align: center;list-style-type: none;padding: 15px;
}
.nav_dao .mui-table-view-cell img{
  width: 50%;
}
.rankings .mui-table-view-cell img{
   width: 100%;
}
.rankings .mui-card-footer p{
 text-align: left;
    font-size: 15px;
    line-height: 5px;
}
.rankings .mui-card-footer .title{
   font-size: 18px;color:#000;
}
.rankings .mui-card-footer .footer{
      padding: 10px 0;  
}
.rankings .mui-card-footer p span{
  padding: 5px 0;
    box-sizing: border-box;
    color: red;position: relative;
}
.rankings .mui-card-footer p span img{
  position: absolute;
    bottom: 0;
    right: 0;
    width: 40px;
}
.mui-card-footer:before, .mui-card-header:after{
  background: none
}
.selected .mui-row>div{
   border-top:1px solid #f3f3f3;
   border-bottom:1px solid #f3f3f3;
}
.selected .mui-card-footer:before, .selected  .mui-card-heade {
 background: #f3f3f3;
}
.mui-bar-footer~.mui-content {
    padding-bottom: 100px;
}
</style>
<body class="bg_color">
  <header class="mui-bar mui-bar-nav bg_color">
    <!-- <a class="mui-action-bac mui-pull-left"></a> -->
    <h1 class="mui-title">    <p><span>协信服务店</span></p></h1>
  <a href="/index.php/mother-and-baby-shop/list"> 
    <img  class="mui-action-bac mui-pull-right"  style="margin-top:10px" src="/static/images/a_href.png" alt="图片丢失了">
  </a>
</header>
<footer class="mui-bar mui-bar-footer">
   <nav class="mui-bar mui-bar-tab " id="nav">
      <a  class="mui-tab-item mui-active" id="a1">
        <span class="mui-icon"><img src="/static/images2/home_img.png" alt="图片丢失了"></span>
        <span class="mui-tab-label">首页</span>
      </a>
      <a href="/index.php/mother-and-baby-shop/list2" class="mui-tab-item " id="a2">
        <span class="mui-icon"><img src="/static/images2/Group.png" alt="图片丢失了"></span>
        <span class="mui-tab-label">分类</span>
      </a>
      <a class="mui-tab-item " id="a3">
        <span class="mui-icon"><img src="/static/images2/gouwu.png" alt="图片丢失了"></span>
        <span class="mui-tab-label">购物车</span>
      </a>
      <a class="mui-tab-item " id="a4">
        <span class="mui-icon"><img src="/static/images2/in.png" alt="图片丢失了"></span>
        <span class="mui-tab-label">我的</span>
      </a>
    </nav>
</footer>
<div class="mui-content bg_color">
  <div class="title_text">
     <div class="mui-card-media" style="height: 100%;padding:15px;">

        <div class="mui-pull-left" style="width:30%;    text-align: center; margin-top: 35px;">
          <img src="/static/images2/home_img.png" />
        </div>
        
        <div class="mui-pull-right" style="width:70%;">
          <!-- 小M -->
          <p style="font-weight: bold">协信中心服务店</p>
          <p>地址：<span>成华区府青路29号</span></p>
          <p>营业时间：<span style="color: red"><span>8:00pm</span>-<span>22:00pm</span></span></p>
          <p>简介：<span>太极兵天然好水</span></p>
        </div>
      </div>
       <p style="clear:both;"></p>
  </div>
  <div class="content_init">
    <!-- 轮播图 -->
        <div class="mui-slider">
            <div class="mui-slider-group mui-slider-loop">
              <!--支持循环，需要重复图片节点-->
              <div class="mui-slider-item mui-slider-item-duplicate"><a href="#"><img src="/static/images/banner2.png" /></a></div>
              <div class="mui-slider-item"><a href="#"><img src="/static/images/1.png" /></a></div>
              <div class="mui-slider-item"><a href="#"><img src="/static/images/banner2.png" /></a></div>
              <!--支持循环，需要重复图片节点-->
              <div class="mui-slider-item mui-slider-item-duplicate"><a href="#"><img src="/static/images/1.png" /></a></div>
            </div>

            <div class="mui-slider-indicator">
                <div class="mui-indicator mui-active"></div>
                <div class="mui-indicator"></div>
            </div>
          </div>
<!-- 栅格导航 -->
        <div class="mui-row nav_dao">
            <div class="mui-col-sm-3 mui-col-xs-3">
                <li class="mui-table-view-cell">
                    <a class="">
                        <img src="/static/images/nav_1.png" alt="">
                        <p>母婴用品</p>  
                    </a>
                </li>
            </div>
            <div class="mui-col-sm-3 mui-col-xs-3">
                <li class="mui-table-view-cell">
                    <a class="">
                        <img src="/static/images/nav_2.png" alt="">
                        <p>品牌奶粉</p>  
                    </a>
                </li>
            </div>
            <div class="mui-col-sm-3 mui-col-xs-3">
                <li class="mui-table-view-cell">
                    <a class="">
                        <img src="/static/images/nav_3.png" alt="">
                        <p>婴儿用品</p>  
                    </a>
                </li>
            </div>
            <div class="mui-col-sm-3 mui-col-xs-3">
                <li class="mui-table-view-cell">
                    <a class="">
                        <img src="/static/images/nav_4.png" alt="">
                        <p>孕妇用品</p>  
                    </a>
                </li>
            </div>
            <div class="mui-col-sm-3 mui-col-xs-3">
                <li class="mui-table-view-cell">
                    <a class="">
                        <img src="/static/images/nav_5.png" alt="">
                        <p>智能家居</p>  
                    </a>
                </li>
            </div>
            <div class="mui-col-sm-3 mui-col-xs-3">
                <li class="mui-table-view-cell">
                    <a class="">
                        <img src="/static/images/nav_6.png" alt="">
                        <p>更多</p>  
                    </a>
                </li>
            </div>

        </div>

        <!-- 热门排行 -->

        <div class="rankings">

           <h4 style="margin-left: 15px;margin-bottom: 20px;">热销排行
                <img src="/static/images/rankings_bg1.png" width='25px'>
           </h4> 
              <div class="mui-row">
                  <div class="mui-col-sm-6 mui-col-xs-12">
                      <li class="mui-table-view-cell">
                           <a >
                              <div class="mui-card" style="box-shadow: none">
                            <!--页眉，放置标题-->
                            <!-- <div class="mui-card-header">页眉</div> -->
                            <!--内容区-->
                            <div class="mui-card-content">
                              <img src="/static/images/goods_1.png" alt="">
                            </div>
                            <!--页脚，放置补充信息或支持的操作-->
                            <div class="mui-card-footer" style="display: block;">
                                  <p class="title">太极兵母婴水</p><br/>
                                  <p class="content">这是全世界最好的水</p><br/>
                                  <p class="footer">
                                    <span class="mui-pull-left" style="    margin-top: -5px;">￥10</span>
                                    <span class="mui-pull-right">
                                        <img src="/static/images/goouwu.png" alt="">
                                    </span>
                                  </p>
                            </div>
                          </div>
                          </a>
                      </li>
                  </div>   
              </div>
        
        </div>
        <div class="rankings selected">

           <h4 style="margin-left: 15px;margin-bottom: 20px;">热购精选
                <img src="/static/images/rankings_bg1.png" width='25px'>
           </h4> 
              <div class="mui-row" >
                  <div class="mui-col-sm-6 mui-col-xs-12">
                      <li class="mui-table-view-cell">
                           <a >
                              <div class="mui-card" style="box-shadow: none">
                            <!--页眉，放置标题-->
                            <!-- <div class="mui-card-header">页眉</div> -->
                            <!--内容区-->
                            <div class="mui-card-content">
                              <img src="/static/images/goods_1.png" alt="">
                            </div>
                            <!--页脚，放置补充信息或支持的操作-->
                            <div class="mui-card-footer" style="display: block;">
                                  <p class="title">太极兵母婴水</p><br/>
                                  <p class="content">这是全世界最好的水</p><br/>
                                  <p class="footer">
                                    <span class="mui-pull-left" style="    margin-top: -5px;">￥10</span>
                                    <span class="mui-pull-right">
                                        <!-- <img src="/static/images/goouwu.png" alt=""> -->
                                    </span>
                                  </p>
                            </div>
                          </div>
                          </a>
                      </li>
                  </div> 
                   <div class="mui-col-sm-6 mui-col-xs-12">
                      <li class="mui-table-view-cell">
                           <a >
                              <div class="mui-card" style="box-shadow: none">
                            <!--页眉，放置标题-->
                            <!-- <div class="mui-card-header">页眉</div> -->
                            <!--内容区-->
                            <div class="mui-card-content">
                              <img src="/static/images/goods_1.png" alt="">
                            </div>
                            <!--页脚，放置补充信息或支持的操作-->
                            <div class="mui-card-footer" style="display: block;">
                                  <p class="title">太极兵母婴水</p><br/>
                                  <p class="content">这是全世界最好的水</p><br/>
                                  <p class="footer">
                                    <span class="mui-pull-left" style="    margin-top: -5px;">￥10</span>
                                    <span class="mui-pull-right">
                                        <!-- <img src="/static/images/goouwu.png" alt=""> -->
                                    </span>
                                  </p>
                            </div>
                          </div>
                          </a>
                      </li>
                  </div> 
                   <div class="mui-col-sm-6 mui-col-xs-12">
                      <li class="mui-table-view-cell">
                           <a >
                              <div class="mui-card" style="box-shadow: none">
                            <!--页眉，放置标题-->
                            <!-- <div class="mui-card-header">页眉</div> -->
                            <!--内容区-->
                            <div class="mui-card-content">
                              <img src="/static/images/goods_1.png" alt="">
                            </div>
                            <!--页脚，放置补充信息或支持的操作-->
                            <div class="mui-card-footer" style="display: block;">
                                  <p class="title">太极兵母婴水</p><br/>
                                  <p class="content">这是全世界最好的水</p><br/>
                                  <p class="footer">
                                    <span class="mui-pull-left" style="    margin-top: -5px;">￥10</span>
                                    <span class="mui-pull-right">
                                        <!-- <img src="/static/images/goouwu.png" alt=""> -->
                                    </span>
                                  </p>
                            </div>
                          </div>
                          </a>
                      </li>
                  </div> 
                   <div class="mui-col-sm-6 mui-col-xs-12">
                      <li class="mui-table-view-cell">
                           <a >
                              <div class="mui-card" style="box-shadow: none">
                            <!--页眉，放置标题-->
                            <!-- <div class="mui-card-header">页眉</div> -->
                            <!--内容区-->
                            <div class="mui-card-content">
                              <img src="/static/images/goods_1.png" alt="">
                            </div>
                            <!--页脚，放置补充信息或支持的操作-->
                            <div class="mui-card-footer" style="display: block;">
                                  <p class="title">太极兵母婴水</p><br/>
                                  <p class="content">这是全世界最好的水</p><br/>
                                  <p class="footer">
                                    <span class="mui-pull-left" style="    margin-top: -5px;">￥10</span>
                                    <span class="mui-pull-right">
                                        <!-- <img src="/static/images/goouwu.png" alt=""> -->
                                    </span>
                                  </p>
                            </div>
                          </div>
                          </a>
                      </li>
                  </div> 

              </div>
        
        </div>





  </div>


</div>


</body>


<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/mui.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript">
// //获得slider插件对象
var gallery = mui('.mui-slider');
gallery.slider({
  interval:2000//自动轮播周期，若为0则不自动播放，默认为0；
});
$(".content_init").on("swipeup",function(){
     console.log("你正在向上滑动");
     var scrollTopDoc = $(document).scrollTop() ;
 console.log(scrollTopDoc)
   if(scrollTopDoc>=0){
     $(".title_text").css('marginTop','-150px');
     }
});

$(".mui-bar-footer a").on('click',function(){
  var _href = $(this).attr('href')
   window.location.href=_href;
});

$(".content_init").on("swipedown",function(){
     console.log("你正在向下滑动");
     var scrollTopDoc = $(document).scrollTop() ;
     console.log(scrollTopDoc)
      if(scrollTopDoc<=0){
     $(".title_text").css('marginTop','0px');
     }
});
</script>
</html>