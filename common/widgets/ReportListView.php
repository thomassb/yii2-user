<?php

namespace common\widgets;

//use Yii;
//use yii\helpers\ArrayHelper;
//use yii\helpers\Html;

/**
 * Description of ReportListView
 *
 * @author Thomas
 */
class ReportListView extends \yii\widgets\ListView {

    public function renderItem($model, $key, $index) {
        if ($this->itemView === null) {
            $content = $key;
        } elseif (is_string($this->itemView)) {
            $content = $this->getView()->render($this->itemView, array_merge([
                'model' => $model,
                'key' => $key,
                'index' => $index,
                'widget' => $this,
                            ], $this->viewParams));
        } else {
            $content = call_user_func($this->itemView, $model, $key, $index, $this);
        }
        //$options = $this->itemOptions;
       // $tag = ArrayHelper::remove($options, 'tag', 'div');
        //   $options['data-key'] = is_array($key) ? json_encode($key, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : (string) $key;
        return $content;
        // return Html::tag($tag, $content, $options);
    }

}
