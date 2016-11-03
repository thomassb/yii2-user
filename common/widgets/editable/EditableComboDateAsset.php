<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace common\widgets\editable;

use yii\web\AssetBundle;

class EditableComboDateAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/editable/assets/combodate';

    public $js = [
        'vendor/moment-with-langs.min.js',
        'vendor/combodate.js',
        'bootstrap-editable-combodate.js'
    ];

    public $depends = [
        'common\widgets\editable\EditableBootstrapAsset'
    ];
}