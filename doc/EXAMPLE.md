# EXAMPLE MVC
- [Table Page of Database](#basic-table)
- [Model](#basic-model)
- [View](#basic-view)
- [Controller](#basic-controller)

<a name="basic-table"></a>
## Table Page

```sql

	CREATE TABLE `pages` (
	  `id` int(11) NOT NULL,
	  `title` varchar(200) CHARACTER SET latin1 NOT NULL,
	  `subcontent` text CHARACTER SET latin1 NOT NULL,
	  `content` text CHARACTER SET latin1 NOT NULL,
	  `user_id` int(11) NOT NULL,
	  `image` varchar(200) CHARACTER SET latin1 NOT NULL,
	  `row_status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = Active; 0 = Disactive',
	  `created_at` int(11) NOT NULL,
	  `updated_at` int(11) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

	--
	-- Indexes for table `pages`
	--

	ALTER TABLE `pages`
	  ADD PRIMARY KEY (`id`),
	  ADD KEY `user_id` (`user_id`);
```
<a name="basic-model"></a>
## MODEL

```php
	<?php
	
	namespace backend\models;
	
	use Yii;
	
	/**
	 * This is the model class for table "pages".
	 *
	 * @property integer $id
	 * @property string $title
	 * @property string $subcontent
	 * @property string $content
	 * @property integer $user_id
	 * @property string $image
	 * @property integer $row_status
	 * @property integer $created_at
	 * @property integer $updated_at
	 *
	 * @property User $user
	 */
	class Page extends \common\models\BaseModel
	{
	
	    public static $uploadFile = [
	        'image' => [
	            'path' => 'page/',
	            'resize' => [
	                [
	                    'prefix' => 'thumb_',
	                    'size' => [200,200],
	                ]
	            ]
	        ]
	    ];
	
	    /**
	     * @inheritdoc
	     */
	    public static function tableName()
	    {
	        return 'pages';
	    }
	
	    /**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            [['title', 'subcontent', 'content', 'user_id', ], 'required'],
	            [['title'], 'alphabetsValidation'],
	            [['subcontent', 'content'], 'string'],
	            [['user_id', 'row_status', 'created_at', 'updated_at'], 'integer'],
	            [['title', 'image'], 'string', 'max' => 200],
	            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024*1024, 'tooBig' => 'The "{file}" {attribute} is too big. Its size cannot exceed 1MB'],
	            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
	        ];
	    }
	
	    /**
	     * Data fields of the form
	     *
	     * @return     array  ( description of the return value )
	     */
	    public static function formData()
	    {
	        return [
	            'id',
	            'title' => [
	                'textInput' => [ 'options' => ['placeholder' => 'Title'] ] 
	            ],
	            'subcontent' => [
	                'textInput' => [ 'options' => ['placeholder' => 'Subcontent', 'ha' => 'ss'] ] 
	            ],
	            'content' => [
	                'textarea' => [ 'options' => ['class' => 'wysihtml'] ]
	            ],
	            'image' => [
	                'fileInput'
	            ],
	            'row_status' => [
	                // 'radioList' => [ 'list' => [ 0 => 'Active', 1 => 'Disactive' ] ]
	                'dropDownList' => [ 'list' => [ 1 => 'Active', 0 => 'Disactive' ] ]
	            ]
	        ];
	    }
	
	    /**
	     * @inheritdoc
	     */
	    public function attributeLabels()
	    {
	        return [
	            'id' => 'ID',
	            'title' => 'Title',
	            'subcontent' => 'Subcontent',
	            'content' => 'Content',
	            'user_id' => 'User ID',
	            'image' => 'Image',
	            'row_status' => 'Row Status',
	            'created_at' => 'Created At',
	            'updated_at' => 'Updated At',
	        ];
	    }
	
	    /**
	     * @return \yii\db\ActiveQuery
	     */
	    public function getUser()
	    {
	        return $this->hasOne(User::className(), ['id' => 'user_id']);
	    }
	
	    public static function listData()
	    {
	        return static::lists()->all();
	    }
	}
```

<a name="basic-view"></a>
## View

```html
	<div class="box">
		<div class="box-header">
	      	<h3 class="box-title">Listdata </h3> {{ this.render('/partials/button/insert-default.twig' ) | raw }}
	    </div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="table-responsives">
			<table class="table table-striped table-bordered table-hover" id="dataTable1">
				<thead>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Subcontent</th>
						<th>Publisher</th>
						<th>Status</th>
						<th width="10%">Action</th>
					</tr>
				</thead>
				<tbody>
					{% for list in lists %}
					<tr {{ this.contextualRow(list.row_status) }}>
						<td>{{ list.id }}</td>
						<td>{{ list.title }}</td>
						<td>{{ list.subcontent }}</td>
						<td>{{ list.user.fullname }}</td>
						<td>{{ list.getStatus(list.row_status) }}</td>
						<td> 
							{{ this.getActionButtons( {
							'update': url('page/update', { 'id': list.id }), 
							'delete': url('page/delete', { 'id': list.id}) 
							}, this.params['user']['roleCode'] ) | raw }}</td>
					</tr>
					{% endfor %}
				</tbody>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Subcontent</th>
						<th>Publisher</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</tfoot>
			</table>
		</div>
		</div>
	<!-- /.box-body -->
	</div>
```
<a name="basic-controller"></a>
## Controller

```php
	<?php
	namespace backend\controllers;
	
	use Yii;
	use backend\models\Page;
	
	/**
	 * Page controller
	 */
	class PageController extends BaseController
	{
	
	    public $title = 'Page';
	    public $menu  = 'pages';
	    public $description = 'Manage yourpage on this page';
	    
	    public function actionIndex()
	    {
	    	return $this->render('index.twig', [ 'lists' => Page::listData() ] );
	    }
	
	    public function actionCreate()
	    {
	        $model = new Page();
	
	        if ( Yii::$app->request->post() )
	        {
	            
	            $post = Yii::$app->request->post();
	            $post['Page']['user_id'] = $this->user->id; // Nambahin value baru untuk user_id karna tidak dicantumkan kedalam form
	            $saveModel = Page::saveData($model, $post);
	
	            if ( $saveModel[ 'status' ] == true )
	            {
	                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
	                return $this->redirect(['page/index']);
	            }
	        }
	        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Page::formData() ] );
	    }
	
	    /**
	     * { function_description }
	     *
	     * @param      <int>                          $id     The identifier
	     *
	     * @throws     \yii\web\NotFoundHttpException  (Jika tidak ada satupun data yang ditemukan,
	     *                                              maka akan dilempar ke halaman not found)
	     *
	     */
	    public function actionUpdate($id)
	    {
	
	        $model = Page::findOne($id);
	
	        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);
	
	        if ( Yii::$app->request->post() )
	        {
	
	            $saveModel = Page::saveData($model, Yii::$app->request->post());
	            if ( $saveModel[ 'status' ] == true )
	            {
	                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
	                return $this->redirect(['page/index']);
	            }
	        }
	        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Page::formData() ] );
	    }
	
	    public function actionDelete($id)
	    {
	
	        $model = Page::deleteData(new Page(), $id);
	
	        if ( $model['status'] == true  )
	        {
	            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
	        } else {
	            $this->session->setFlash('danger', MSG_DATA_UPDATE_FAILED);
	        }
	        return $this->redirect(['page/index']);
	    }
	    
	    public function actionListOfData()
	    {
	    	return Page::getDataForAjax(Yii::$app->request->get());
	    }
	
	}
```