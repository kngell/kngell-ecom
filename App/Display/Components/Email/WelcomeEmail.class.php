<?php

declare(strict_types=1);

use Pelago\Emogrifier\CssInliner;
use Pelago\Emogrifier\HtmlProcessor\HtmlNormalizer;
use Pelago\Emogrifier\HtmlProcessor\HtmlPruner;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class WelcomeEmail extends AbstractEmail implements DisplayPagesInterface
{
    private string $welcomeText = 'Bienvenu! Complétez Votre profil';
    private string $welcomeTitle = 'Bienvenu chez K\'ngell';

    public function __construct(UsersEntity $en, CssToInlineStyles $inlineCssClass, EmailPaths $paths)
    {
        parent::__construct($en, $inlineCssClass, $paths);
    }

    public function displayAll(): string
    {
        $html = $this->welcomePage();
        $cssInliner = CssInliner::fromHtml($html)->inlineCss($this->css);
        HtmlPruner::fromDomDocument($cssInliner->getDomDocument())
            ->removeRedundantClassesAfterCssInlined($cssInliner);

        return HtmlNormalizer::fromHtml($cssInliner->render())->render();
    }

    protected function welcomePage() : string
    {
        $emailTemp = $this->header;
        $emailTemp .= $this->welcomePageContent();
        $emailTemp .= $this->footer;

        return $emailTemp;
    }

    private function welcomePageContent() : string
    {
        $content = str_replace('{{welcome}}', $this->welcomeText, $this->content);
        $content = str_replace('{{welcomeTitle}}', $this->welcomeTitle, $content);
        $content = str_replace('{{name}}', $this->en->getFirstName(), $content);
        $content = str_replace('{{welcomeContent}}', $this->getTemplate('welcomeContent'), $content);
        $content = str_replace('{{verifyAccountText}}', $this->getTemplate('verifyAccount'), $content);
        $content = str_replace('{{completeProfileText}}', $this->getTemplate('completeProfile'), $content);
        $content = str_replace('{{startPurchase}}', $this->getTemplate('startPurchase'), $content);
        $content = str_replace('{{host}}', $this->host, $content);

        return $content;
    }
}
