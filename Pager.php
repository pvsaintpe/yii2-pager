<?php

namespace pvsaintpe\pager;

use kartik\widgets\InputWidget;
use Yii;
use pvsaintpe\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;

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
    protected $activePage;

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $this->renderPageSize();
        // assets
        $view = $this->getView();
        PagerAsset::register($view);
    }

//    /**
//     * @param string $label
//     * @param int $page
//     * @param string $class
//     * @param bool $disabled
//     * @param bool $active
//     * @return string
//     */
//    protected function renderPageButton($label, $page, $class, $disabled, $active)
//    {
//        if (!$active) {
//            return parent::renderPageButton($label, $page, $class, $disabled, $active);
//        }
//
//        // active button
//        $options = $this->linkContainerOptions;
//        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
//        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);
//
//        Html::addCssClass($options, $this->pageSelectorClass);
//        $content = $this->renderActiveButton($page);
//        $this->activePage = $page;
//
//        return Html::tag($linkWrapTag, $content, $options);
//    }
//
//    /**
//     * @param $page
//     * @return string
//     */
//    protected function renderActiveButton($page)
//    {
//        $pageCount = $this->pagination->getPageCount();
//        $url = $this->getUrl($this->pagination->createUrl(0), ['page']);
//
//        return Select2::widget([
//            'name' => uniqid('p-'),
//            'value' => $page + 1,
//            'data' => array_combine(range(1, $pageCount), range(1, $pageCount)),
//            'options' => [
//                'multiple' => false,
//                'class' => $this->pageSelectorClass,
//                'data-url' => $url,
//                'data-page' => $this->pagination->pageParam
//            ]
//        ]);
//    }

    /**
     * @param $url
     * @param array $attributes
     * @return string
     */
    protected function getUrl($url, $attributes = [])
    {
        $urlParts = parse_url($url);
        $params = [];
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $params);
        }
        foreach ($attributes as $attribute) {
            if (isset($params[$attribute])) {
                unset($params[$attribute]);
            }
        }
        $urlParts['query'] = http_build_query($params);
        return $urlParts['path'] . '?' . $urlParts['query'];
    }

    /**
     * Echo page count
     */
    protected function renderPageSize()
    {
        $content = Html::tag(
            'li',
            Html::tag('span', Yii::t('backend', 'Количество строк')),
            ['class' => 'not-button']
        );
        $url = $this->getUrl($this->pagination->createUrl(0), ['page', 'per-page']);
        $content .= Html::tag('li', Select2::widget([
            'name' => uniqid('pq-'),
            'value' => $this->pagination->getPageSize(),
            'data' => array_combine(static::$pageSizeList, static::$pageSizeList),
            'options' => [
                'multiple' => false,
                'class' => $this->pageSizeClass,
                'data-url' => $url,
                'data-page' => $this->pagination->getPage() + 1,
                'data-per-page' => $this->pagination->getPageSize(),
                'data-page-size' => $this->pageSizeParam
            ]
        ]), ['class' => $this->pageSizeClass]);

        echo Html::tag('ul', $content, ['class' => 'pagination ' . $this->pageSizeClass]);
    }
}
