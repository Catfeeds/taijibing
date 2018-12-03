<?php
namespace backend\models;

use yii\db\ActiveRecord;

class GoodsImage extends ActiveRecord{
    public static function tableName()
    {
        return 'goods_image';
    }

    public function rules()
    {
        return [

            [['goods_image1','goods_image2', 'goods_image3','goods_image4',
                'goods_image5','goods_image6','goods_image7','goods_image8',
                'goods_image9','goods_image10','goods_image11','goods_image12'
            ],'string']
        ];
    }
}
