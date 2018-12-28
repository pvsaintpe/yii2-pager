<?php

namespace pvsaintpe\pager;

use Yii;
use pvsaintpe\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use pvsaintpe\helpers\Url;
use pvsaintpe\touchspin\TouchSpin;


/**
 * Class Pager
 * @package backend\components\pager
 */
class Pager extends LinkPager
{
    /**
     * @var string
     */
    public $nextPageLabel = '<i class="fa fa-step-forward"></i>';

    /**
     * @var string
     */
    public $prevPageLabel = '<i class="fa fa-step-backward"></i>';

    /**
     * @var string
     */
    public $firstPageLabel = '<i class="fa fa-fast-backward"></i>';

    /**
     * @var string
     */
    public $lastPageLabel = '<i class="fa fa-fast-forward"></i>';

    /**
     * @var string
     */
    public $pageSelectorClass = 'page-selector';

    /**
     * @var string
     */
    public $pageSizeClass = 'page-size';

    /**
     * @var string
     */
    public $pageSizeParam = 'per-page';

    /**
     * @var array
     */
    public static $pageSizeList = [5, 10, 20, 50];

    /**
     * @var int
     */
    public $minPageSize = 1;

    /**
     * @var int
     */
    public $maxPageSize = 50;

    /**
     * @var int
     */
    protected $activePage;

    /**
     * @inheritdoc
     * @throws
     */
    public function run()
    {
        parent::run();
        $this->renderPageSize();
        // assets
        $view = $this->getView();
        PagerAsset::register($view);
    }

    /**
     * @param string $label
     * @param int $page
     * @param string $class
     * @param bool $disabled
     * @param bool $active
     * @return string
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        if (!$active) {
            return parent::renderPageButton($label, $page, $class, $disabled, $active);
        }

        // active button
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        $content = $this->renderActiveButton($page);
        $this->activePage = $page;

        return Html::tag($linkWrapTag, $content, $options);
    }

    /**
     * @param $page
     * @return string
     */
    protected function renderActiveButton($page)
    {
        return Html::textInput(uniqid('p-'), $page + 1, [
            'class' => $this->pageSelectorClass,
            'data-url' => Url::modify($this->pagination->createUrl(0), ['page']),
            'data-page' => $this->pagination->pageParam
        ]);
    }

    /**
     * @throws \Exception
     * @return void
     */
    protected function renderPageSize()
    {
        $content = Html::tag('span',
            'Cтраниц :' . Html::tag('span',
                $this->pagination->getPageCount(),
                ['class' => 'pv_count_page_number']),
            [
                'class' => 'pv_count_page'
            ]
        );
        $content .= Html::tag('span', Yii::t('backend', 'Количество строк'), ['class' => 'pv_count_row']);

        $queryParams = $this->generateUrl();

        $spin = TouchSpin::widget([
            'name' => 't6',
            'options' => [
                'class' => 'pv_input',
                'data-url' => '/' . Yii::$app->request->pathInfo.'?'.$queryParams,
                'data-max-page' => $this->maxPageSize,
                'data-min-page' => $this->minPageSize,
            ],
            'pluginOptions' => [
                'verticalbuttons' => true,
                'min' => $this->minPageSize,
                'max' => $this->maxPageSize,
                'initval' => $this->pagination->getPageSize(),
            ]
        ]);

        $content .= Html::tag('div', $spin, ['class' => 'spin_wrapper']);
        echo Html::tag('div', $content, ['class' => 'pv_select_wrapper']);
    }

    /**
     * @return string
     */
    public function generateUrl()
    {
        $params = [];

        foreach (Yii::$app->request->queryParams as $key => $value) {
            if ($key == 'page' || $key == 'per-page'){
                continue;
            }
            $params[$key] = $value;
        }

        $params['page'] = $this->pagination->getPage() + 1;
        $params['per-page'] = '';
        $queryParams = http_build_query($params);

        return $queryParams;
    }
}
