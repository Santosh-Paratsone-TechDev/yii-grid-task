<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Claims;
use app\models\ClaimsSearch;
use app\services\Claims\ClaimsService;
use app\services\Grid\GridConfigService;
use app\services\Claims\ClaimsExportService;

class ClaimsController extends Controller {
    private ClaimsService $claimsService;
    private GridConfigService $gridConfigService;
    private ClaimsExportService $exportService;

    public function __construct(
        $id,
        $module,
        ClaimsService $claimsService,
        GridConfigService $gridConfigService,
        ClaimsExportService $exportService,
        $config = []
    ) {
        $this->claimsService = $claimsService;
        $this->gridConfigService = $gridConfigService;
        $this->exportService = $exportService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'config-save' => ['post'],
                    'export' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new ClaimsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $userId = Yii::$app->user->id ?? 1;
        $gridKey = 'claims-main-grid';

        $columnConfig = $this->gridConfigService->getUserGridConfig($userId, $gridKey);
        $columns = $this->claimsService->buildGridColumns($columnConfig);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'gridKey' => $gridKey,
        ]);
    }

    public function actionDetail() {
        $id = Yii::$app->request->post('expandRowKey');

        if (!$id) {
            throw new NotFoundHttpException('Invalid claim id.');
        }

        $model = $this->claimsService->findClaimWithDetails($id);

        if (!$model) {
            throw new NotFoundHttpException('Claim not found.');
        }

        return $this->renderPartial('_detail', [
            'model' => $model,
            'details' => $model->claimDetails,
        ]);
    }

    public function actionConfigGet() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $userId = Yii::$app->user->id ?? 1;
        $gridKey = Yii::$app->request->get('gridKey', 'claims-main-grid');

        $config = $this->gridConfigService->getUserGridConfig($userId, $gridKey);

        return [
            'success' => true,
            'data' => $config,
        ];
    }

    public function actionConfigSave() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $userId = Yii::$app->user->id ?? 1;
        $gridKey = Yii::$app->request->post('gridKey', 'claims-main-grid');
        $columns = Yii::$app->request->post('columns', []);

        $this->gridConfigService->saveUserGridConfig($userId, $gridKey, $columns);

        return [
            'success' => true,
            'message' => 'Configuration saved successfully.',
        ];
    }

    public function actionExport() {
        $searchModel = new ClaimsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        $userId = Yii::$app->user->id ?? 1;
        $gridKey = 'claims-main-grid';
        $columnConfig = $this->gridConfigService->getUserGridConfig($userId, $gridKey);

        return $this->exportService->exportClaims($dataProvider->getModels(), $columnConfig);
    }

    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;
        return $this->renderContent('<h3>Error</h3><p>' . ($exception->getMessage() ?? 'Unknown error') . '</p>');
    }


    public function actionToggleColumn() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;

        $gridKey = Yii::$app->request->post('grid_key');
        $column = Yii::$app->request->post('column_name');
        $isVisible = Yii::$app->request->post('is_visible');

        $model = GridConfiguration::findOne([
            'user_id' => $userId,
            'grid_key' => $gridKey,
            'column_name' => $column
        ]);

        if (!$model) {
            $model = new GridConfiguration();
            $model->user_id = $userId;
            $model->grid_key = $gridKey;
            $model->column_name = $column;
            $model->created_by = $userId;
        }

        $model->is_visible = (int)$isVisible;
        $model->updated_by = $userId;

        if ($model->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'errors' => $model->errors];
    }

    public function getGridConfig($gridKey) {
        return GridConfiguration::find()
            ->where([
                'user_id' => Yii::$app->user->id,
                'grid_key' => $gridKey
            ])
            ->indexBy('column_name')
            ->asArray()
            ->all();
    }
}
