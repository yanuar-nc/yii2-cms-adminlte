<?php

/**
 *  @link    http://foundationize.com
 *  @package foundationize/yii2-foundation
 *  @version 1.0.0
 */

namespace foundationize\foundation;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of TopBar
 *
 
 */
class TopBar extends Widget {

  /**
   * @var array
   * @see http://foundation.zurb.com/docs/components/topbar.html 
   */
  public $options;

  /**
   * @var array 
   * @see http://foundation.zurb.com/docs/components/topbar.html#positioning-the-bar
   */
  public $containerOptions = [];
  public $titleLabel;
  public $titleUrl;
  public $titleOptions = [];
  public $toggleText = 'Menu';
  public $showToggleIcon = true;
  public $toggleOptions = ['class' => 'toggle-topbar'];

  /**
   * 
   */
  public function init() {
    parent::init();

    Html::addCssClass($this->options, 'top-bar');

    if (empty($this->options['role'])) {
      $this->options['role'] = 'navigation';
    }
    
    $this->options['data-topbar'] = 1;
    
    $options = $this->options;
    $tag = ArrayHelper::remove($options, 'tag', 'nav');

    if (!empty($this->containerOptions)) {
      echo Html::beginTag('div', $this->containerOptions);
    }

    echo Html::beginTag($tag, $options);
    echo Html::tag('ul', implode("\n", $this->headerItems()), ['class' => 'title-area']);
  }

  /**
   * 
   */
  public function run() {
    $tag = ArrayHelper::remove($this->options, 'tag', 'nav');
    echo Html::endTag($tag);

    if (!empty($this->containerOptions)) {
      echo Html::endTag('div');
    }

    $this->registerPlugin('topbar');
  }

  /**
   * 
   */
  protected function headerItems() {
    Html::addCssClass($this->titleOptions, 'name');

    $title = !empty($this->titleLabel) ? Html::tag('h1', Html::a($this->titleLabel, $this->titleUrl)) : '';

    if ($this->showToggleIcon) {
      Html::addCssClass($this->toggleOptions, 'menu-icon');
    }

    return [
        Html::tag('li', $title, $this->titleOptions),
        Html::tag('li', Html::a(Html::tag('span', $this->toggleText), '#'), $this->toggleOptions)
    ];
  }

}
