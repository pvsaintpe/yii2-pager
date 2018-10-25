<?php

namespace backend\components\pager;

use kartik\base\AssetBundle;

class PagerAsset extends AssetBundle
{
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
