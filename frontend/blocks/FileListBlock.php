<?php

namespace luya\cms\frontend\blocks;

use Yii;
use luya\cms\frontend\Module;

class FileListBlock extends \luya\cms\base\Block
{
    public $module = 'cmsadmin';

    public $cacheEnabled = true;
    
    public function name()
    {
        return Module::t('block_file_list_name');
    }

    public function icon()
    {
        return 'attachment';
    }

    /**
     * @todo enabling display of file size when issue #94 is resolved
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'files', 'label' => Module::t("block_file_list_files_label"), 'type' => 'zaa-file-array-upload'],
            ],
            'cfgs' => [
                ['var' => 'showType', 'label' => Module::t("block_file_list_files_showtype_label"), 'initvalue' => 0, 'type' => 'zaa-select', 'options' => [
                        ['value' => '1', 'label' => Module::t("block_file_list_files_showtype_yes")],
                        ['value' => '0', 'label' => Module::t("block_file_list_files_showtype_no")],
                    ],
                ],
            ],
        ];
    }
    
    public function extraVars()
    {
        return [
            'fileList' => $this->zaaFileArrayUpload($this->getVarValue('files')),
        ];
    }

    public function twigFrontend()
    {
        return '{% if extras.fileList is not empty %}<ul>{% for fileEntry in extras.fileList %}<li><a target="_blank" href="{{ fileEntry.source }}">{{ fileEntry.caption }}{% if cfgs.showType %} ({{ fileEntry.extension }}){% endif %}</a></li>{% endfor %}</ul>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if extras.fileList is empty %}<span class="block__empty-text">Es wurden noch keine Dateien angegeben.</span>{% else %}<ul>{% for fileEntry in extras.fileList %}<li><a target="_blank" href="{{ fileEntry.source_http }}">{{ fileEntry.caption }}{% if cfgs.showType == 1 %} ({{ fileEntry.extension }}){% endif %}</a></li>{% endfor %}</ul>{% endif %}';
    }
}
