<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait AllowsPagination
{
    public function paginate(int $pageNumber, int $pageSize)
    {
        $this->pageNumber($pageNumber);
        $this->pageSize($pageSize);

        return $this;
    }

    public function pageNumber(int $pageNumber)
    {
        $this->withQuery(['page' => ['number' => $pageNumber]]);

        return $this;
    }

    public function pageSize(int $pageSize)
    {
        $this->withQuery(['page' => ['size' => $pageSize]]);

        return $this;
    }
}
