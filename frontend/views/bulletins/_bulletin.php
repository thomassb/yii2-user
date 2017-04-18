<?php

use yii\helpers\Html;
?>

<li class="time-label">
    <span class="bg-red">
        <?= $model->NiceDate ?>
    </span>
</li>

<li>
    <i class="fa fa-envelope bg-blue"></i>

    <div class="timeline-item">
        <span class="time"><i class="fa fa-clock-o"></i> <?= $model->NiceTime ?></span>

        <h3 class="timeline-header"><a href="#"><?= $model->LimtedTitle ?></a></h3>

        <div class="timeline-body">
            <?= $model->LimtedBody ?>
        </div>
        <div class="timeline-footer">
            <?=
            $model->readMore === true ?
                    Html::a('Read More', ['bulletins/view', 'id' => $model->id], [ 'class' => 'btn btn-primary btn-xs']
                    ) : '';
            ?><?php
            if (Yii::$app->user->can("bulletins")) {
                echo ' ';
                echo Html::a('Edit', ['bulletins/update', 'id' => $model->id], [ 'class' => 'btn btn-success btn-xs']);
                echo ' ' . Html::a('Delete', ['bulletins/delete', 'id' => $model->id], [ 'class' => 'btn btn-danger btn-xs', 'data-confirm' => 'Are You sure', 'data-method' => 'post']);
            }
            ?>
        </div>
    </div>
</li>



