<?php

namespace app\services\Claims;

use app\models\Claims;
use kartik\grid\ExpandRowColumn;
use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;

class ClaimsService {
    /**
     * Fetch claim with child details
     */
    public function findClaimWithDetails(int $id): ?Claims {
        return Claims::find()
            ->with('claimDetails')
            ->where(['id' => $id])
            ->one();
    }

    /**
     * Build dynamic GridView columns
     */
    public function buildGridColumns(array $config): array {
        $allColumns = [

            // Serial Number
            [
                'class' => 'yii\grid\SerialColumn',
            ],

            // Expand Row
            [
                'class' => ExpandRowColumn::class,

                'header' => '',

                'width' => '50px',

                'value' => function () {
                    return GridView::ROW_COLLAPSED;
                },

                'detailUrl' => ['detail'],

                'expandOneOnly' => true,

                'enableRowClick' => true,
            ],
            [
                'attribute' => 'file_number',
                'label' => 'File Number',
            ],

            [
                'attribute' => 'manager_name',
                'label' => 'Manager Name',
            ],

            [
                'attribute' => 'service_provider_name',
                'label' => 'Service Provider Name',
            ],

            [
                'attribute' => 'claim_number',
                'label' => 'Claim Number',
            ],

            [
                'attribute' => 'assignment_id',
                'label' => 'Assignment ID',
            ],

            [
                'attribute' => 'company_name',
                'label' => 'Company Name',
            ],

            [
                'attribute' => 'invoice_date',

                'format' => ['date', 'php:Y-m-d'],

                'filterType' => GridView::FILTER_DATE_RANGE,

                'filterWidgetOptions' => [
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d',
                            'separator' => ' to '
                        ],
                        'autoUpdateInput' => false
                    ]
                ],
            ],

            [
                'attribute' => 'expenses',
                'label' => 'Expenses',

                'format' => ['currency'],

                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter amount'
                ],
            ],

            [
                'attribute' => 'sale_tax',
                'format' => ['currency'],
                'label' => 'Sale Tax',

                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter amount'
                ],
            ],

            [
                'attribute' => 'payment_amount',
                'format' => ['currency'],
                'label' => 'Payment Amount',

                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter amount'
                ],
            ],

            [
                'attribute' => 'balance_amount',
                'format' => ['currency'],
                'label' => 'Balance Amount',

                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter amount'
                ],
            ],

            [
                'attribute' => 'payment_date',
                'label' => 'Payment Date',

                'format' => ['date', 'php:Y-m-d'],

                'filterType' => GridView::FILTER_DATE_RANGE,

                'filterWidgetOptions' => [
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d',
                            'separator' => ' to '
                        ],
                        'autoUpdateInput' => false
                    ]
                ],
            ],

            [
                'attribute' => 'loss_amount',
                'format' => ['currency'],
                'label' => 'Loss Amount',

                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter amount'
                ],
            ],
        ];

        /**
         * No saved configuration
         */
        if (empty($config)) {
            return $allColumns;
        }

        /**
         * Convert DB config into:
         *
         * [
         *   'file_number' => 1,
         *   'manager_name' => 0
         * ]
         */
        $visibleMap = [];

        foreach ($config as $item) {

            if (
                isset($item['column_name']) &&
                isset($item['is_visible'])
            ) {
                $visibleMap[$item['column_name']] = (int)$item['is_visible'];
            }
        }

        $filteredColumns = [];

        foreach ($allColumns as $column) {

            /**
             * Always keep serial & expand column
             */
            if (
                isset($column['class']) &&
                in_array(
                    $column['class'],
                    [
                        'yii\grid\SerialColumn',
                        ExpandRowColumn::class,
                    ]
                )
            ) {
                $filteredColumns[] = $column;
                continue;
            }

            if (!isset($column['attribute'])) {
                $filteredColumns[] = $column;
                continue;
            }

            $attribute = $column['attribute'];

            if (
                !isset($visibleMap[$attribute]) ||
                $visibleMap[$attribute] === 1
            ) {
                $filteredColumns[] = $column;
            }
        }

        return $filteredColumns;
    }
}
