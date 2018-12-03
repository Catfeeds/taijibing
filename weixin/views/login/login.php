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
    <link rel="stylesheet" href="/static/css/agile.layout.css"/>
    <link rel="stylesheet" href="/static/css/seedsui.min.css"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>

    <title>运营中心系统</title>
    <style>

        .nolrmargin{

            margin-bottom:20px;

        }
        .input-box{
            height:45px;
            line-height:45px;
        }
    </style>
</head>
<body>


<div id="section_container">
    <section data-role="section" id="page_form_validate" class="active" style="background: white;">
        <h2 style="text-align: center;width:100%;height:45px;line-height:45px;font-size:22px;">运营中心登录</h2>

        <article id="main_article" data-role="article" class="active">
            <form id="form1" style="padding:10px;">


                <div class="input-box nolrmargin">
                    <input type="text" placeholder="请输入您的登录账号" name="phone" data-rule-field="账号" data-rule="phone" id="username"/>
                </div>

                <div class="input-box nolrmargin">
                    <input type="password" placeholder="请输入密码" name="mail" data-rule-field="密码" data-rule="chinese" id="password"/>
                </div>



                <input class="submit block" type="button" value="登&nbsp;&nbsp;录"/>
            </form>
        </article>
    </section>
</div>

<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script>
    $(function(){

        $(".submit").on("click",function(){
            var username=$("#username").val();
            var password=$("#password").val();
            if(username==""||password==""){
                $.alert("用户名或密码不能为空");
                return;
            }
            $.showPreloader("登录中……");
            $.getJSON("/index.php/login/login?username="+username+"&password="+password,function(data){
                $.hidePreloader();
                if(data.state!=0){
                    $.alert(data.msg);
                    return;
                }
                window.location.replace("/index.php/index/index");
            });


        });
    });

</script>
</body>

</html>
