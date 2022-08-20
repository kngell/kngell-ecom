<?php

declare(strict_types=1);

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

abstract class AbstractEmail
{
    use DisplayTraits;

    protected UsersEntity $en;
    protected CssToInlineStyles $inlineCssClass;
    protected CollectionInterface $paths;
    protected string $header;
    protected string $footer;
    protected string $content;
    protected string $css;
    protected string $host = HOST;

    public function __construct(UsersEntity $en, CssToInlineStyles $inlineCssClass, EmailPaths $paths)
    {
        $this->en = $en;
        $this->inlineCssClass = $inlineCssClass;
        $this->paths = $paths->Paths();
        $this->header = $this->getTemplate('standardHeaderPath');
        $this->footer = $this->getTemplate('standardFooterPath');
        $this->content = $this->getTemplate('welcomePath');
        $this->css = $this->getTemplate('mainCssPath');
    }
}