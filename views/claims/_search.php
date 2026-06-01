<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ClaimsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="claims-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'file_number') ?>

    <?= $form->field($model, 'manager_name') ?>

    <?= $form->field($model, 'service_provider_name') ?>

    <?= $form->field($model, 'claim_number') ?>

    <?php // echo $form->field($model, 'assignment_id') ?>

    <?php // echo $form->field($model, 'company_name') ?>

    <?php // echo $form->field($model, 'invoice_date') ?>

    <?php // echo $form->field($model, 'expenses') ?>

    <?php // echo $form->field($model, 'sale_tax') ?>

    <?php // echo $form->field($model, 'payment_amount') ?>

    <?php // echo $form->field($model, 'balance_amount') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <?php // echo $form->field($model, 'loss_amount') ?>

    <?php // echo $form->field($model, 'orig_fee_schedule') ?>

    <?php // echo $form->field($model, 'orig_correction') ?>

    <?php // echo $form->field($model, 'orig_wyo_payment') ?>

    <?php // echo $form->field($model, 'orig_write_off') ?>

    <?php // echo $form->field($model, 'orig_adjusting_company') ?>

    <?php // echo $form->field($model, 'orig_days_os') ?>

    <?php // echo $form->field($model, 'orig_loss_type') ?>

    <?php // echo $form->field($model, 'curr_company_name') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
