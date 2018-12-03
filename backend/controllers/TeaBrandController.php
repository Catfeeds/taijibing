<?php
/**
 * Created by PhpStorm.
 * User: 12195
 * Date: 2017/8/23
 * Time: 16:21
 */

namespace backend\controllers;


use backend\models\DevFactory;


use backend\models\Goods;
use backend\models\TeaBrand;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveRecord;

class TeaBrandController extends BaseController
{
    //升级包目录
    public  $upgrade_dir='../../../111/222/';
//    public  $upgrade_dir='../../../../proxy/file/';

    public function getIndexData()
    {
        $query = TeaBrand::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return [
            'dataProvider' => $dataProvider,
        ];
    }

//茶吧机品牌首页
    public function actionList()
    {
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }

        //添加时间排序
        $sort=$this->getParam("sort");//点击排序
        if($sort==''){
            $sort=0;
        }

        //修改时间排序
        $sort2=$this->getParam("sort2");//点击排序
        if($sort2==''){
            $sort2=0;
        }

        //获取搜索内容
        $search=addslashes(trim($this->getParam('search')));
        $where='';
        if(!empty($search)){
            $where=" and (goods.name like '%{$search}%' or brands.BrandName like '%{$search}%' or dev_factory.Name  like '%{$search}%')";
        }

        //排序（添加时间）
        $order=" order by addtime desc ";
        if($sort && $sort%2==1){//偶数 升序
            $order=" order by addtime asc ";

        }
        if($sort && $sort%2==0){//偶数 升序
            $order=" order by addtime desc ";

        }


        //排序（修i该时间）
        if($sort2 && $sort2%2==1){//偶数 升序
            $order=" order by updatetime asc ";

        }
        if($sort2 && $sort2%2==0){
            $order=" order by updatetime desc ";
        }



        $datas=ActiveRecord::findBySql("select goods.*,
           brands.BrandName,brands.BrandNo, dev_factory.Name as devfactory_name from goods
           LEFT JOIN brands on goods.brand_id=brands.BrandNo
           LEFT JOIN dev_factory on goods.factory_id=dev_factory.Id
           where goods.state=0 and goods.category_id=2 $where $order
           ");//state -1 表示已删除 0 正常   category_id 1：表示袋装水 2：茶吧机

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $model = ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
//        var_dump($model);exit;
        return $this->render('list', [
            'search' => $search,
            'model' => $model,
            'pages' => $pages,
            'sort' => $sort,
            'sort2' => $sort2,
            'page_size' => $page_size,
            'page' => $page,
        ]);





//        $datas =TeaBrand::allQuery();
//        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 5]);
//        $querys =TeaBrand::pageQuery($pages->offset,$pages->limit);
//        $model = $querys->asArray()->all();
//        return $this->render('list', [
//            'model' => $model,
//            'pages' => $pages,
//        ]);
    }

    //创建商品
    public function actionCreate()
    {
        //茶吧机品牌
        $teabrand = (new TeaBrand())->find()->all();
        //茶吧机厂家
//        $devfactory=DevFactory::find()->all();

        $goods=new Goods();

        $goods->setScenario('create');

        if ( \Yii::$app->getRequest()->getIsPost() ) {

            $goods->load(\Yii::$app->getRequest()->post());
            $goods->addtime=time();
            $goods->factory_id=0;
            $goods->stock=0;
            $goods->originalprice=0;
            $goods->saleprice=0;
            $goods->updatetime=0;
            $goods->state=0;
            $goods->category_id=2;//1为袋装水，2为茶吧机
//            var_dump($goods->goods_image1,$goods->goods_image2,$goods->goods_image3,$goods->goods_image4,$goods->goods_image5,$goods->goods_image6);exit;
            if($goods->validate()&&$goods->save()){

                //创建对应的升级文件夹
                //判断文件夹是否存在，不存在就创建
                $brandname=ActiveRecord::findBySql("select BrandName from brands where BrandNo='$goods->brand_id'")->asArray()->one()['BrandName'];
                $filename=$brandname.'_'.$goods->name;
//                var_dump($filename);exit;
                    $dir = iconv("UTF-8", "GBK", "$this->upgrade_dir$filename");
                    if (!file_exists($dir)){
                        mkdir ($dir,0777,true);
//                        echo "创建文件夹".$filename."成功";exit;
                    }

                \Yii::$app->getSession()->setFlash('success', \yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                $errors = $goods->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                \Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('create', [
            'teabrand' => $teabrand,
            'goods'=>$goods,
//            'devfactory'=>$devfactory,
        ]);
    }


    //修改
    public function actionUpdate($id){
        if(!$id) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => \yii::t('app', "Id doesn't exit"),
        ]);
        //获取该商品信息
        $goods=Goods::findOne(['id'=>$id]);
        //茶吧机品牌
        $teabrand = (new TeaBrand())->find()->all();
        //茶吧机厂家
//        $devfactory=DevFactory::find()->all();

        //原来升级包文件夹名称
        $old_filename=TeaBrand::findOne(['BrandNo'=>$goods->brand_id])->BrandName.'_'.$goods->name;
        $brand_id=$goods->brand_id;
        $goods_id=$goods->id;

//var_dump($old_filename);exit;

        if(!$goods) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => \yii::t('app', "goods doesn't exit"),
        ]);

//        var_dump($goods);exit;

        $goods->setScenario('create');
        if ( \Yii::$app->getRequest()->getIsPost() ) {

            $goods->load(\yii::$app->getRequest()->post());
            $goods->updatetime=time();
//            var_dump($goods->name,$old_filename);exit;
            //修改后应生成的文件夹名称
            $filename=TeaBrand::findOne(['BrandNo'=>$goods->brand_id])->BrandName.'_'.$goods->name;
            //原来的文件夹
            $old_dir = iconv("UTF-8", "GBK", "$this->upgrade_dir$old_filename");
            //修改后要创建的文件夹
            $dir = iconv("UTF-8", "GBK", "$this->upgrade_dir$filename");

            //判断是否有设备正在升级
//            $data=ActiveRecord::findBySql("select DevNo from dev_regist where brand_id='$brand_id' and goods_id=$goods_id and IsUpgrade=1 and State=0")->asArray()->all();
//            if($old_filename!=$filename && $data){
//                \Yii::$app->getSession()->setFlash('error', '有设备正在升级');
//                return $this->redirect(['list']);
//            }

            if($goods->validate()&&$goods->save()){

                                //判断文件名是否发生改变（修改商品品牌和名称）
                if($old_filename!=$filename){//修改了

                    if (!file_exists($old_dir)){//原来的不存在

                        if (!file_exists($dir)){//修改后的不存在
                            mkdir ($dir,0777,true);//创建新的
                        }

                    }else{//原来的存在

                        if (!file_exists($dir)){//修改后的不存在
                            mkdir ($dir,0777,true);//创建修改后的

                            //将原来文件夹下的升级文件复制到修改后的
                            $this->copyfile($old_dir,$dir);
                            //删除原来的
                            $this->deldir($old_dir);

                        }

                    }

                }else{//没有修改
                    //原来的文件夹
                    $old_dir = iconv("UTF-8", "GBK", "$this->upgrade_dir$old_filename");

                    if (!file_exists($old_dir)){//原来的不存在
                            mkdir ($old_dir,0777,true);//创建新的

                    }

                }
                \Yii::$app->getSession()->setFlash('success', \yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                $errors = $goods->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                \Yii::$app->getSession()->setFlash('error', $err);
                return $this->redirect(['list']);
            }
        }

        return $this->render('create', [
            'teabrand' => $teabrand,
            'goods'=>$goods,
//            'devfactory'=>$devfactory,
        ]);

    }


    //删除文件夹及下面的文件
    function deldir($dir) {
        //先删除目录下的文件：
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->deldir($fullpath);
                }
            }
        }

        closedir($dh);
        //删除当前文件夹：
        if(rmdir($dir)) {
            return true;
//            return true;
        } else {
            return false;
        }
    }

    //复制文件夹下面的文件
    function copyfile($old_dir,$dir) {

        $dh=opendir($old_dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$old_dir."/".$file;
                if(!is_dir($fullpath)) {
                    @copy($fullpath,$dir."/".$file);
                }
            }
        }

        closedir($dh);

    }


    //删除
    public function actionDelete($id)
    {
        if(empty($id)){
            $this->jsonErrorReturn("参数错误");
            return;
        }
        $goods=Goods::findOne(['id'=>$id]);
        $goods->state=-1;//更改状态为-1
        $res=$goods->save(false);
        if($res===false){
            $this->jsonErrorReturn("操作错误,请稍后再试");
            return ;
        }
        $this->jsonReturn(["state"=>0]);

    }




    //添加品牌
    public function actionAdd()
    {
        $model = new TeaBrand();
        $model->setScenario('add');
        if (\Yii::$app->getRequest()->getIsPost()) {

            if ($model->load(\Yii::$app->getRequest()->post()) && $model->validate() && $model->createData()) {

                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Success'));
                return $this->redirect(['list']);
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                \Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);

    }

//    public function actionCreate()
//    {
//        $model = new TeaBrand();
//        $model->setScenario('create');
//        if ( \Yii::$app->getRequest()->getIsPost() ) {
//
//            if($model->load(\Yii::$app->getRequest()->post())&&$model->validate()&&$model->createData()){
//
//                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Success'));
//                return $this->redirect(['list']);
//            }else{
//                $errors = $model->getErrors();
//                $err = '';
//                foreach($errors as $v){
//                    $err .= $v[0].'<br>';
//                }
//                \Yii::$app->getSession()->setFlash('error', $err);
//            }
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

//    public function actionDelete($brandno)
//    {
//        if(empty($brandno)){
//            $this->jsonErrorReturn("参数错误");
//            return;
//        }
//        $res=TeaBrand::deleteByBrandno($brandno);
//        if($res===false){
//            $this->jsonErrorReturn("操作错误,请稍后再试");
//            return ;
//        }
//        $this->jsonReturn(["state"=>0]);
//
//    }

}