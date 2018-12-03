<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Customer extends ActiveRecord{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name','Tel','Province','City','Area','Address'],'required'],
            [['Name','Address','Remark'], 'string'],
            [['Tel'],'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Name' => '用户姓名',
            'Tel' => '账号/手机号',
            'Province' => '省',
            'City' => '市',
            'Area' => '区/县',
            'Address' => '详细地址',
            'CustomerType' => '客户类型',
            'UseType' => '入网属性',
            'DevNo' => '设备编号',
        ];
    }
}
