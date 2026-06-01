<?php

use yii\helpers\Html;

/** @var $gridKey string */
?>

<div class="modal fade" id="columnConfigModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Grid Configuration</h5>
            </div>

            <div class="modal-body">
                <div id="config-loader" class="text-center py-4 d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-2">Loading configuration...</div>
                </div>

                <div id="config-container"></div>
            </div>

            <div class="modal-footer">
                <?= Html::button('Save Configuration', [
                    'class' => 'btn btn-primary',
                    'id' => 'btn-save-config',
                    'data-grid-key' => $gridKey
                ]) ?>
                <button
                    type="button"
                    class="btn btn-secondary"
                    id="btn-close-config-modal"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>