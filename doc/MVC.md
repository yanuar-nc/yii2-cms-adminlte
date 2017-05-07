# MVC Structure 

- [Model](#basic-model "Model")
	- [Retrieve Data](#basic-retrieve-data "Retrieve Data")
	- [Save](#basic-model-save "Save")
	- [Delete](#basic-model-delete "Delete")
	- [File Upload](#basic-file-upload "File Upload")
- [View](#basic-view "View")
- [Controller](#basic-controller "Controller")
	- [Ajax Action](#basic-ajax-action "Ajax Action")
- [Example](EXAMPLE.md "Example")

<a name="basic-model"></a>
## Model
When every model class should be inherit with namespace **common\models\BaseModel**. Cause, validations and several functions in contain of its **BaseModel**. 

Documentation [Yii2 - Model Documentation](http://www.yiiframework.com/doc-2.0/yii-base-model.html "Yii2 - Model Documentation")

Here is example:
```php

    <?php

    namespace backend\models;

    use Yii;

    class Page extends \common\models\BaseModel
    {

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
        { [...] }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        { [...] }

    }
```
<a name="basic-retrieve-data"></a>
### Retrieve Data

<a name="basic-model-save"></a>
### Save

<a name="basic-model-delete"></a>
### Delete

<a name="basic-form-model"></a>
### Form Model
The one of another important when you want **create a form**. I've already provided function to build form in Model. 
This function so related with `\backend\components\View.php`

Here is code example:

```php

	public static function formData()
    {
        return [
            'id',
            'title' => [
                'textInput' => [ 'options' => ['placeholder' => 'Title'] ] 
            ],
            'date' => [
                'datePicker' => [ 'value' => date('Y-m-d') ]	// Using date picker widget
            ],
            'datetime' => [
                'dateTimePicker' => [ 'value' => date('Y-m-d H:i:s') ] // Using date time picker widget
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

```
Check another options of this documentation [Yii2 ActiveForm](http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html "Yii2 Active Form").

<a name="basic-file-upload"></a>
### File Upload
When you have plan to make file upload, make sure your folder already exist. The configuration path in `/common/config/bootstrap.php` and change value of variable **ASSET_PATH**.

And now you be able to make variable of upload file:

```php

    public static $uploadFile = [
        'image' => [ 			// your name field in database 
            'path' => 'page/', 	// your path of assets directory, if you don't set this value, default path is own table name
            'resize' => [  		// Resize your want to own
                [
                    'prefix' => 'thumb_',
                    'size' => [200,200],
                ]
            ]
        ]
    ]; 
```
The upload function belongs to `common/components/Upload.php`

<a name="basic-view"></a>
## View
Next, In here i am using **Twig** to rendred a view. If you are not experience with Twig, please read this docummentation [Twig Extension for Yii 2](https://github.com/yiisoft/yii2-twig/tree/master/docs/guide, "Twig Extension for Yii 2").
The configuration of twig there is in */[application]/config/main.php* and looking array view you will discovered the view is rendered by Twig.

### Directory View Structure
	
	application/ 		backend or frontend
		...
		views/
			folders/ 	its depends on you own
			layouts/	this is main layout directory
			partials/	this directory for you want to create some partial views
				

Here is example of view:

```html

	<!-- /backend/views/page/index.twig -->
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
							<th>Role</th>
							<th>Menu</th>
							<th>Status</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tbody>
						{% for list in lists %}
						<tr {{ this.contextualRow(list.row_status) }}>
							<td>{{ list.id }}</td>
							<td>{{ list.role.name }}</td>
							<td>{{ list.menu.name }}</td>
							<td>{{ list.getStatus() }}</td>
							<td> 
								{{ this.getActionButtons( {
								'update': url( app.controller.id ~ '/create', { 'id': list.id }), 
								'delete': url( app.controller.id ~ '/delete', { 'id': list.id}) 
								}, this.params['user']['roleCode'] ) | raw }}</td>
						</tr>
						{% endfor %}
					</tbody>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Code</th>
							<th>Name</th>
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
The function `this.getActionButtons` belongs to `/backend/components/View.php`. Purpose for the access of each user is allowed. 

If you want using dataTable with AJAX you also can using this example code:
```html

	<div class="box">
		<div class="box-header">
	      	<h3 class="box-title">Data Table using server side</h3> {{ this.render('/partials/button/insert-default.twig' ) | raw }}
	    </div>
		<!-- /.box-header -->
		<div class="box-body">
			<table class="table table-striped table-bordered table-hover" id="dataTableAjax">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>code</th>
						<th>Link</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>code</th>
						<th>Link</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</tfoot>
			</table>
		</div>
	<!-- /.box-body -->
	</div>
```
And i provided template to build form as well. To using this template you just rendered `$this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => YourModel::formData() ] );` in your controller.

<a name="basic-controller"></a>
## Controller
I *recommended* you if you are create a controller class make sure inherit with ***BaseController***. Many components of BaseController going to use in view as *Title, Description, MenuCurrent, MenuChildCurrent* and *Project Name*.

Here is example of a basic controller class:

```php

	<?php
	namespace backend\controllers;
	
	use Yii;
	use backend\models\Page;

	/** 
	 * Page controller 
	 * 
	 * @var $title, $menu and $description is obligation
	 */
	class PageController extends BaseController
	{
	    public $title = 'Page';
	    public $code  = 'pages'; // Need to equal with code of menu table in database
	    public $menu  = 'pages'; // Need to equal with code of menu table in database
	    public $description = 'Manage yourpage on this page';
	    
	    public function actionIndex()
	    {
	    	return $this->render('index.twig', [ 'lists' => Page::lists()->all() ] );
	    }
	}
```

<a name="basic-ajax-action"></a>
### Ajax Action
If you want using dataTable with Ajax you need to have a action function `actionListOfData()`
It's look as:

```php

	<?php
	namespace backend\controllers;

	use Yii;
	use backend\models\Page;

	/** Page controller */
	class PageController extends BaseController
	{
		[...]    
	    public function actionListOfData()
		{
			return Page::getDataForAjax(Yii::$app->request->get());
		}
	}
```