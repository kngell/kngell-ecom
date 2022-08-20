<?php

declare(strict_types=1);

class Pagination implements DisplayPagesInterface
{
    use DisplayTraits;

    private Paginator $paginator;
    private int $totalPages;
    private int $currentPage;
    private int $totalRecords;
    private int $direction;
    private int $sortDirection;
    private string $template;
    private CollectionInterface $paths;
    private array $params;

    public function __construct(array $params = [], ?PaginationPath $paths = null)
    {
        $this->params = $params;
        $this->paths = $paths->Paths();
        $this->getRepositoryParts($params);
    }

    public function displayAll(): mixed
    {
        $template = $this->getTemplate('paginPath');
        $linkHtml = '';
        for ($page = 1; $page <= $this->totalPages; $page++) {
            $temp = str_replace('{{href}}', '?page=' . $page, $this->getTemplate('linkPath'));
            $temp = str_replace('{{page}}', strval($page), $temp);
            $linkHtml .= $temp;
        }
        $template = str_replace('{{links}}', $linkHtml, $template);
        return $template;
    }

    private function getRepositoryParts(array $datarepository) : void
    {
        list('page' => $this->currentPage, 'pagin' => $this->totalPages, 'totalRecords' => $this->totalRecords, 'records_per_page' => $rec_perpage, 'additional_conditions' => $adc) = $datarepository;
    }
}