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
use yii\helpers\Html;

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
                    // 'create' => ['POST'],
                    // 'update' => ['POST'],
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
        $categories = ArrayHelper::map(BookCategory::getAllBookCategories(), 'id', 'ten_loai_sach');
        $publishers = ArrayHelper::map(Publisher::getAllPublishers(), 'id', 'ten_nha_xuat_ban');
        $writers    = ArrayHelper::map(Writer::getAllWriters(), 'id', 'ten_tac_gia');

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

        $post['Book'] = json_decode(file_get_contents("php://input"), true);
        $success = false;

        if ($model->load($post)) {
            $success = 'Load ';
        }
        if ($model->save()) {
            $success .= 'Save';
        }

        // return $this->render('create', [
        //     'model' => $model,
        // ]);

        return json_encode($success);
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

        $post['Book'] = Yii::$app->request->post();
        $success = false;

        if ($model->load($post) && $model->save()) {
            $file = $_FILES['image'];
            $file['tempName'] = $file['tmp_name'];
            unset($file['tmp_name']);

            $uploadForm = new UploadForm();
            $uploadForm->imageFile = new UploadedFile($file);
            $uploadForm->imagePath = Yii::$app->params['image_path']['Book'];

            if ($uploadForm->upload()) {
                $response['status'] = 'success';
            }
            $success = true;
        }

        return json_encode($post);
        return json_encode($success);
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
        $this->findModel($book_id)->delete();
        $success = true;

        return json_encode($success);
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
}
