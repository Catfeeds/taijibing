<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 17:07
 */
?>
<style type="text/css" media="screen">
	.ibox{
		padding:20px;
	}
</style>
<?php 
    if(yii::$app->controller->action->id == 'update'){
        echo $this->render('_form', [
            'model' => $model,
            'rolesModel' => $rolesModel,
            'roles' => $roles,
        ]);
    }else{
        echo $this->render('_form-update-self', [
            'model' => $model
        ]);
    }
?>
  <script> 

  </script>

