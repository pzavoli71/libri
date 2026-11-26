
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use pzavoli71\widgets\AutocompleteDropdown;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\libro\TipoLibro $model */
/** @var yii\widgets\ActiveForm $form */

?>

<?php $this->params['breadcrumbs'][] = $this->title; 
$this->params['home'] = Url::to(['/libro/tipolibro/view','TpLibro'=>$model->TpLibro]);  ?>

<div class="tipolibro-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'TpLibro')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
		<?= $form->field($model,'DsTipoLibro')->textInput() ?>
		
	
	<!--?= $form->field($model, 'imageFile')->fileInput() ?--> <!-- Scommentare per fare fileupload -->
	
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		<?php if (!empty($model->TpLibro)) { ?>
			<?= Html::a('Annulla', Yii::$app->request->referrer, ['class' => 'btn btn-secondary']) ?>
        <?php }?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
