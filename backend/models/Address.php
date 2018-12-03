<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/18
 * Time: 下午6:47
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Address extends ActiveRecord
{


    public static function tableName()
    {
        return 'address_tree';
    }
    public function scenarios()
    {
        return [
            'default' => ['PId', 'Name','Id'],
        ];
    }
    public function add($CityNumber){
        $this->setAttribute("RowTime",date("Y-m-d h:m:s"));
        if($CityNumber){
            $this->setAttribute("CityNumber",$CityNumber);
        }
        return $this->save();
    }
    public static function allQuery(){
//        return Address::findBySql("select * from address_tree where IsUse=1");
        return Address::findBySql("select * from address_tree ");
    }
    public static function pageQuery($offset = 0, $limit = 0,$order)
    {
        return Address::findBySql("select * from address_tree  where IsUse=1 $order limit $offset , $limit");
    }


}