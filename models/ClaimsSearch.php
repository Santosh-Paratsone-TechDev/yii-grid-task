<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class ClaimsSearch extends Claims {
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [
                [
                    'id',
                    'orig_days_os',
                    'is_deleted',
                    'created_by',
                    'updated_by'
                ],
                'integer'
            ],

            [
                [
                    'file_number',
                    'manager_name',
                    'service_provider_name',
                    'claim_number',
                    'assignment_id',
                    'company_name',
                    'invoice_date',
                    'payment_date',
                    'orig_adjusting_company',
                    'orig_loss_type',
                    'curr_company_name',
                    'created_at',
                    'updated_at',

                    'expenses',
                    'sale_tax',
                    'payment_amount',
                    'balance_amount',
                    'loss_amount',
                    'orig_fee_schedule',
                    'orig_correction',
                    'orig_wyo_payment',
                    'orig_write_off'
                ],
                'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        return Model::scenarios();
    }

    /**
     * Search records
     */
    public function search($params, $formName = null) {
        $query = Claims::find()
            ->where(['is_deleted' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            'pagination' => [
                'pageSize' => 20,
            ],

            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        /**
         * Exact Match Fields
         */
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        /**
         * Invoice Date Filter
         * Supports:
         * 2025-06-01
         * 2025-06-01 to 2025-06-30
         */
        if (!empty($this->invoice_date)) {

            if (strpos($this->invoice_date, ' to ') !== false) {

                [$from, $to] = explode(' to ', $this->invoice_date);

                $query->andWhere([
                    'between',
                    'invoice_date',
                    trim($from),
                    trim($to),
                ]);
            } else {

                $query->andWhere([
                    'invoice_date' => trim($this->invoice_date),
                ]);
            }
        }

        /**
         * Payment Date Filter
         * Supports:
         * 2025-06-01
         * 2025-06-01 to 2025-06-30
         */
        if (!empty($this->payment_date)) {

            if (strpos($this->payment_date, ' to ') !== false) {

                [$from, $to] = explode(' to ', $this->payment_date);

                $query->andWhere([
                    'between',
                    'payment_date',
                    trim($from),
                    trim($to),
                ]);
            } else {

                $query->andWhere([
                    'payment_date' => trim($this->payment_date),
                ]);
            }
        }

        /**
         * Text Search Filters
         */
        $query->andFilterWhere([
            'like',
            'file_number',
            $this->file_number
        ]);

        $query->andFilterWhere([
            'like',
            'claim_number',
            $this->claim_number
        ]);

        $query->andFilterWhere([
            'like',
            'assignment_id',
            $this->assignment_id
        ]);

        $query->andFilterWhere([
            'like',
            'manager_name',
            $this->manager_name
        ]);

        $query->andFilterWhere([
            'like',
            'service_provider_name',
            $this->service_provider_name
        ]);

        $query->andFilterWhere([
            'like',
            'company_name',
            $this->company_name
        ]);

        $query->andFilterWhere([
            'like',
            'orig_adjusting_company',
            $this->orig_adjusting_company
        ]);

        $query->andFilterWhere([
            'like',
            'orig_loss_type',
            $this->orig_loss_type
        ]);

        $query->andFilterWhere([
            'like',
            'curr_company_name',
            $this->curr_company_name
        ]);

        /**
         * Amount Filters
         * Examples:
         * 80 => matches 80, 080, 800, 180.50, 808.99
         */
        if (!empty($this->expenses)) {
            $query->andWhere(
                new Expression(
                    "CAST(expenses AS CHAR) LIKE :expenses"
                ),
                [
                    ':expenses' => $this->expenses . '%'
                ]
            );
        }
        if (!empty($this->sale_tax)) {
            $query->andWhere(
                new Expression(
                    "CAST(sale_tax AS CHAR) LIKE :sale_tax"
                ),
                [
                    ':sale_tax' => $this->sale_tax . '%'
                ]
            );
        }

        if (!empty($this->payment_amount)) {
            $query->andWhere(
                new Expression(
                    "CAST(payment_amount AS CHAR) LIKE :payment_amount"
                ),
                [
                    ':payment_amount' => $this->payment_amount . '%'
                ]
            );
        }

        if (!empty($this->balance_amount)) {
            $query->andWhere(
                new Expression(
                    "CAST(balance_amount AS CHAR) LIKE :balance_amount"
                ),
                [
                    ':balance_amount' => $this->balance_amount . '%'
                ]
            );
        }

        if (!empty($this->loss_amount)) {
            $query->andWhere(
                new Expression(
                    "CAST(loss_amount AS CHAR) LIKE :loss_amount"
                ),
                [
                    ':loss_amount' => $this->loss_amount . '%'
                ]
            );
        }
        return $dataProvider;
    }
}
