<?php
namespace common\models\libro;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "TipoLibro".
 *

 * @property int	$TpLibro,

 * @property string|null	$DsTipoLibro,

 */

class TipoLibro extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['TpLibro'];
	public $datetime_columns = [];
	public $auto_increment_cols = ['TpLibro' ];
	
	public static function tableName()
    {
        return 'TipoLibro';
    }
	
    public function rules()
    {
        return [
			[['TpLibro'], 'integer'],
			[['DsTipoLibro'],'string','max' => 50],
			[[''], 'safe'],
			//['DtFineTess', 'compare', 'compareAttribute' => 'DtInizioTess', 'operator' => '>=','enableClientValidation'=>false],
			//[['CdRuolo','IdSocieta','IdSoggetto','DtInizioTess'], 'required'],

        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'TpLibro' => 'Tp Libro',
	
			'DsTipoLibro' => 'Ds TipoLibro',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }	


    /**
     * Gets query for [[Libro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasMany(\common\models\libro\Libro::class,  ['' => '']);
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

