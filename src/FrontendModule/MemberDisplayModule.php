<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\FrontendModule;

use Contao\BackendTemplate;
use Contao\FilesModel;
use Contao\Module;
use Contao\StringUtil;
use Contao\System;

class MemberDisplayModule extends Module
{

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'mod_MemberDisplay';


    /**
     * Display a wildcard in the back end
     *
     * @return string
     */
    #[\Override]
    public function generate()
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $backendTemplate = new BackendTemplate('be_wildcard');
            $backendTemplate->wildcard = '### MemberDisplay ###';
            $backendTemplate->title = $this->headline;
            $backendTemplate->id = $this->id;
            $backendTemplate->link = $this->name;
            $backendTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $backendTemplate->parse();
        }


        return parent::generate();
    }

    /**
     * Generate the module
     */
    #[\Override]
    protected function compile()
    {
        $container = System::getContainer();
        $rootDir = $container->getParameter('kernel.project_dir');


        $mitarbeiter = $this->Database->prepare("SELECT * FROM tl_member WHERE id=?")->limit(1)->execute($this->mitarbeiter);

        $this->Template->mitarbeiter = $mitarbeiter;

        $objFile = FilesModel::findByUuid($mitarbeiter->primaryimage);
        $path = $objFile->path;
        if ($objFile !== null || is_file($rootDir . '/' . $path)) {
            $picture = $container
                ->get('contao.image.picture_factory')
                ->create($rootDir . '/' . $path, StringUtil::deserialize($this->size));

            $this->Template->primaryImage = $picture->getImg($rootDir);

        }
    }
}

class_alias(MemberDisplayModule::class, 'MemberDisplayModule');
