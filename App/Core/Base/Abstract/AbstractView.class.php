<?php

declare(strict_types=1);

abstract class AbstractView
{
    use ViewGettersAndSettersTrait;

    protected string  $page_title;
    protected string $_siteTitle = SITE_TITLE;
    protected string $_layout = DEFAULT_LAYOUT;
    protected string $file_path;
    protected mixed $view_data;
    protected bool $webView = true;
    protected FilesSystemInterface $fileSyst;
    protected string $view_file;

    public function reset() : self
    {
        // $this->_head = '';
        // $this->_body = '';
        // $this->_footer = '';
        $this->_html = '';

        return $this;
    }

    protected function viewFile(string $view_file) : array|bool
    {
        $file = explode(DS, $view_file);
        if (count($file) == 2) {
            return $this->fileSyst->search_file(VIEW, $file[1] . '.php', $file[0]);
        }
        if (count($file) == 1) {
            return $this->fileSyst->search_file(VIEW, $file[0] . '.php');
        }
        return false;
    }
}