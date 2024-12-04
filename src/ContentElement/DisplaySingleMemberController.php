<?php

declare(strict_types=1);

namespace lindesbs\MemberDisplay\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\MemberModel;
use Contao\Template;
use lindesbs\userobject\DTO\VCard\Enum\EmailType;
use lindesbs\userobject\DTO\VCard\Enum\PhoneType;
use lindesbs\userobject\VCard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'texts')]
class DisplaySingleMemberController extends AbstractContentElementController
{
    public const TYPE = 'displaymember_single';

    #[\Override]
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        $vcard = new VCard();

        $member = MemberModel::findAll()->first();

        $vcard->getIdentification()
            ->setFormattedName(trim(sprintf("%s %s", $member->firstname, $member->lastname)))
            ->setName($member->firstname, $member->lastname)
            ->setNickname($member->nickname);

        $vcard->getCommunication()
            ->addEmail('john.doe@example.com', [EmailType::WORK])
            ->addTelephone('+1234567890', [PhoneType::CELL]);

        $vcard->getOrganizational()
            ->setTitle('Software Developer')
            ->setOrganization('Tech Corp');


        $template->member =  $member;
        $template->vcard = $vcard->toString();

        return $template->getResponse();
    }
}
