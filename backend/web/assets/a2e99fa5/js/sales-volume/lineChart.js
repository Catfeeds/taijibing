// 折线图
function FoldLineDiagram(darax, daray, $name) {

    console.log(darax)
    console.log(daray)
    var myChart = echarts.init(document.getElementById('main'));
    var option = {
        title: {
            text: "",
            x: "center",
            textStyle: {
                color: '#989BA3',
                x: '100px',
            },
        },
        tooltip: {
            trigger: 'axis',
            backgroundColor: '#E6B64F',
            textStyle: {
                color: '#000',
            },
        },
        xAxis: [{
            type: "category",
            axisLabel: {
                //X轴刻度配置
                interval: 2 //0：表示全部显示不间隔；auto:表示自动根据刻度个数和宽度自动设置间隔个数
            },

            splitLine: {
                show: false
            },
            data: darax,
            axisLabel: {
                show: true,
                textStyle: {
                    color: 'rgb(255,255,255)',
                }
            }
        }],

        yAxis: [{
            type: 'value',
            axisLabel: {
                show: true,
                textStyle: {
                    color: 'rgb(255,255,255)',
                }
            }
        }],
        toolbox: {
            show: true,
            feature: {
                mark: {
                    show: false
                },
                dataView: {
                    show: false,
                    readOnly: false,

                },
                restore: {
                    show: false
                },
                saveAsImage: {
                    show: false
                }
            },

        },
       
        calculable: true,
        series: [{
            name: $name,
            type: 'line',
            //data:selloutPackage.y,
            data: daray,
            itemStyle: {
                normal: {

                    color: '#E6B64F',
                    width: 1

                }
            }
        }]
    };
    // 为echarts对象加载数据 
    myChart.setOption(option);

}


function PieChart($name, $data, $namedata) {
    var myChart = echarts.init(document.getElementById('echarts3'));
    var option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)",
            backgroundColor: '#E6B64F',
            textStyle: {
                color: '#000',
            }
        },
        toolbox: {
            show: false,
            feature: {
                mark: {
                    show: false
                },
                dataView: {
                    show: true,
                    readOnly: true,

                },
                magicType: {
                    show: false,
                    type: ['pie', 'funnel'],
                    option: {
                        funnel: {
                            x: '25%',
                            width: '100%',
                            funnelAlign: 'center',
                            max: 1548
                        }
                    }
                },
                restore: {
                    show: true,
                    title: "刷新",
                },
                saveAsImage: {
                    show: false
                }
            }
        },
        calculable: true,
        series: [{
            name: $namedata,
            type: 'pie',
            radius: ['40%', '50%'],
            center: ['55%', '45%'],
            itemStyle: {
                normal: {
                    label: {
                        show: true,
                        formatter: '{d}%'

                    },
                    labelLine: {
                        show: true
                    }
                },
                emphasis: {
                    label: {
                        show: false,
                        position: 'center',
                        textStyle: {
                            fontSize: '30',
                            fontWeight: 'bold'
                        }
                    }
                }
            },
            data: [{
                value: $data[0],
                name: '家庭'
            },
            {
                value: $data[1],
                name: '公司'
            },
            {
                value: $data[2],
                name: '集团'
            },
            {
                value: $data[3],
                name: '酒店'
            },
            {
                value: $data[4],
                name: '其他'
            }

            ]
        }

        ],
        color: ['#E46045', '#C248DC', '#4ADCDD', '#21f507','#FEC751']

    };
    // 为echarts对象加载数据 

    myChart.setOption(option);
}


function PieChart2($name, $data, $namedata) {
    var myChart = echarts.init(document.getElementById('echarts3'));
    var option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)",
            backgroundColor: '#E6B64F',
            textStyle: {
                color: '#000',
            }
        },
        toolbox: {
            show: false,
            feature: {
                mark: {
                    show: false
                },
                dataView: {
                    show: true,
                    readOnly: true,

                },
                magicType: {
                    show: false,
                    type: ['pie', 'funnel'],
                    option: {
                        funnel: {
                            x: '25%',
                            width: '100%',
                            funnelAlign: 'center',
                            max: 1548
                        }
                    }
                },
                restore: {
                    show: true,
                    title: "刷新",
                },
                saveAsImage: {
                    show: false
                }
            }
        },
        calculable: true,
        series: [{
            name: $namedata,
            type: 'pie',
            radius: ['40%', '50%'],
            center: ['55%', '45%'],
            itemStyle: {
                normal: {
                    label: {
                        show: true,
                        formatter: '{d}%'

                    },
                    labelLine: {
                        show: true
                    }
                },
                emphasis: {
                    label: {
                        show: false,
                        position: 'center',
                        textStyle: {
                            fontSize: '30',
                            fontWeight: 'bold'
                        }
                    }
                }
            },
            data: [{
                value: $data[0],
                name: '家庭'
            },
            {
                value: $data[1],
                name: '公司'
            },
            {
                value: $data[2],
                name: '集团'
            },
            {
                value: $data[3],
                name: '酒店'
            },
            {
                value: $data[4],
                name: '其他'
            }

            ]
        }

        ],
        color: ['#E46045', '#C248DC', '#4ADCDD', '#21f507','#FEC751']

    };
    // 为echarts对象加载数据 

    myChart.setOption(option);
}