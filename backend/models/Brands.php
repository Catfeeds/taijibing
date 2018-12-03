<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Brands extends ActiveRecord{
    public static function tableName()
    {
        return 'brands';
    }
    public function rules()
    {
        return [
            [['BrandNo','BrandName','CategoryId'], 'required'],
        ];
    }
}
