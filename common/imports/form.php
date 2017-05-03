<?php

namespace common\imports;

use Yii;

/**
 * This is the model class for table "Keystages".
 *
 * @property integer $ID
 * @property string $KeyStage
 *
 * @property KeyStageYearGroups[] $keyStageYearGroups
 */
class form extends \yii\base\Model
{
public $files,$doimport;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             ["doimport", "string"],
            [['files'],'safe'],
             [['files'], 'file', 'extensions' => 'txt', 'mimeTypes' => 'text/plain', 'maxFiles' => 12, 'skipOnEmpty' => true],
       
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'files' => 'Upload Files',
          'doimport'=>'Start the import'
        ];
    }

   
}
