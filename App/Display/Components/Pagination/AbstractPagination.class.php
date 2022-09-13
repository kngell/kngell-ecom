<?php

declare(strict_types=1);

abstract class AbstractPagination
{
    use DisplayTraits;

    protected int $totalPages;
    protected int $currentPage;
    protected int $totalRecords;
    protected int $recordPerPage;
    protected string $template;
    protected CollectionInterface $paths;
    protected array $params;
    protected string $linkDots;

    public function __construct(array $params = [], ?PaginationPath $paths = null)
    {
        $this->params = $params;
        $this->paths = $paths->Paths();
        $this->getRepositoryParts($params);
        $this->linkDots = $this->getTemplate('dotsPath');
    }

    protected function links() : string
    {
        $linkHtml = '';
        $range = $this->range($this->currentPage, $this->totalPages);
        foreach ($range as $key => $value) {
            if ($key === 'init') {
                $linkHtml .= $this->getLink(1, $range[$key]);
            } elseif ($key === 'separator1' || $key === 'separator2') {
                $linkHtml .= $this->linkDots;
            } elseif ($key === 'lastTotal') {
                $linkHtml .= $this->getLink($range[$key], $range[$key]);
            } else {
                $linkHtml .= $this->getLink($value[0], $value[2]);
            }
        }

        return $linkHtml;
    }

    protected function previousLink() : string
    {
        $temp = $this->getTemplate('previousPath');
        $temp = str_replace('{{href_prev}}', $this->currentPage > 2 ? '?page=' . $this->currentPage - 1 : '/account', $temp);

        return $temp;
    }

    protected function nextLink() : string
    {
        $temp = $this->getTemplate('nextPath');
        $temp = str_replace('{{href_next}}', $this->currentPage < $this->totalPages ? '?page=' . $this->currentPage + 1 : '#', $temp);

        return $temp;
    }

    private function getLink(int $start, int $end)
    {
        $linkHtml = '';
        for ($page = $start; $page <= $end; $page++) {
            $active = $page == $this->currentPage ? ' active' : '';
            $temp = str_replace('{{href}}', '?page=' . $page, $this->getTemplate('linkPath'));
            $temp = str_replace('{{page}}', strval($page), $temp);
            $temp = str_replace('{{active}}', $active, $temp);
            $linkHtml .= $temp;
        }

        return $linkHtml;
    }

    private function range(int $page, int $totalPages) : array
    {
        if ($totalPages < 6) {
            $start = 2;
        } elseif ($page < 3) {
            $start = 2;
        } elseif ($page > $totalPages - 3) {
            $start = $totalPages - 3;
        } else {
            $start = $page - 1;
        }
        $output = ['init' => 1];
        if ($start > 2) {
            $output['separator1'] = '...';
        }
        for ($i = $start; $i < $totalPages; $i++) {
            $output['main'][] = $i;
            if ($i > ($start + 1)) {
                break;
            }
        }
        if ($start < $totalPages - 3) {
            $output['separator2'] = '...';
        }
        if ($totalPages > 1) {
            $output['lastTotal'] = $totalPages;
        }

        return $output;
    }

    private function getRepositoryParts(array $params) : void
    {
        if (!empty($params)) {
            list('page' => $this->currentPage, 'pagin' => $this->totalPages, 'totalRecords' => $this->totalRecords, 'records_per_page' => $this->recordPerPage, 'additional_conditions' => $adc) = $params;
        }
    }
}
