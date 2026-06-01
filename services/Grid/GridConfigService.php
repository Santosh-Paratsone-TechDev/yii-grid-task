<?php

namespace app\services\Grid;

use app\models\GridConfigurations;

class GridConfigService {
    private function getDefaultColumns(): array {
        return [
            [
                'column_name' => 'file_number',
                'display_name' => 'File Number',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'manager_name',
                'display_name' => 'Manager Name',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'service_provider_name',
                'display_name' => 'Service Provider Name',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'claim_number',
                'display_name' => 'Claim Number',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'assignment_id',
                'display_name' => 'Assignment ID',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'company_name',
                'display_name' => 'Company Name',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'invoice_date',
                'display_name' => 'Invoice Date',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'expenses',
                'display_name' => 'Expenses',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'sale_tax',
                'display_name' => 'Sale Tax',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'payment_amount',
                'display_name' => 'Payment Amount',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'balance_amount',
                'display_name' => 'Balance Amount',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'payment_date',
                'display_name' => 'Payment Date',
                'is_visible' => 1,
            ],
            [
                'column_name' => 'loss_amount',
                'display_name' => 'Loss Amount',
                'is_visible' => 1,
            ],
        ];
    }

    public function getUserGridConfig(int $userId, string $gridKey): array {
        $rows = GridConfigurations::find()
            ->where([
                'user_id' => $userId,
                'grid_key' => $gridKey
            ])
            ->asArray()
            ->all();

        return empty($rows)
            ? $this->getDefaultColumns()
            : $rows;
    }

    public function saveUserGridConfig(
        int $userId,
        string $gridKey,
        array $columns
    ): void {

        GridConfigurations::deleteAll([
            'user_id' => $userId,
            'grid_key' => $gridKey
        ]);

        foreach ($columns as $col) {

            $model = new GridConfigurations();

            $model->user_id = $userId;
            $model->grid_key = $gridKey;
            $model->column_name = $col['column_name'];
            $model->display_name = $col['display_name'] ?? null;
            $model->is_visible = (int)($col['is_visible'] ?? 1);

            if (!$model->save()) {
                throw new \RuntimeException(
                    json_encode($model->errors)
                );
            }
        }
    }
}
