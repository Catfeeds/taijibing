<?php
namespace backend\controllers;

use backend\models\DevFactory;
use backend\models\DevRegist;
use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;

/**
 * Base controller is the whole backend controllers parent class, and supported basic operation(such as crud,sort...).
 */
class BaseController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', $this->getIndexData());
    }

    public function actionCreate(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $model = $this->getModel();
        if( yii::$app->getRequest()->getIsPost() ) {
            if ( $model->load(yii::$app->getRequest()->post()) && $model->validate() && $model->save() ) {
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['index']);
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }
        $model->loadDefaultValues();
        $array = array_merge(['model'=>$model,'url'=>$urlobj], $this->getCreateData());
        return $this->render('create',$array);
    }

    public function actionDelete($id)
    {
        if(yii::$app->getRequest()->getIsAjax()){
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            if(!$id) return['code'=>1, 'message' => yii::t('app', "Id doesn't exit" )];
            $ids = explode(',', $id);
            $errorIds = [];
            foreach ($ids as $one){
                $model = $this->getModel($one);
                if($model) {
                    if (!$result = $model->delete()){
                        $errorIds[] = $one;
                    }
                }
            }
            if(count($errorIds) == 0){
                return ['code'=>0, 'message'=>yii::t('app', 'Success')];
            }else{
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0];
                }
                if($err != '') $err = '.'.$err;
                return ['code'=>1, 'message'=>'id '.implode(',', $errorIds).$err];
            }
        }else {
            if(!$id) return $this->render('/error/error', [
                'code' => '403',
                'name' => 'Params required',
                'message' => yii::t('app', "Id doesn't exit"),
            ]);
            $model = $this->getModel($id);
            if($model) {
                $model->delete();
            }
            return $this->redirect(yii::$app->request->headers['referer']);
        }
    }

    public function actionUpdate($id)
    {
        $urlobj = $this->getParam("Url");//返回参数记录
        if(!$id) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        $model = $this->getModel($id);
        if(!$model) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        if ( Yii::$app->request->isPost ) {
            if( $model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->save() ){
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['update', 'id'=>$model->getPrimaryKey()]);
            }else{
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'url'=>$urlobj
        ]);
    }

    public function actionSort()
    {
        if(yii::$app->getRequest()->getIsPost()) {
            $data = yii::$app->getRequest()->post();
            if (!empty($data['sort'])) {
                foreach ($data['sort'] as $key => $value) {
                    $model = $this->getModel($key);
                    if( $model->sort != $value ){
                        $model->sort = $value;
                        $model->save();
                    }
                }
            }
        }
        $this->redirect(['index']);
    }

    public function actionChangeStatus($id='', $status=0, $field='status')
    {
        if( yii::$app->getRequest()->getIsAjax() ) yii::$app->getResponse()->format = Response::FORMAT_JSON;
        if(!$id) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        $model = $this->getModel($id);
        if(!$model) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        $model->$field = $status;
        if( yii::$app->getRequest()->getIsAjax() ) {
            if ($model->save()) {
                return ['code' => 0, 'message' => yii::t('app', 'Success')];
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                return ['code' => 1, 'message' => $err];
            }
        }else{
            $model->save();
            return $this->redirect(yii::$app->getRequest()->headers['referer']);
        }
    }

    public function getModel($id='')
    {
        return '';
    }

    public function getIndexData()
    {
        return [];
    }

    public function getCreateData()
    {
        return [];
    }
    protected  function jsonReturn($res){

        Yii::$app->response->content = json_encode($res);
    }
    protected  function jsonErrorReturn($error){
        $data["state"]=-1;
        $data["desc"]=$error;
        $this->jsonReturn($data);
    }

    /**
     * @param string $name
     * @return array|mixed
     */
    protected function getParam($name=''){
        if(Yii::$app->request->isPost){
            return Yii::$app->request->post($name);
        }
        return Yii::$app->request->get($name);
    }
    protected function getWrapData($state,$data,$desc=''){
        $data["state"]=$state;
        if(!empty($data)){
            $data["data"]=$data;
        }
        $data["desc"]=$desc;
        return $data;
    }



//根据服务中心或运营中心 获取对应的入网属性
    public function GetUseTypeByAgent($agenty_id='',$agentf_id=''){
        $use_type='';
        if($agenty_id && !$agentf_id){//只选了运营中心
            //该运营中心下所有服务中心的入网属性（去重）
            $use_type=ActiveRecord::findBySql("select DISTINCT use_type from agent_usetype_code
where (EXISTS (select 1 from agent_info where ParentId=$agenty_id and Id=agent_usetype_code.agent_id )
or agent_id=0) and state=0
")->asArray()->all();
        }elseif($agentf_id){
            $use_type=ActiveRecord::findBySql("select DISTINCT use_type from agent_usetype_code
where (agent_id=$agentf_id or agent_id=0) and state=0
")->asArray()->all();
        }elseif(!$agenty_id && !$agentf_id){
            //入网属性（去重）
            $use_type=ActiveRecord::findBySql("select DISTINCT use_type from agent_usetype_code  where state=0")->asArray()->all();

        }
        return $use_type;
    }

    //所有入网属性
    public function GetAllUseType(){
        $all_use_type=ActiveRecord::findBySql("select code,use_type from agent_usetype_code ")->asArray()->all();
        return $all_use_type;
    }

    //入网属性（去重）
    public function GetUseType(){
        //所有入网属性
        $use_type=ActiveRecord::findBySql("select DISTINCT use_type from agent_usetype_code where state=0")->asArray()->all();
        return $use_type;
    }

    //根据设备编号获取上级（服务中心、片区中心、运营中心）
    public function GetParentByDevNo($DevNo){
        $parent=['agentFname'=>'','agentPname'=>'','agentYname'=>''];
        $dev=(new DevRegist())->findOne(['DevNo'=>$DevNo]);
        if($dev){
          $agent_id=$dev->AgentId;
        }else{
            return $parent;
        }
        $data=ActiveRecord::findBySql("select Name,ParentId,Level from agent_info where Id=$agent_id")->asArray()->one();
        if(!$data) return $parent;
        if($data['Level']==4){//设备直接挂在运营中心下的
            $parent['agentYname']=$data['Name'];
        }
        if($data['Level']==5||$data['Level']==8){//设备挂在服务中心下的
            $parent['agentFname']=$data['Name'];
            $data=ActiveRecord::findBySql("select Name,ParentId,Level from agent_info where Id={$data['ParentId']}")->asArray()->one();
            if(!$data) return $parent;
            if($data['Level']==4){//服务中心挂在运营中心下的
                $parent['agentYname']=$data['Name'];
            }
            if($data['Level']==7){//服务中心挂在片区中心下的
                $parent['agentPname']=$data['Name'];
                $data=ActiveRecord::findBySql("select Name,ParentId,Level from agent_info where Id={$data['ParentId']}")->asArray()->one();
                if(!$data) return $parent;
                $parent['agentYname']=$data['Name'];
            }
        }
        if($data['Level']==7){//设备挂在片区中心下的
            $parent['agentPname']=$data['Name'];
            $data=ActiveRecord::findBySql("select Name,ParentId,Level from agent_info where Id={$data['ParentId']}")->asArray()->one();
            if(!$data) return $parent;
            if($data['Level']==4){//片区中心挂在运营中心下的
                $parent['agentYname']=$data['Name'];
            }
        }

        return $parent;
    }

    //根据服务中id心获取上级（片区中心、运营中心）
    public function GetParentByAgentF($agent_id){
        $parent=['agentFname'=>'','agentPname'=>'','agentYname'=>''];

        $data=ActiveRecord::findBySql("select Name,ParentId,Level from agent_info where Id=$agent_id")->asArray()->one();
        if(!$data) return $parent;
        $parent['agentFname']=$data['Name'];
        $data=ActiveRecord::findBySql("select Name,ParentId,Level from agent_info where Id={$data['ParentId']}")->asArray()->one();

        if(!$data) return $parent;
        if($data['Level']==4){//服务中心直接挂在运营中心下的
            $parent['agentYname']=$data['Name'];
        }

        if($data['Level']==7){//服务中心挂在片区中心下的
            $parent['agentPname']=$data['Name'];
            $data=ActiveRecord::findBySql("select Name,ParentId,Level from agent_info where Id={$data['ParentId']}")->asArray()->one();
            if(!$data) return $parent;
            if($data['Level']==4){//片区中心挂在运营中心下的
                $parent['agentYname']=$data['Name'];
            }
        }

        return $parent;
    }



}
