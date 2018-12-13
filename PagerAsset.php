<?php

namespace pvsaintpe\pager;

use kartik\base\AssetBundle;

/**
 * Class PagerAsset
 * @package pvsaintpe\pager
 */
class PagerAsset extends AssetBundle
{
    public $jsOptions = ['defer' => true];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['pager']);
        $this->setupAssets('js', ['pager']);
        parent::init();
    }
}
