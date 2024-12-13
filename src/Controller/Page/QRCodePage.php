<?php

namespace lindesbs\MemberDisplay\Controller\Page;

use Contao\CoreBundle\Controller\AbstractController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsPage;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Response;

#[AsPage(
    type: QRCodePage::TYPE,
    path: '/_qrcode',
)]
class QRCodePage extends AbstractController
{
    const TYPE = 'contact.export.qrcode';
    public function __invoke(PageModel $pageModel): Response
    {
        return new Response("QRCode");
    }

}
