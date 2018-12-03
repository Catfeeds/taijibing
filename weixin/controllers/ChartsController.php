<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/3/17
 * Time: 下午2:11
 */
class ChartsController extends \yii\web\Controller
{
    public function actionIncome()
    {

        return $this->renderPartial("income");
    }
    public function actionDevice()
    {

        return $this->renderPartial("device");
    }
    public function actionChannel()
    {

        return $this->renderPartial("channel");
    }


}