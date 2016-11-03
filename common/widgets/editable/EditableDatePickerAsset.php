<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace common\widgets\editable;

use yii\web\AssetBundle;

/**
 * EditableDatePickerAsset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package common\widgets\editable
 */
class EditableDatePickerAsset extends AssetBundle
{
  //  public $sourcePath = '@common/widgets/editable/assets/datepicker';
     public function init()
    {
        $this->sourcePath = __DIR__ . '/assets/datepicker';
        parent::init();
    }

    public $css = [
        'vendor/css/datepicker3.css'
    ];

    public $js = [
        'vendor/js/bootstrap-datepicker.js',
        'bootstrap-editable-datepicker.js'
    ];

    public $depends = [
        'common\widgets\editable\EditableBootstrapAsset'
    ];

}