<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="/static/css/chosen.min.css">
</head>
<body>
   <a href="javascript:addGoodType();"> <p class="opop" >eeeeeeeeeeeeeeeeeeeeeeeeeeeeee</p></a>
    <div class="box">
    </div>
</body>
</html>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/chosen.js"></script>
<script type="text/javascript">
function addGoodType(){

var itemAmount=$(".box").find(".item").length;
var currentIndex=itemAmount+1; $('.box').append('<select name=""  id="devbrand'+currentIndex+'" class="item" ><option value="">11</option></select>')
// $('.box').append('<select name="" id="boxlist"><option value="">11</option></select>')
$("#devbrand"+currentIndex).chosen()
}

$(function(){
alert(4)
})
</script>