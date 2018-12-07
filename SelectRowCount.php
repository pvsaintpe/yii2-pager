<?php
/**
 * Created by PhpStorm.
 * User: grimailo.am
 * Date: 07.12.2018
 * Time: 15:25
 */

namespace pvsaintpe\pager;


use Symfony\Component\DependencyInjection\Tests\Compiler\H;
use yii\base\Widget;
use yii\helpers\Html;
use Yii;

class SelectRowCount extends Widget
{
  /**
   * @var array
   */
  public $content = [];

  /**
   * @var string
   */
  public $class = 'pv_select_page';

  /**
   * @var array
   */
  public $options = [];

  /**
   * @var int
   */
  public $defaultPageSize;

  /**
   * @var int
   */
  public $pageSizeList;


  /**
   * @return string|void
   */
  public function run()
  {
    parent::run();
    $this->renderWidget();
  }


  /**
   * @return string
   */
  public function renderWidget()
  {
    $this->makeTitle();
    $this->makeInput();
    $this->makeUl();
    $this->makeManipulatorElements();

    echo Html::tag('div', implode('', $this->content), ['class' => 'pv_select_block']);
  }


  /**
   * @return void
   */
  public function makeTitle()
  {
    $this->content['title'] = Html::tag('span', Yii::t('backend', 'Количество строк'),
      [
        'class' => 'pv_count_row'
      ]);
  }


  /**
   * @return void
   */
  public function makeInput()
  {
    $this->content['input'] = Html::input('text', 'selectPage', $this->defaultPageSize,
      [
        'class' => 'pv_input',
        'data-url' => $this->urlGenerate(),
        'autocomplete' => 'off',
        'data-min-page' => $this->options['minPageSize'],
        'data-max-page' => $this->options['maxPageSize']
      ]);
  }


  /**
   * @return void
   */
  public function makeUl()
  {
    $li = '';
    foreach ($this->pageSizeList as $value) {
      $href = Html::a($value, $this->urlGenerate($value));
      $li .= Html::tag('li', $href, ['data-page' => $value]);
    }

    $this->content['ul'] = Html::tag('ul', $li, ['class' => 'pv_select']);
  }


  /**
   * @return void
   */
  public function makeManipulatorElements()
  {
    $content = Html::tag('button', '+', ['class' => ['addNumber', 'manipulator_elements']]);
    $content .= Html::tag('button', '-', ['class' => ['deductionNumber', 'manipulator_elements']]);
    $this->content['manipulator_elements'] = Html::tag('div', $content, ['class' => 'pv_manipulator_block']);
  }


  /**
   * @param null $value
   * @return mixed|string
   */
  public function urlGenerate($value = null)
  {
    $url = $this->options['data-url'];
    $url .= 'page=' . $this->options['data-page'];
    $url .= '&per-page=' . $value;
    return $url;
  }

}

