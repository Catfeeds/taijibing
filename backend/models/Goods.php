<?php
namespace backend\models;


use yii\db\ActiveRecord;

class Goods extends ActiveRecord
{
    public $custom_volume;//自定义容量

    public static function tableName()
    {
        return 'goods';
    }

    public function attributeLabels()
    {
        return [
            'name' => '商品名称',
            'brand_id' => '商品品牌',
            'factory_id' => '水厂名称',
            'cardfactory' => '卡片厂家',
            'volume' => '商品规格',
            'type' => '设备类型',
            'category_id' => '商品一级分类',
            'category2_id' => '商品二级分类',
            'unit' => '单位',

        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['name','category_id','brand_id','stock','originalprice',
                'saleprice','addtime','state','goods_image1','goods_image2',
                'goods_image3','goods_image4','goods_image5','goods_image6','morning','night','unit'],
            'create' => ['type','cardfactory','name', 'brand_id','addtime','goods_image1','goods_image2', 'goods_image3','goods_image4','goods_image5','goods_image6','unit'],
            'create2' => ['name', 'brand_id','volume','addtime','goods_image1','goods_image2', 'goods_image3','goods_image4','goods_image5','goods_image6','category_id','category2_id','type','cardfactory','unit'],
        ];
    }

    public function rules()
    {
        return [

            [['model_id','name','category_id','category2_id','brand_id','stock','originalprice', 'saleprice','addtime','state'],'required'],
//            [['name'],'unique'],
            [['goods_image1','goods_image2', 'goods_image3','goods_image4','goods_image5','goods_image6','shop_tel1','shop_tel2','type','cardfactory','volume','unit'],'safe']
//            [['brand_id'],'required'],
//            [['factory_id'],'required'],
        ];
    }




//    public function query(){
//        return static::findBySql("select id,name from goods_merchant")->asArray()->all();
//
//    }
}
