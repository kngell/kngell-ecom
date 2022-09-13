<?php

declare(strict_types=1);

class Pagination extends AbstractPagination implements DisplayPagesInterface
{
    public function __construct(array $params = [], ?PaginationPath $paths = null)
    {
        parent::__construct($params, $paths);
    }

    public function displayAll(): mixed
    {
        $template = $this->getTemplate('paginPath');
        $template = str_replace('{{previsouLink}}', $this->previousLink(), $template);
        $template = str_replace('{{links}}', $this->links(), $template);
        $template = str_replace('{{nextLink}}', $this->nextLink(), $template);

        return $template;
    }

    /**
     * Get the value of params.
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Set the value of params.
     */
    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }
}
