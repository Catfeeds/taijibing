<?php
namespace backend\models;


use yii\db\ActiveRecord;

class Goods extends ActiveRecord
{
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

        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['name','category_id','brand_id','stock','factory_id','originalprice',
                'saleprice','addtime','state','goods_image1','goods_image2',
                'goods_image3','goods_image4','goods_image5','goods_image6',],
            'create' => ['name', 'brand_id','factory_id','addtime','goods_image1','goods_image2', 'goods_image3','goods_image4','goods_image5','goods_image6'],
        ];
    }

    public function rules()
    {
        return [

            [['name','category_id','brand_id','factory_id','stock','originalprice', 'saleprice','addtime','state',],'required'],
//            [['name'],'unique'],
            [['goods_image1','goods_image2', 'goods_image3','goods_image4','goods_image5','goods_image6',],'safe']
//            [['brand_id'],'required'],
//            [['factory_id'],'required'],
        ];
    }




//    public function query(){
//        return static::findBySql("select id,name from goods_merchant")->asArray()->all();
//
//    }
}
