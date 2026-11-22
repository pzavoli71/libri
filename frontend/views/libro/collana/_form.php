
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use pzavoli71\widgets\AutocompleteDropdown;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\libro\Collana $model */
/** @var yii\widgets\ActiveForm $form */

?>

<?php $this->params['breadcrumbs'][] = $this->title; 
$this->params['home'] = Url::to(['/libro/collana/view','IdCollana'=>$model->IdCollana]);  ?>

<div class="collana-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'IdCollana')->hiddenInput()->label(false); ?>	
		
		<?= $form->field($model,'DsCollana')->textInput() ?>
		
	<?= $form->field($model,'TpArgomento')->dropDownList(
			$combo['TipoArgomento'],           // Flat array ('id'=>'label')
			[
				'prompt' => Yii::t('app','scegli argomento')
				//, Questo comando serve a caricare dinamicamente un secondo combo a partire dai valori del primo
				//'onchange'=>'
				//	href = "' . Yii::$app->urlManager->createUrl(["busy/obiettivo/reloadcombo","nomecombo"=>"TpOccup"]) . '";' .
				//	'href += "&params={\"IdArg\":\"" + $(this).val() + "\"}";' .
				//	'href += "&currcombovalue=" + $( "select#obiettivo-tpoccup" ).val();' .
				//	'$.get(href, function(data) {' .
				//	'$( "select#obiettivo-tpoccup" ).html( data ).focus()' .
				//	'})'*/
			]                
	); ?>
	

	
	<!--?= $form->field($model, 'imageFile')->fileInput() ?--> <!-- Scommentare per fare fileupload -->
	
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		<?php if (!empty($model->IdCollana)) { ?>
			<?= Html::a('Annulla', Yii::$app->request->referrer, ['class' => 'btn btn-secondary']) ?>
        <?php }?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
