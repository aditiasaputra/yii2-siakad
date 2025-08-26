<?php

namespace backend\controllers;

use Yii;
use backend\models\Faculty;
use backend\models\FacultySearch;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * FacultyController implements the CRUD actions for Faculty model.
 */
class FacultyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'bulk-delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Faculty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FacultySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Faculty model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionShow($id)
    {
        // dd($this->findModel($id)->unit_code);
        return $this->render('show', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Faculty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Faculty();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Fakultas berhasil ditambahkan.');
            return $this->redirect(['show', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Faculty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Fakultas berhasil diperbarui.');
            return $this->redirect(['show', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Faculty model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Fakultas berhasil dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus fakultas.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Bulk delete action
     */
    public function actionBulkDelete()
    {
        $ids = Yii::$app->request->post('ids');
        
        if (!empty($ids)) {
            $deleted = Faculty::deleteAll(['id' => $ids]);
            Yii::$app->session->setFlash('success', "Berhasil menghapus $deleted fakultas.");
        } else {
            Yii::$app->session->setFlash('warning', 'Tidak ada fakultas yang dipilih untuk dihapus.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Toggle status action
     */
    public function actionToggleStatus($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = $this->findModel($id);
        $model->is_active = !$model->is_active;
        
        if ($model->save()) {
            return [
                'success' => true,
                'message' => 'Status berhasil diubah.',
                'newStatus' => $model->is_active,
                'statusLabel' => $model->getStatusLabel(),
                'statusBadge' => $model->getStatusBadge(),
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Gagal mengubah status.',
            ];
        }
    }

    /**
     * Export to Excel
     */
    public function actionExport()
    {
        $searchModel = new FacultySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false; // Export all data

        return $this->render('export', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Faculty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Faculty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faculty::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}