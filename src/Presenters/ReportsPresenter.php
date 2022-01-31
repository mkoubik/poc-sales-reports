<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\Elastic\Queries\SalesQuery;
use Elasticsearch\Client;
use Nette\Application\UI\Presenter;
use Nette\Utils\Json;

final class ReportsPresenter extends Presenter
{
    public function __construct(private Client $client)
    {
        parent::__construct();
    }

    protected function beforeRender()
    {
        $this->template->addFilter('money', static fn($s) => number_format($s, 2) . ' EUR');
    }

    public function renderDefault(): void
    {
        $query = new SalesQuery();

        $time = microtime(true);
        $this->template->query = $query->toArray();
        $this->template->result = $query->run($this->client);
        $this->template->seconds = microtime(true) - $time;
    }
}
