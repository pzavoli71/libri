<?php
namespace common\models\libro;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "Collana".
 *

 * @property int	$IdCollana,

 * @property string|null	$DsCollana,

 * @property int	$TpArgomento,

 */

class Collana extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['IdCollana','TpArgomento'];
	public $datetime_columns = [];
	public $auto_increment_cols = [ ];
	
	public static function tableName()
    {
        return 'Collana';
    }
	
    public function rules()
    {
        return [
			[['IdCollana','TpArgomento'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[['DsCollana'],'string','max' => 500],
			[[], 'safe'],
			//['DtFineTess', 'compare', 'compareAttribute' => 'DtInizioTess', 'operator' => '>=','enableClientValidation'=>false],
			//[['CdRuolo','IdSocieta','IdSoggetto','DtInizioTess'], 'required'],

        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'IdCollana' => 'Id Collana',
	
			'DsCollana' => 'Ds Collana',
	
			'TpArgomento' => 'Tp Argomento',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }	


    /**
     * Gets query for [[Tomo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTomo()
    {
        return $this->hasMany(\common\models\libro\Tomo::class,  ['IdCollana' => 'IdCollana']);
    }    

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasMany(\common\models\libro\Tag::class,  ['IdCollana' => 'IdCollana']);
    }    

    /**
     * Gets query for [[TipoArgomento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoargomento()
    {
        return $this->hasOne(\common\models\libro\TipoArgomento::class,  ['TpArgomento' => 'TpArgomento',]);
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

