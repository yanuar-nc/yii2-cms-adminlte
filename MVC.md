# MVC Structure 

- [Model](#basic-model "Model")
- [View](#basic-view "View")
- [Controller](#basic-controller "Controller")
- [MVC Example](#basic-example "Example")

<a name="basic-model"></a>
## Model
When every model class should be inherit with namespace **common\models\BaseModel**. Cause, validations and several functions in contain of its **BaseModel**. 

Documentation [Yii2 - Model Documentation](http://www.yiiframework.com/doc-2.0/yii-base-model.html "Yii2 - Model Documentation")

Here is example:

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
				


<a name="basic-controller"></a>
## Controller
I *recommended* you if you are create a controller class make sure inherit with ***BaseController***. Many components of BaseController going to use in view as *Title, Description, MenuCurrent, MenuChildCurrent* and *Project Name*.

Here is example of a basic controller class:

	<?php
	namespace backend\controllers;
	
	use Yii;
	use backend\models\Page;

	/** Page controller */
	class PageController extends BaseController
	{
	    public $title = 'Page';
	    public $menu  = 'pages'; // Need to equal with code of menu table in database
	    public $description = 'Manage yourpage on this page';
	    
	    public function actionIndex()
	    {
	    	return $this->render('index.twig', [ 'lists' => Page::lists()->all() ] );
	    }
	}

If you want using dataTable with Ajax you need to have a action function `actionListOfData()`
It's look as:
	
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


