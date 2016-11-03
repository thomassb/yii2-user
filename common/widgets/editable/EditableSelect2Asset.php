<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace common\widgets\editable;

use yii\web\AssetBundle;

/**
 * EditableSelect2Asset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package common\widgets\xeditable
 */
class EditableSelect2Asset extends AssetBundle
{
    public $sourcePath = '@common/widgets/editable/assets/select2';

    public $js = [
        'bootstrap-editable-select2.js'
    ];

    public $depends = [
        'common\widgets\editable\EditableBootstrapAsset',
        'common\widgets\editable\Select2Asset',
    ];
}