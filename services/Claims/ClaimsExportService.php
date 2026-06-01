<?php

namespace app\services\Claims;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;

class ClaimsExportService {
    public function exportClaims(array $models, array $columnConfig): Response {
        $filename = 'claims_export_' . date('Ymd_His') . '.csv';

        $headers = [];
        $visibleCols = [];

        foreach ($columnConfig as $cfg) {
            if ((int)($cfg['is_visible'] ?? 0) === 1) {
                $visibleCols[] = $cfg['column_name'];
                $headers[] = $cfg['display_name'] ?: $cfg['column_name'];
            }
        }

        if (empty($visibleCols)) {
            $visibleCols = [
                'file_number',
                'manager_name',
                'service_provider_name',
                'claim_number',
                'assignment_id',
                'company_name',
                'invoice_date',
                'expenses',
                'sale_tax',
                'payment_amount',
                'balance_amount',
                'payment_date',
                'loss_amount',
                'orig_fee_schedule',
                'orig_correction',
                'orig_wyo_payment',
                'orig_write_off',
                'orig_adjusting_company',
                'orig_days_os',
                'orig_loss_type',
                'curr_company_name',
            ];

            // Human readable headers
            $headers = [
                'File Number',
                'Manager Name',
                'Service Provider Name',
                'Claim Number',
                'Assignment ID',
                'Company Name',
                'Invoice Date',
                'Expenses',
                'Sale Tax',
                'Payment Amount',
                'Balance Amount',
                'Payment Date',
                'Loss Amount',
                'Orig Fee Schedule',
                'Orig Correction',
                'Orig WYO Payment',
                'Orig Write Off',
                'Orig Adjusting Company',
                'Orig Days OS',
                'Orig Loss Type',
                'Current Company Name',
            ];
        }

        $fp = fopen('php://temp', 'r+');

        // Headers
        fputcsv($fp, $headers);

        foreach ($models as $model) {
            $row = [];

            foreach ($visibleCols as $attr) {

                $value = '';

                // 1. direct attribute
                if (is_object($model) && $model->hasAttribute($attr)) {
                    $value = $model->$attr;
                }
                // 2. array data (if query used as array)
                elseif (is_array($model)) {
                    $value = ArrayHelper::getValue($model, $attr, '');
                }
                // 3. getter method fallback (getSomething())
                elseif (is_object($model) && method_exists($model, 'get' . ucfirst($attr))) {
                    $method = 'get' . ucfirst($attr);
                    $value = $model->$method();
                }

                // normalize output
                if (is_array($value)) {
                    $value = json_encode($value);
                } elseif (is_object($value)) {
                    $value = (string)$value;
                }

                $row[] = $value;
            }

            fputcsv($fp, $row);
        }

        rewind($fp);
        $content = stream_get_contents($fp);
        fclose($fp);

        // Excel UTF-8 fix
        $content = "\xEF\xBB\xBF" . $content;

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        $response->content = $content;

        return $response;
    }
}
