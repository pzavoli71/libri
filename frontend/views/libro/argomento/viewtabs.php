
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
/** @var common\models\libro\Argomento $model */

$this->title = $model->IdArgomento;
$this->params['model'] = $model;
//$this->params['breadcrumbs'][] = ['label' => 'Obiettivos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php
    $hrefpage = "";
    if (empty($nomerelaz)) {
        creaForm($this, $model, $combo, $parametri);
        $hrefpage = "";
    }
    else {
        $rigapos = 1;
        $models = $dataProvider->getModels();
        $model = $models[0];
				
        if ($nomerelaz == "Argomento_LibroTag") {
            RelazioneArgomento_LibroTag($model, true);
		}
		
		resizeAll();
    }    
?>

<?php function resizeAll() {?>
<script language="javascript" id="scripttimeout">
    setTimeout(function() {AppGlob.resize2(window); $('#scripttimeout').remove();},300);
</script>
<?php }?>


<?php function creaForm($thisobj, $model, $combo, $parametri) {?>

<?php $thisobj->registerJsFile(
'@web/js/formtabs.js',
[]
);

$thisobj->registerJs(
"//AppGlob.registraFunzioniPerListe(null, apriRigaRelazioni);AppGlob.inizializzaLista();\n"
        . "cistabs.enableTab('cis-tabgen');	",
View::POS_READY, 
//'resize-page-script'
);
?>

<script type="text/javascript">

var ajaxrequest = null;
// Apre il menu contestuale in corrispondenza della riga
function caricaRelazione(obj) { 
	// Devo andare a ritroso nel dom fino a trovare un div con class="divRelazione"
	var odivRelaz = AppGlob.trovaDivRelazione(obj);
	if ( odivRelaz == null)
		return;

	var nomepdc = odivRelaz.attr("nomepdc");
	var nomerelazione = odivRelaz.attr("nomerelaz");
	var chiave = odivRelaz.attr("chiave");
    
	var dati = {};
	var spezzanome = nomepdc.split('.');
	var nome = spezzanome[spezzanome.length - 1];           
	var chiavi = chiave.split('_'); 
    
	if(odivRelaz.find('.rowsPerPage')) {
		dati['rpp']=odivRelaz.find('.rowsPerPage').val();
	}
	if(odivRelaz.find('.currPage')) {
		if($(obj).hasClass('nextPage')) {
			dati['page']=parseInt(odivRelaz.find('.currPage').val())+1;
		}
		else if($(obj).hasClass('prevPage')) {
			dati['page']=parseInt(odivRelaz.find('.currPage').val())-1;
		}
		else {
			dati['page']=odivRelaz.find('.currPage').val();
		}
	}
	if ( nome == 'libro\\Argomento') {
		dati['IdArgomento'] = chiavi[0];
	} else if (nome == 'Tomo') {
		dati['IdLibro'] = chiavi[0];

	}
	<?php $currentcontroller = Yii::$app->controller->id; ?>
	
	AppGlob.reloadRelazione('<?= Url::toRoute($currentcontroller . "/reloadrelazione")?>',nomepdc,nomerelazione,dati,odivRelaz, function(dati, data) {
		AppGlob.inizializzaLista();
    }, true);
}

function richiestaComandoConDialog(nomecomando, chiave, dati, href,callback,startcomando) {
	// Qui posso variare il contenuto dell'area dati, aggiungendo attributi con nome e valore
	// che verranno riportati alla servlet come parametri.
	var chiavi = chiave.split('_');
	dati.IdDocumento=chiavi[0];
	$('#dialog').dialog({
		autoOpen: true,
		modal:true,
		title:'Inserisci i parametri e premi ok',
		position:{ my: 'top', at: 'top+150' },
		width:600,
		show: {
        	effect: "blind",
        	duration: 100
      	},
      	hide: {
        	effect: "explode",
        	duration: 400
      	},	
		buttons: {
        	Ok: function() {
				var NoteCompl = $( this ).find('#NoteCompl').val();
				//var anno = $( this ).find('#AnnoCompl').val();
				//var mese = $( this ).find('#MeseCompl').val();
				dati.NotaLavoro = NoteCompl;
                                dati.IdLavoro = chiave;
				//dati.AnnoCompl=anno;
				//dati.MeseCompl=mese;
                                debugger;
				startcomando(nomecomando,chiave, dati, callback);
          		$( this ).dialog( "close" );	
        	},
        	Annulla: function() {
          		$( this ).dialog( "close" );
        	}
      	}      	
        });	
	return true;
}

function richiestaComando(nomecomando, chiave, dati) {
	// Qui posso variare il contenuto dell'area dati, aggiungendo attributi con nome e valore
	// che verranno riportati alla servlet come parametri.
	var valore = prompt('inserisci il comando per ',chiave);
	//if ( nomecomando == 'busy/obiettivo/chiudilavoro') {
	//	dati.IdLavoro = chiave;
	//}	
	dati.Cognome='xxxxx';
	return true;
}

// Funzione che gestisce il ritorno del comando
function comandoTerminato(nomecomando, chiave, data, href, callback) {
	function terminaComando() {
		if ( nomecomando == 'busy/obiettivo/chiudilavoro') {
			var id = nomecomando.replace(/\//g,'_');
			id += '_' + chiave;                    
			$a = $('#' + id);
			//caricaRelazione($a);
		}                        
	}
	if ( data && data.error) {
		var errore = data.error;
		AppGlob.emettiErrore(errore, function() {
			terminaComando();
		});
	} else {
		terminaComando();
	}
}
</script>


<style>
.cis-field-container label {
	width:150px;
}
/*.cis-field-container .ValoreAttributo {
	width:350px;
}*/
.screen-s .cis-field-container, .screen-m .cis-field-container {
	display:inline-block;
}	
</style>

<div class="cis-tab-gen" id="cis-tabgen">
	<div class="cis-tab-linguette">
			<a class="active cis-tab-a" href="javascript:void(0)" data-name="DatiGenerali">Dati generali</a>
		
			<a class="cis-tab-a" href="javascript:void(0)" data-name="Tomo">Tomo</a>
			
			<a class="cis-tab-a" href="javascript:void(0)" data-name="LibroTag">LibroTag</a>
			
	</div>

	<div class="cis-container-tabs">
        <div id="TabDatiGenerali" class="cis-tab-blocco active">
		<div class="argomento-view">

			<h1><?= Html::encode($thisobj->title) ?></h1>

			<p>
				<?= Html::a('Update', ['update', 'IdArgomento'=>$model->IdArgomento], ['class' => 'btn btn-primary']) ?>
				<?= Html::a('Delete', ['delete', 'IdArgomento'=>$model->IdArgomento], [
					'class' => 'btn btn-danger',
					'data' => [
						'confirm' => 'Are you sure you want to delete this item?',
						'method' => 'post',
					],
				]) ?>
				<?= Html::a('Insert', ['create'], ['class' => 'btn btn-insert']) ?>
			</p>

			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
				'IdArgomento','TitoloArgomento','DescArgomento','Pagina','NotaArgomento','IdLibro',
					'ultagg',
					'utente',
				],
			]) ?>

			
		</div> 

		</div> 		
		<div id="TabLibroTag" class="cis-tab-blocco noactive">
    <div id="divRel_Argomento_LibroTag" class="divRelazione" chiave="<?=$model->IdArgomento?>" nomepdc="libro\Argomento" nomerelaz="Argomento_LibroTag">
		<div class="titolorelaz"><a class="refresh_btn cis-button btn_riga" href="javascript:void(0)" onclick="caricaRelazione(this)">
			<i class="fa fa-sync"></i>
		</a>
		<?php echo frontend\controllers\BaseController::linkwin('Aggiungi un LibroTag|fa-plus', 'libro/librotag/create', [], 'Apri per inserimento','caricaRelazione(this.atag)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
		&#xA0;
		<span class="titolo1">Relazione LibroTag</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<?php RelazioneArgomento_LibroTag($model) ?>
		</div>
		</div>
		

	</div> 

</div> 
<?php }?> 

<?php function showToggleInrelations($model, $pos, $ramochiuso) { ?>
    <a pos="<?=$pos?>" href="javascript:void(0)" style="margin-left:1px; margin-right:5px" onclick="AppGlob.apriRigaRelazioni(this, '<?= str_replace("\\",".",get_class($model))?>')" >
        <i class="far <?php if ($ramochiuso == false) echo('fa-minus-square'); else  echo('fa-plus-square');?>">
        </i>        
    </a>
<?php } ?>


			
<?php 
function RelazioneArgomento_LibroTag($riga, $loadable = false) { ?>
	<div class="divLista">
	<!--xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template> -->
	<table border="0" cellpadding="2" cellspacing="0" class="tabLista" id="tabListaArgomento_LibroTag" nomepdc="Argomento">
		<?= IntestaTabellaLibroTag()?>
		<?php if ( $loadable) {
			$pos = 1;
			foreach ($riga->librotag as $value) {
				RecordLibroTag($value, $pos);
				$pos++;
			}
		}
		?>		
	</table>
	</div>
<?php } ?>	
		

<?php 
function IntestaTabellaTomo() { ?>
<tr>
<th style="min-width:180px"></th>

     <th data-nomecol="IdLibro" >IdLibro</th>

     <th data-nomecol="TitoloLibro" >TitoloLibro</th>

     <th data-nomecol="DescLibro" >DescLibro</th>

     <th data-nomecol="AnnoLibro" >AnnoLibro</th>

     <th data-nomecol="MeseLibro" >MeseLibro</th>

     <th data-nomecol="NumeroRivista" >NumeroRivista</th>

     <th data-nomecol="NumeroVolume" >NumeroVolume</th>

     <th data-nomecol="IdCollana" >IdCollana</th>

     <th data-nomecol="TpLibro" >TpLibro</th>

</tr>
<?php } ?>	


<!-- ============================================ -->
<!--    Righe tabella                             -->
<!-- ============================================ -->
<?php 
function RecordTomo($rigarel, $pos) { ?>

   <tr id='RigaTomo_<?=$pos?>' chiave='<?=$rigarel->IdLibro?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigaPari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'libro/tomo/view', ['IdLibro'=>$rigarel->IdLibro], 'Apri per modifica','caricaRelazione(this.atag)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
		</td>

		<td><span class="headcol">IdLibro:</span><?=$rigarel->IdLibro?></td>

		<td><span class="headcol">TitoloLibro:</span><?=$rigarel->TitoloLibro?></td>

		<td><span class="headcol">DescLibro:</span><?=$rigarel->DescLibro?></td>

		<td><span class="headcol">AnnoLibro:</span><?=$rigarel->AnnoLibro?></td>

		<td><span class="headcol">MeseLibro:</span><?=$rigarel->MeseLibro?></td>

		<td><span class="headcol">NumeroRivista:</span><?=$rigarel->NumeroRivista?></td>

		<td><span class="headcol">NumeroVolume:</span><?=$rigarel->NumeroVolume?></td>

		<td><span class="headcol">IdCollana:</span><?=$rigarel->IdCollana?><?=$rigarel->collana->nome ?></td>

		<td><span class="headcol">TpLibro:</span><?=$rigarel->TpLibro?><?=$rigarel->tipolibro->nome ?></td>

		<!--td-->
		
		<!--/td-->
		</tr >

	<!-- RelazioniTomo($rigarel,$pos)-->
<?php } ?>	

		

<?php 
function IntestaTabellaLibroTag() { ?>
<tr>
<th style="min-width:180px"></th>

     <th data-nomecol="IdLibrotag" >IdLibrotag</th>

     <th data-nomecol="IdTags" >IdTags</th>

     <th data-nomecol="IdLibro" >IdLibro</th>

     <th data-nomecol="IdArgomento" >IdArgomento</th>

</tr>
<?php } ?>	


<!-- ============================================ -->
<!--    Righe tabella                             -->
<!-- ============================================ -->
<?php 
function RecordLibroTag($rigarel, $pos) { ?>

   <tr id='RigaLibroTag_<?=$pos?>' chiave='<?=$rigarel->IdLibrotag?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigaPari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'libro/librotag/view', ['IdLibrotag'=>$rigarel->IdLibrotag], 'Apri per modifica','caricaRelazione(this.atag)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
		</td>

		<td><span class="headcol">IdLibrotag:</span><?=$rigarel->IdLibrotag?></td>

		<td><span class="headcol">IdTags:</span><?=$rigarel->IdTags?><?=$rigarel->tags->nome ?></td>

		<td><span class="headcol">IdLibro:</span><?=$rigarel->IdLibro?><?=$rigarel->tomo->nome ?></td>

		<td><span class="headcol">IdArgomento:</span><?=$rigarel->IdArgomento?><?=$rigarel->argomento->nome ?></td>

		<!--td-->
		
		<!--/td-->
		</tr >

	<!-- RelazioniLibroTag($rigarel,$pos)-->
<?php } ?>	

