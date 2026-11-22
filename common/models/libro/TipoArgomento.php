<?php
namespace common\models\libro;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "TipoArgomento".
 *

 * @property int	$TpArgomento,

 * @property string|null	$DsArgomento,

 */

class TipoArgomento extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['TpArgomento'];
	public $datetime_columns = [];
	public $auto_increment_cols = ['TpArgomento' ];
	
	public static function tableName()
    {
        return 'TipoArgomento';
    }
	
    public function rules()
    {
        return [
			[['TpArgomento'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[['DsArgomento'],'string','max' => 200],
			[[], 'safe'],
			//['DtFineTess', 'compare', 'compareAttribute' => 'DtInizioTess', 'operator' => '>=','enableClientValidation'=>false],
			//[['CdRuolo','IdSocieta','IdSoggetto','DtInizioTess'], 'required'],

        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'TpArgomento' => 'Tp Argomento',
	
			'DsArgomento' => 'Ds Argomento',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }	


    /**
     * Gets query for [[Collana]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollana()
    {
        return $this->hasMany(\common\models\libro\Collana::class,  ['' => '']);
    }    

    /**
     * Gets query for [[TipoTag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipotag()
    {
        return $this->hasMany(\common\models\libro\TipoTag::class,  ['' => '']);
    }    



    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ( !$insert) 
            return true;
        
        // Aggiungo anche il gruppo per questo utente
        //$zutgr = new zutgr();
        //$zutgr->id = $this->id;
        //$zutgr->idgruppo = 1;
        
        //if ( $zutgr->save())
        //    return true;
        //return false;
		return true;
    }

}

