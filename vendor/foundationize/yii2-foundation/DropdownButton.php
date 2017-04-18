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
 * Description of ButtonDropdown
 *
 
 */
class DropdownButton extends Widget {

  /**
   * @var string the button label
   */
  public $label = 'Button';

  /**
   * @var array the HTML attributes of the button.
   * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
   */
  public $options = ['class' => 'button'];

  /**
   * The button url, used only for split button
   * @var string Button url 
   */
  public $url = '#';
  /**
   * @var array the configuration array for [[Dropdown]].
   */
  public $dropdown = [];

  /**
   * @var boolean whether to display a group of split-styled button group.
   */
  public $split = false;

  /**
   * @var string the tag to use to render the button
   */
  public $tagName = 'button';

  /**
   * @var boolean whether the label should be HTML-encoded.
   */
  public $encodeLabel = true;
  
  /**
   * Renders the widget.
   */
  public function run() {
    $dropdown = Dropdown::begin($this->getDropdownConfig());
    echo "\n" . $this->renderButton($dropdown);
    Dropdown::end();
    
    $this->registerPlugin('button');
  }

  /**
   * Generates the button dropdown.
   * @return string the rendering result.
   */
  protected function renderButton($dropdown) {
    $dropdownId = $dropdown->getId();
    
    $label = $this->label;
    if ($this->encodeLabel) {
      $label = Html::encode($label);
    }
    if ($this->split) {
      $this->tagName = 'a';
      Html::addCssClass($this->options, 'button');
      Html::addCssClass($this->options, 'split');
      $options = $this->options;
      $label .= Html::tag('span', '', ['data-dropdown' => $dropdownId]);
    } else {
      Html::addCssClass($this->options, 'dropdown');
      $options = $this->options;
      
      $options['data-dropdown'] = $dropdownId;
    }

    return Button::widget([
            'tagName' => $this->tagName,
            'label' => $label,
            'options' => $options,
            'url' => $this->url,
            'encodeLabel' => false,
        ]) . "<br />\n";
  }

  /**
   * Get config for [[Dropdown]] widget
   * @return array config options
   */
  protected function getDropdownConfig() {
    $config = $this->dropdown;
    $config['id'] = ArrayHelper::getValue($config, 'id', null);
    $config['clientOptions'] = false;
    $config['view'] = $this->getView();
    
    return $config;
  }

}
