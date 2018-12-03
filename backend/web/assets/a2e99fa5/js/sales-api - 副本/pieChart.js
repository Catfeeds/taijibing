

    var myChart5 = echarts.init(document.getElementById('charts5'));
    	var option5 = {
    title : {
        text: '用户类型销量比',
        textStyle:{
            color:'#fff'
        },
        x:'center'
    },
    // tooltip : {
    //     trigger: 'item',
    //     formatter: "{a} <br/>{b} : {c} ({d}%)"
    // },
    legend: {
        orient : 'vertical',
        x : 'right',
        y : 'bottom',
        data:['家庭','公司','集团','其他'],
          textStyle:{
            color:'#fff'
        }
    },
    toolbox: {
        show : false,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {
                show: true, 
                type: ['pie', 'funnel'],
                option: {
                    funnel: {
                        x: '25%',
                        width: '50%',
                        funnelAlign: 'left',
                        max: 1548
                    }
                }
            },
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : false,

    series : [

        {
            name:'访问来源',
            type:'pie',
          
           
            radius : '55%',
            center: ['50%', '60%'],

            itemStyle : {
                normal : {
                    label : {
                        show : false
                    },
                    labelLine : {
                        show : false
                    }
                }
            },
            data:[
                {value:335, name:'家庭'},
                {value:310, name:'公司'},
                {value:234, name:'集团'},
                {value:135, name:'其他'}
            ]

        }
    ]
};

 myChart5.setOption(option5);