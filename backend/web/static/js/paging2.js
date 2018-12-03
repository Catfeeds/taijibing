(function($, window, document, undefined) {
	//定义分页类
	function Paging(element, options) {
		this.element = element;
		//传入形参
		this.options = {
			pageNo: options.pageNo || 1,
			totalPage:Math.ceil(datasNum/$('#Jumpdisplay option:selected').val()),
			totalSize: options.totalSize,
			callback: options.callback
			// Jump:options.Jump
		};
		//根据形参初始化分页html和css代码
		this.init();
	}
	//对Paging的实例对象添加公共的属性和方法
	Paging.prototype = {
		constructor: Paging,
		init: function() {
			this.creatHtml();
			this.bindEvent();
		},
		creatHtml: function() {
			var me = this;
			var content = "";
			var current = me.options.pageNo;
			var total = Math.ceil(datasNum/$('#Jumpdisplay option:selected').val());
			var totalNum = me.options.totalSize;
			content += "<span class='totalSize'> 共<span>" + totalNum + "</span>条记录 </span>";
			content += "<a id='prePage'><</a>";
			//总页数大于6时候
			if (total > 6) {
				//当前页数小于5时显示省略号
				if (current < 5) {
					for (var i = 1; i < 6; i++) {
						if (current == i) {
							content += "<a class='current'>" + i + "</a>";
						} else {
							content += "<a>" + i + "</a>";
						}
					}
					content += ". . .";
					content += "<a>" + total + "</a>";
				} else {
					//判断页码在末尾的时候
					if (current < total - 3) {
						for (var i = current - 2; i < current*1 + 3; i++) {
							if (current == i) {
								content += "<a class='current'>" + i + "</a>";
							} else {
								content += "<a>" + i + "</a>";
							}
						}
						content += ". . .";
						content += "<a>" + total + "</a>";
						//页码在中间部分时候	
					} else {
						content += "<a>1</a>";
						content += ". . .";
						for (var i = total - 4; i < total + 1; i++) {
							if (current == i) {
								content += "<a class='current'>" + i + "</a>";
							} else {
								content += "<a>" + i + "</a>";
							}
						}
					}
				}
				//页面总数小于6的时候
			} else {
				for (var i = 1; i < total + 1; i++) {
					if (current == i) {
						content += "<a class='current'>" + i + "</a>";
					} else {
						content += "<a>" + i + "</a>";
					}
				}
			}
			content += "<a id='nextPage'>></a>";
		 

 
			content += "<span class='JumpPages'> 跳转到<span>&nbsp;<input style='width:30px;text-align: center;' id='Jumpnump' value=" + me.options.pageNo + " >&nbsp;</span>页 </span>";
			content += "<span class='JumpPagesbtn'> <button type='text' id='JumpPagesbtn'>确认</button> </span>";
	
			me.element.html(content);


		},
		//添加页面操作事件
		bindEvent: function() {
			var me = this;
			me.element.off('click', 'a');
			me.element.on('click', 'a', function() {
				
				var num = $(this).html();
				var id = $(this).attr("id");
				if (id == "prePage") {
					if (me.options.pageNo <= 1) {
				 
					    	me.options.pageNo = 1;
					} else {
						
						 
					me.options.pageNo = +me.options.pageNo - 1;
						

						
					}
				} else if (id == "nextPage") {
						 
					if (me.options.pageNo >= Math.ceil(datasNum/$('#Jumpdisplay option:selected').val())) {

						me.options.pageNo  = Math.ceil(datasNum/$('#Jumpdisplay option:selected').val())

               
					} else {
							 
						me.options.pageNo = +me.options.pageNo + 1;
					}

				} 
				// else if (id == "firstPage") {
				// 	me.options.pageNo = 1;
				// } else if (id == "lastPage") {
				// 	me.options.pageNo = me.options.totalPage;
				// } 

				else {
					me.options.pageNo = +num;
				}
				me.creatHtml();
				if (me.options.callback) {
					me.options.callback(me.options.pageNo);
				}
			});


			 $("#Jumpdisplay").change(function(){
				 me.options.pageNo=1
 

				 	var searchParameters={
         selecttime:$("#selecttime1 option:selected").val(),
        province:$('#province option:selected').val(),
        city:$('#city option:selected').val(),
        area:$('#area option:selected').val(),
        state:$("#Upgrades option:selected").val(),
        devbrand_id:$("#devbrand option:selected").val(),
        devname_id:$("#devname option:selected").val(),
        agenty_id:$("#Agenty option:selected").val(),
        agentf_id:$("#Agentf option:selected").val(),
        devfactory_id:$("#devfactory option:selected").val(),
        investor_id:$("#investor option:selected").val(),
        customertype :$("#customertype option:selected").val(),
        search :$("#search").val(),
		offset:0,
		limit: $('#Jumpdisplay option:selected').val()
        }
        
       Get_datas(searchParameters) 
				me.creatHtml();
			 })


			  me.element.on('keyup afterpaste', '#Jumpnump', function(){
				this.value=this.value.replace(/\D/g,'')
         		this.max=Math.ceil(datasNum/$('#Jumpdisplay option:selected').val())
		    	}).on('change',function() {
		    	    var   total= Math.ceil(datasNum/$('#Jumpdisplay option:selected').val())
		    		var Jump =  $('#Jumpdisplay option:selected').val()
			         var _thisval = $('#Jumpnump').val();
				
			           if(_thisval<=1){

			         	_thisval=1
			         	$('#Jumpnump').val(1)


			         } else  if(_thisval >= total){
  						//alert("最大页数"+total+"页")
			                _thisval =total;
			                	
			               $('#Jumpnump').val(_thisval)
			         }
		    	}) ;

				me.element.on('click', '#JumpPagesbtn', function() {
					if (me.options.pageNo >= Math.ceil(datasNum/$('#Jumpdisplay option:selected').val())) {
						me.options.pageNo = Math.ceil(datasNum/$('#Jumpdisplay option:selected').val())

					}

				         if(me.options.pageNo<=1){
							 me.options.pageNo=1
						  }

						var Jumpnumpval = $("#Jumpnump").val()
						var Jumpdisplayval = $('#Jumpdisplay option:selected').val()
						me.options.pageNo = Jumpnumpval
						$("#toNum").text(Jumpnumpval)
						$("#Jumpnump").val(Jumpnumpval)
						
									 	var searchParameters={
              selecttime:$("#selecttime1 option:selected").val(),
        province:$('#province option:selected').val(),
        city:$('#city option:selected').val(),
        area:$('#area option:selected').val(),
        state:$("#Upgrades option:selected").val(),
        devbrand_id:$("#devbrand option:selected").val(),
        devname_id:$("#devname option:selected").val(),
        agenty_id:$("#Agenty option:selected").val(),
        agentf_id:$("#Agentf option:selected").val(),
        devfactory_id:$("#devfactory option:selected").val(),
        investor_id:$("#investor option:selected").val(),
        customertype :$("#customertype option:selected").val(),
        search :$("#search").val(),
       offset: Jumpnumpval * Jumpdisplayval - Jumpdisplayval,
		limit: Jumpdisplayval
        }
       Get_datas(searchParameters) 
						 $("#toNum").text(Jumpnumpval)
                       me.options.pageNo=Jumpnumpval

						me.creatHtml();
			});
		}
	};
	//通过jQuery对象初始化分页对象
	$.fn.paging = function(options) {
		return new Paging($(this), options);
	}
})(jQuery, window, document);