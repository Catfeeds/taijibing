<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>太极兵订水门店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
     <link rel="stylesheet" href="http://oowgxt7h1.bkt.clouddn.com/wx/static/coderlu.css"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="/static/css/mui.min.css">
</head>
<style type="text/css">
.bg_color{
  background: #fff;border:none;
     webkit-box-shadow:none; 
     box-shadow: none; 

}

         #content{
            width:100%;
            height:100%;
            overflow: hidden;
            position:absolute;
        }
p{
    padding: 0px !important;
    margin:0;color: #000
}

     .header{
            width:100%;
            height:144px;
            background-image: url(/static/images/background.png);
            background-position:center;
            background-size: 100% 144px;
        }
       
      .header_content{
            height:144px;
            width:
        }
        .header_p_icon{
            height:100px;width:100px;position:absolute;top:22px;
            border-radius: 72px;
            left:10px;
        }
        .container{
            width:100%;
             height: calc(100% - 144px);
            position: relative;
        }
         .agent_address{
            color: #fff;line-height: inherit;font-size:13px;overflow: hidden;
            margin-top:21px;
        }
        .header_right{
            position: absolute;left:130px;top:18px;
        }


        .Catalog{
            border-top:5px solid #f3f3f3;

        }
        .list{
       width: 33.3%;
        float: left;
        padding: 10px;
        text-align: center;
        }
                .container_left{
            position: absolute;
            top:0px;
             left:0px;
                width:90px;
                bottom:0px;
            background: #f3f3f3;
        }
              .tab_list li{
            height:54px;
            position:relative;
            text-align: center;
            line-height:54px;
            border-bottom: 1px solid #e9e9e9;
            font-size:14px;

        }
        .tab_list .selected{
            background:white;
        }
        .tab_list .unselected{
            background:#f8f8f8;
        }
                .container_right{
            position:absolute;
             left: 90px;padding-left: 10px;
            right:0px;
            bottom:0px;
            top:144px;
            padding-right:10px;
            padding-bottom:80px;
            top:0px;
            background:white;
            height: 100%;
        }
     .container_right_content{
            width:100%;
            height:100%;
            background:white;
            overflow: auto;
        }
        .list_container{
            height:80px;
            width:100%;
            position:relative;
        }
        .list_c_right{
            position:absolute;
            left:90px;
        }

                .buy_bnt{
     position: absolute;
    right: 0px;
    width: 50px;
    height: 25px;
    font-size: 13px;
    display: inline-block;
    background: #ff4e00;
    color: white;
    line-height: 25px;
    text-align: center;
    border-radius: 8px;
    top: 25px;
    right: 0px;
        }
    .goods_ul li{
    height:110px;
    border-bottom: 1px solid #e9e9e9;
    padding-top:15px;
    overflow: auto;
    background:white;
    }
    .goods_title{
    font-size:15px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
    }
    .tab_menu_item{
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
    }
    .layui-m-layerbtn span[yes]{
    font-size: 25px;
    }
    .agent_contact{
        font-size: 12px;
        color: #fff
    }

.mui-title span{
    /*background: url(/static/images2/shop_name.png) no-repeat;*/
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
width:100%;color:#000;
background-color:#f3f3f3;    
height: 0px;
overflow: hidden;
transition:height 1s;
-moz-transition:height 1s; /* Firefox 4 */
-webkit-transition:height 1s; /* Safari and Chrome */
-o-transition:height 1s; /* Opera */
}
.title_text p{
  color:#000;
}
ul{
    padding:0;
}
li {
    list-style-type: none;
}
.mui-slider-indicator .mui-active.mui-indicator {

}
.linst_nav{
    position: relative;
}
.linst_nav img{
        position: absolute;
    top: 2px;
}
.linst_nav span{
      /*text-indent: 25px;*/
    margin-left: 25px;
}

.mui-table-view-cell:after {
    content: none;
}

</style>
<body class="bg_color">
  <header class="mui-bar mui-bar-nav bg_color">
    <!-- <a class="mui-action-bac mui-pull-left"></a> -->
    <h1 class="mui-title">    <p><span>母婴用水</span></p></h1>
 
</header>
<footer class="mui-bar mui-bar-footer">
   <nav class="mui-bar mui-bar-tab " id="nav">
      <a  href="/index.php/mother-and-baby-shop/first-menu?agent_id=69" class="mui-tab-item mui-active" id="a1">
        <span class="mui-icon"><img src="/static/images2/home_img.png" alt="图片丢失了"></span>
        <span class="mui-tab-label">首页</span>
      </a>
      <a class="mui-tab-item " id="a2">
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
  </div>
  
     <div class="container">
        <div class="container_left">
            <ul class="tab_list"  id='tab_list'>
                <li class="tab_menu_item selected" type="0">热销&nbsp;<icon class="water_hot"></icon></li>
            </ul>
        </div>
        <div class="container_right">
            <p style="height:40px;line-height:40px;border-bottom:1px solid #e9e9e9;font-size:16px;" type='' id="title">热销</p>
               <div class="container_right_content"  id="refreshContainer" >
                   <ul class="goods_ul">

                   </ul>
                   <div class="empty_goods" style="display:none;">
                       <div style="width:110px;margin:0 auto;margin-top:60px;">
                           <p style="text-align:center;font-size:18px;color:#e8e8e8;margin-bottom:10px;">暂无商品</p>
                           <img src="/static/images/empty_goods.png" style="width:110px;height:auto;"/>
                       </div>
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
//获得slider插件对象
var gallery = mui('.mui-slider');
gallery.slider({
  interval:2000//自动轮播周期，若为0则不自动播放，默认为0；
});
$(".mui-bar-footer a").on('click',function(){
  var _href = $(this).attr('href')
   window.location.href=_href;
});
</script>
</html>