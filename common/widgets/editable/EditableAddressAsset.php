<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace common\widgets\editable;

use yii\web\AssetBundle;

/**
 * EditableAddressAsset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package common\widgets\xeditable
 */
class EditableAddressAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/assets/address';

    public $css = [
        'bootstrap-editable-address.css'
    ];

    public $js = [
        'bootstrap-editable-address.js'
    ];

    public $depends = [
        'common\widgets\xeditable\EditableBootstrapAsset'
    ];

}