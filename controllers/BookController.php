<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\models\BookCategory;
use app\models\Publisher;
use app\models\Writer;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    'Origin' => Yii::$app->params['allowed_domains'],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['POST'],
                    'update' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $books      = Book::getAllBooks();
        $categories = ArrayHelper::map(BookCategory::getAllBookCategories(), 'value', 'label');
        $publishers = ArrayHelper::map(Publisher::getAllPublishers(), 'value', 'label');
        $writers    = ArrayHelper::map(Writer::getAllWriters(), 'value', 'label');

        return json_encode(array_merge([
            'books'      => $books,
            'categories' => $categories,
            'publishers' => $publishers,
            'writers'    => $writers,
        ]));
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $book      = $this->findModel($id);
        $category  = $book->category;
        $publisher = $book->publisher;
        $writer    = $book->writer;

        return json_encode(array_merge([
            'book'       => ArrayHelper::toArray($book),
            'categories' => ArrayHelper::toArray($category),
            'publishers' => ArrayHelper::toArray($publisher),
            'writers'    => ArrayHelper::toArray($writer),
        ]));
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        $response['status'] = 'failed';
        $post['Book'] = Yii::$app->request->post();

        if ($model->load($post) && $model->uploadImage() && $model->save()) {
            $response['status'] = 'success';
            $response['id']     = $model->id;
        }

        return json_encode($response);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $response['status'] = 'failed';
        $post['Book'] = Yii::$app->request->post();

        if ($_FILES) {
            $response['delete_old_image'] = $model->deleteImage();
            $model->load($post);
            $response['upload_new_image'] = $model->uploadImage();
        } else {
            $model->load($post);
        }

        if ($model->save()) {
            $response['status'] = 'success';
            $response['id']     = $model->id;
        }

        return json_encode($response);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $book_id = json_decode(file_get_contents("php://input"), true);

        $model = $this->findModel($book_id);
        $response['delete_old_image'] = $model->deleteImage();
        $model->delete();
        $response['status'] = 'success';

        return json_encode($response);
    }

    public function actionInfo($id = null)
    {
        $book       = ArrayHelper::toArray(Book::findOne($id));
        $categories = BookCategory::getAllBookCategories();
        $publishers = Publisher::getAllPublishers();
        $writers    = Writer::getAllWriters();

        return json_encode(array_merge([
            'book'       => $book,
            'categories' => $categories,
            'publishers' => $publishers,
            'writers'    => $writers,
        ]));
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
