<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Claims Management';
?>

<div class="claims-index">

    <div class="d-flex justify-content-between mb-3">
        <h3><?= Html::encode($this->title) ?></h3>

        <div>

            <?= Html::button('Configure Columns', [
                'class' => 'btn btn-secondary',
                'id' => 'btn-configure-columns',
                'data-grid-key' => $gridKey
            ]) ?>

            <?= Html::button(
                'Reset Filters',
                [
                    'class' => 'btn btn-warning',
                    'id' => 'btn-reset-filters'
                ]
            ) ?>

            <?= Html::button(
                'Export Excel',
                [
                    'class' => 'btn btn-success',
                    'id' => 'btn-export-excel'
                ]
            ) ?>

        </div>
    </div>
    <?= GridView::widget([
        'id' => 'claims-grid',

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,

        'responsive' => true,
        'hover' => true,

        'pjax' => true,

        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'id' => 'claims-grid-pjax',
            ],
        ],

        'filterOnFocusOut' => true,

        'toolbar' => false,

        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Claims List',
        ],
    ]);
    ?>

</div>

<?= $this->render('_config_modal', ['gridKey' => $gridKey]) ?>

<?php
$this->registerJsFile('@web/js/claims.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>