<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backend\models\Menu;
use yii\helpers\Url;
use backend\assets\IndexAsset;

IndexAsset::register($this);
$this->title = yii::t('app', 'Backend Manage System');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
    <link rel=" icon" href="<?=yii::$app->getRequest()->hostInfo?>/favicon.ico" type="image/x-icon" />
    <style>
  *{
    color:#B0B0BA;
  }

  .admin-name{
    width: 40px;
    height: 40px;
    border-radius: 50px;

    text-align: center;
    position: relative;
    padding: 7px;
    box-sizing: border-box;
    background-color: #DD5C1A;
  }
  .admin-name img{
      width:20px;
      height: 29px;\9; /* all ie */
      height: initial;
  }
  .admin-text{
    color:#B0B0BA;
    font-size:15px;
    margin:20px;
    line-height: 20px;
    line-height: 40px;
    }

  .search{
 
    width: 350px;
    height: 35px;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -17px;
    margin-left: -175px;
    border-radius: 20px;
    background-color: #292834;
    display: none;
    }
  .seahgrop{;

    position: relative;
    display: table;
    border-collapse: separate;
    }
    .seahgrop>input,.seahgrop>span{
        background-color: transparent;
        line-height: 30px;
        padding: 0px 15px;
        border:none;
    }
    .seahgrop>input{
       width: 100%;
       zoom:1    outline: medium;
    }
    .shot{
    position: absolute;
    top: 0;
    right: 0px;
    border-radius: 50px;
    color: #fff;
    padding: 3px;
    background-color: #DF5B19;
    }
 
    .gray-bg{background-color: #676a6c}
.nav.navbar-right > li > a {
    color: #999c9e;
    background-color: #363643;
    padding: 10px;
    height: 70px;
    bottom: 0px;
    line-height: 60px;
}
    nav.page-tabs .page-tabs-content a:hover{
        background-color: #1D1F23;
    }
    .navbar-top-links li {
    display: inline-block;
    margin-left: 20px;
    float: left;
    height: 70px;
}

.J_menuItem a:hover,.navbar-top-links .dropdown-menu li a:hover{
    background-color: #1D1F23;
    color:#fff;
}

.roll-right.btn-group{
    right: 80px
}
.roll-right.J_tabRight{
    right:150px;
 }   

.roll-right.J_tabRight:hover{
    background-color: #292834;
}


.nav.navbar-right > li > a:hover, .content-tabs button:hover,.quanping:hover{
background-color: #DF5B19;
}
.dropdown-menu > li > a:hover{
     background-color: #DF5B19;
}
.adminImg{
	width:12px;
	height:12px;
	border-radius:4px;
	background-color:#1D1F23;
    padding: 3px 7px;	
}
.content-tabs {
    border-bottom: solid 2px #363643;
    border-color: #1c1e22;
}
#content-main {
  
     overflow: hidden;
         height:-webkit-calc(100% - 100px); 
     height:-moz-calc(100% - 100px); 
    height: calc(100% - 100px);

}



</style>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden" id='bodyFixed'>
<?php $this->beginBody() ?>
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close">
            <i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse" style="background:#2D2D35;   ">
            <ul class="nav" id="side-menu">
                <li class="nav-header" style="background:#2D2D35;">
                    <div class="dropdown profile-element" style="text-align: content">
                         <div class="admin-name pull-left">
                            <img alt="image"  class="img-circle" width="64" height='50' height="64px" src="/../static/images3/logo (2).png"  />
                        </div>
                        <div class="pull-right">
                            <span class="block m-t-xs"><strong class="font-normal" style="color:rgb(233,233,233);font-size:12px;text-align: center;">太极兵饮水云平台</strong></span>
                            <p style="    letter-spacing: 4.89px;"> TAIJIBING</p>
                        </div>
                       <div style="clear:both;"></div>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                              <!-- <span class="block m-t-xs"><strong class="font-normal" style="color:white;font-size:12px;">太极兵饮水云平台</strong></span> -->
                                   <span class="text-muted text-xs block" style="color:rgb(233,233,233);margin-top:10px;    text-align: center;
                            font-size: 15px;
                            font-weight: bold;"><?= yii::t('menu', yii::$app->rbac->roleName)?>&nbsp;&nbsp;<span class='adminImg'><img src="/../static/images3/guanliyuan (2).png" alt=""></span></span>
                                </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs" style="background-color: #363643">
                            <li><a class="J_menuItem" href="<?=Url::to(['admin-user/update-self'])?>"><?=yii::t('app', 'Profile')?></a>
                            </li>

                            <!-- <li class="divider"></li> -->
                            <li><a href="<?=Url::toRoute('site/logout')?>"><?=yii::t('app', 'Logout')?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">W+
                    </div>
                </li>

                <?php
                    $cacheDependencyObject = yii::createObject([
                        'class' => 'feehi\helpers\FileDependencyHelper',
                        'fileName' => 'backend_menu.txt',
                    ]);
                    $dependency = [
                        'class' => 'yii\caching\FileDependency',
                        'fileName' => $cacheDependencyObject->createFile(),
                    ];
                    if ($this->beginCache('backend_menu', ['variations' => [Yii::$app->language, yii::$app->rbac->getRoleId()], 'dependency' => $dependency])) {
                        ?>
                        <?= Menu::getBackendMenu(); ?>
                        
                        <?php
                        $this->endCache();
                          }
                    ?>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;;background-color: #363643">
                <div class="navbar-header" style="width: 30%;">
                     <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><img src="/../static/images3/sousuo.png" > </a>
                </div>
                <div class="search">
                        <div class="seahgrop">
                            <input type="text" name="" placeholder="搜索">
                            <span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon1"></span>
                        </div>
                </div>
                <ul class="nav navbar-top-links navbar-right" >
                    <!-- <li class="hidden-md hidden-sm ">
                        <a href="javascript:void(0)"><img src="/../static/images3/lingdang.png" ></a>
                         <div class="shot">64</div>
                     </li> -->
                    <li class="hidden-xs">
                        <a  id="reloadIframe" href="javascript:void(0)" onclick="reloadIframe()">
                                <i class="fa fa-refresh" style="color:#B0B0BA"> </i > 
                            <?=yii::t('app', 'Refresh')?>
                        </a>
                    </li>
                    <li class="hidden-xs" style="right:0">
                        <a href="<?=Url::toRoute('site/logout')?>" class="roll-nav roll-right J_tabExit"><?=yii::t('app', 'Logout')?></a>
                    </li>
                </ul>
                  <div class=" quanping" id="FullScreen" datae ='false' style="width:60px; text-align: center;    cursor: pointer;height:40px;padding:0PX;position: absolute;right:10px;z-index: 100;top:55px;bottom: 0; border-radius: 5px; margin-top: 15px;    background: #292834;">
                            <img src="/static/images3/quanping.png"><p>全屏</p>
                   </div>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs" style="background-color: #292834">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="<?=Url::to(['site/main']) ?>"><?=yii::t('app', 'Home')?></a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown"><?=yii::t('app', 'Close')?><span class="caret"></span>
                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right" style=" background: #292834">
                    <li class="J_tabShowActive"><a><?=yii::t('app', 'Locate Current Tab')?></a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a><?=yii::t('app', 'Close All Tab')?></a>
                    </li>
                    <li class="J_tabCloseOther"><a><?=yii::t('app', 'Close Other Tab')?></a>
                    </li>
                </ul>
            </div>
        </div>
       <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?=Url::to(['site/main']) ?>" frameborder="0" data-id="<?=Url::to(['site/main']) ?>" seamless></iframe>
        </div>

      <!--    <div class="footer">
                <div class="pull-right">&copy; <a href="javascript:void(0)" target="_blank">太极兵饮水云平台</a></div>
        </div> -->


    </div>
    <!--右侧部分结束-->
</div>
</body> 
<?php $this->endBody() ?>
<script>
  var role_id=<?=$role_id?>;
    if(role_id==2){
      $(".J_iframe").attr('src',"index.php?r=dev-manager/map")
    }

    function reloadIframe(){
        var current_iframe=$("iframe:visible");
         if(current_iframe[0].contentWindow.location.href.indexOf("site")>-1){
                   console.log(current_iframe[0].contentWindow.location.href)
                if(current_iframe[0].contentWindow.location.href.indexOf("real_time=1")>-1){
                   current_iframe[0].contentWindow.location.replace(current_iframe[0].contentWindow.location.href);
                 }else{
                  current_iframe[0].contentWindow.location.replace(current_iframe[0].contentWindow.location.href+'&real_time=1');
                 }

         }else{
                 current_iframe[0].contentWindow.location.reload();
         }

        return false;
    }
    var _width= $(".navbar-static-side").width()
    $(".navbar-header a").click(function(){
            var oBox = document.getElementById('page-wrapper');  
        if(oBox.style.marginLeft =='220px'){
            $(" #page-wrapper").css('marginLeft','70px')
            $(".navbar-default").eq(0).css('marginLeft','0px')
        }else if(oBox.style.marginLeft =='70px'){
             $(" #page-wrapper").css('marginLeft','220px')
        }
    })
     var _marginLeft =  false;
   $("#FullScreen").click(function(){
      var oBox = document.getElementById('page-wrapper'); 
      var marginLeftNum =  parseInt(oBox.style.marginLeft)
    if(!_marginLeft){
         $('#FullScreen p').text('退出全屏')
         $("#bodyFixed").addClass('mini-navbar');
         $(" #page-wrapper").css('marginLeft','0px')
         $("#content-main").css('height','100%')
         // $('#FullScreen').css({'marginTop':'65px'})
         // $('#FullScreen').css({'marginTop':'65px','right':'20px','top':'0px','position':'fixed'})
         $(".border-bottom").css('marginTop',' -120px')
        $(".navbar-default").eq(0).css({'marginLeft':'-220px'})
        _marginLeft = true;
        $("#FullScreen").attr('datae',_marginLeft)
        var docElm = document.documentElement;
        if (docElm.requestFullscreen) {  
            docElm.requestFullscreen();  
        }
        //FireFox  
        else if (docElm.mozRequestFullScreen) {  
            docElm.mozRequestFullScreen();  
        }
        //Chrome等  
        else if (docElm.webkitRequestFullScreen) {  
            docElm.webkitRequestFullScreen();  
        }
        //IE11
        else if (docElm.msRequestFullscreen) {
          docElm.msRequestFullscreen();
        }
        }
        else{
           _marginLeft = false;
            $("#FullScreen").attr('datae',_marginLeft)
           $("#bodyFixed").removeClass('mini-navbar')
           $('#FullScreen p').text('全屏')
           $(" #page-wrapper").css('marginLeft','220px')
           // $('#FullScreen').css({'marginTop':'15px','right':'10px','top':'55px','position':'absolute'})
           $(".border-bottom").css('marginTop',' 0px')
           $("#content-main").css('height','calc(100% - 100px)')

           $(".navbar-default").eq(0).css({'marginLeft':'0px'})
           
            if (document.exitFullscreen) {  
                document.exitFullscreen();  
            }  
            else if (document.mozCancelFullScreen) {  
                document.mozCancelFullScreen();  
            }  
            else if (document.webkitCancelFullScreen) {  
                document.webkitCancelFullScreen();  
            }
            else if (document.msExitFullscreen) {
                  document.msExitFullscreen();
            }
        }
   
            
   })

$(window).resize(function(){
if(!checkFull()){
        _marginLeft = false;
            $("#FullScreen").attr('datae',_marginLeft)
           $("#bodyFixed").removeClass('mini-navbar')
           $('#FullScreen p').text('全屏')
           // $('.normal-mode').css('display','block')
           $(" #page-wrapper").css('marginLeft','220px')
           // $('#FullScreen').css({'marginTop':'15px','right':'10px','top':'55px','position':'absolute'})
           $(".border-bottom").css('marginTop',' 0px')
           $("#content-main").css('height','calc(100% - 100px)')
           $(".navbar-default").eq(0).css({'marginLeft':'0px'})
            if (document.exitFullscreen) {  
            document.exitFullscreen();  
            }  
            else if (document.mozCancelFullScreen) {  
                document.mozCancelFullScreen();  
            }  
            else if (document.webkitCancelFullScreen) {  
                document.webkitCancelFullScreen();  
            }
            else if (document.msExitFullscreen) {
                  document.msExitFullscreen();
            }
  }
}
)

function checkFull(){
var isFull =  document.fullscreenEnabled || window.fullScreen || document.webkitIsFullScreen || document.msFullscreenEnabled;

if(isFull === undefined) isFull = false;
return isFull;
} 

</script>
</html>
<?php $this->endPage() ?>
<script>



 
</script> 