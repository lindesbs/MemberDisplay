<?php

declare(strict_types=1);

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
    public const TYPE = 'contact.export.qrcode';

    public function __invoke(PageModel $pageModel): Response
    {
        return new Response("QRCode");
    }

}
