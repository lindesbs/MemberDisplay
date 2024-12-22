<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\Controller\Page;

use Contao\CoreBundle\Controller\AbstractController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsPage;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Response;

#[AsPage(
    type: VCardPage::TYPE,
    path: '/_vcard',
)]
class VCardPage extends AbstractController
{
    public const TYPE = 'contact.export.vcard';

    public function __invoke(PageModel $pageModel): Response
    {
        return new Response("VCard");
    }

}
