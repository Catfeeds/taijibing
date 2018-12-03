<?php
namespace backend\models;

use yii\db\ActiveRecord;

class TeaBrand extends ActiveRecord{

    public function attributeLabels()
    {
        return [
            'BrandNo' => '品牌编号',
            'BrandName' => '品牌名称',
            'RowTime'=>'操作时间',
            'Price'=>'价格'
        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['BrandNo', 'BrandName'],
            'create' => ['BrandNo', 'BrandName'],
            'add' => [ 'BrandName'],
        ];
    }

    public function rules()
    {
        return [
            [['BrandName'], 'required'],
        ];
    }

    public static function allQuery()
    {
        return TeaBrand::findBySql("select * from brands where CategoryId=2");
    }
    public static function pageQuery($offset = 0, $limit = 0)
    {
        return TeaBrand::findBySql("select * from brands where CategoryId=2 limit $offset , $limit");
    }
    public function createData(){
        $this->setAttribute("BrandNo",md5($this["BrandName"]));
        $this->setAttribute("RowTime",date("Y-m-d H:m:s"));
        return $this->save();
//        return true;
    }
    public static function deleteByBrandno($brandno){
        return TeaBrand::deleteAll("BrandNo = '$brandno'");
    }
}