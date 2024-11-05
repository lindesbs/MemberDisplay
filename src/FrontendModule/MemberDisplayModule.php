<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


#[AsFrontendModule(category: 'user')]
class MemberDisplayModule extends AbstractFrontendModuleController
{
    protected function getResponse(FragmentTemplate $fragmentTemplate, ModuleModel $moduleModel, Request $request): Response
    {

        $fragmentTemplate->action = $request->getUri();

        return $fragmentTemplate->getResponse();
    }
}