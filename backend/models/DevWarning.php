<?php
namespace backend\models;

use yii\db\ActiveRecord;

class DevWarning extends ActiveRecord{
    public static function tableName()
    {
        return 'dev_warning';
    }

    public function rules()
    {
        return [
            [['DevNo','Type','Level','State','UpTime','BarCode'],'safe'],

        ];
    }
}
