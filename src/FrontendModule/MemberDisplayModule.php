<?php


namespace lindesbs\MemberDisplay\FrontendModule;

use Contao\BackendTemplate;
use Contao\CoreBundle\Image\Studio;

use Contao\CoreBundle\Image\Studio\LegacyFigureBuilderTrait;
use Contao\Module;
use Contao\System;

class MemberDisplayModule extends Module
{
    use LegacyFigureBuilderTrait;

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
    public function generate()
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### MemberDisplay ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }



        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $mitarbeiter = $this->Database->prepare("SELECT * FROM tl_member WHERE id=?")->limit(1)->execute($this->mitarbeiter);

        $this->Template->mitarbeiter =$mitarbeiter;

        $figureBuilder = $this->getFigureBuilderIfResourceExists($mitarbeiter->primaryimage);
        if ($figureBuilder !== null) {
            $this->Template->primaryImage = new \stdClass();
            $figureBuilder->setSize($this->size)
                ->build()
                ->applyLegacyTemplateData($this->Template->primaryImage, $this->imagemargin, $this->floating);


        }
    }
}

class_alias(MemberDisplayModule::class, 'MemberDisplayModule');
