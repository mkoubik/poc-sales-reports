<?php

namespace App\Presenters;

use App\Model\Elastic\Indices\SalesIndex;
use App\Model\Fixtures\BillsGenerator;
use Elasticsearch\Client;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

final class HomepagePresenter extends Presenter
{
    public function __construct(private SalesIndex $salesIndex, private Client $client)
    {
        parent::__construct();
    }

    public function renderDefault(): void
    {
        $this->template->indices = $this->client->cat()->indices();
    }

    public function handleRecreate(): void
    {
        $this->salesIndex->recreate();

        $this->flashMessage('the index was (re)created', 'success');
        $this->redirect('this');
    }

    protected function createComponentGenerateForm(): Form
    {
        $form = new Form();

        $form->addText('count', 'Count of bills')
            ->setDefaultValue(100)
            ->setRequired(true)
            ->addRule($form::INTEGER)
            ->addRule($form::RANGE, null, [1, 1000]);

        $form->addSubmit('Generate');

        $form->onSuccess[] = function (array $values) {
            $count = $values['count'];
            $bills = BillsGenerator::create()->generate($count);
            foreach ($bills as $bill) {
                $this->salesIndex->put($bill);
            }

            $this->flashMessage(sprintf('indexed %u payment bills', $count), 'success');
            $this->redirect('this');
        };

        return $form;
    }
}
