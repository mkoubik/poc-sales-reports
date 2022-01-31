<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\Elastic\Queries\SalesQuery;
use Elasticsearch\Client;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\Json;

final class QueryPresenter extends Presenter
{
    private SalesQuery $defaultQuery;
    private array|null $result = null;

    public function __construct(private Client $client)
    {
        parent::__construct();
    }

    protected function beforeRender()
    {
        $this->template->addFilter('json', static fn($var) => Json::encode($var, Json::PRETTY));
    }

    public function actionDefault(): void
    {
        $this->defaultQuery = new SalesQuery();
    }

    public function renderDefault(): void
    {
        $this->template->result = $this->result;
    }

    protected function createComponentQueryForm(): Form
    {
        $form = new Form();
        $form->addTextArea('query', 'Query')
            ->setDefaultValue(Json::encode($this->defaultQuery->toArray(), Json::PRETTY));

        $form->addSubmit('run', 'Run');

        $form->onSuccess[] = function (array $value) {
            $query = Json::decode($value['query'], Json::FORCE_ARRAY);
            $this->result = $this->client->search($query);
        };

        return $form;
    }
}
