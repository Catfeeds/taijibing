<?php
namespace backend\models;
use yii\db\ActiveRecord;

class FactoryWcode extends ActiveRecord{
    public static function tableName()
    {
        return 'factory_wcode';
    }

    public function scenarios()
    {
        return [
            'default' => ['Fid','PrintAmount',
                'LeftAmount',
                'Amount','Volume','WaterBrand'],
        ];
    }




    public function attributeLabels()
    {
        return [
            'Fid' => '厂家',
            'PrintAmount' => '使用条码数',
            'LeftAmount' => '剩余条码数',
            'Volume' => '购买容量(L)',
            'Amount'=>'购买数量',
            'WaterBrand'=>'选择品牌'
        ];
    }

}
