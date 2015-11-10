<?php
namespace App\Components\Modal;

use App\Model\Entity\TaskGroup;
use App\Model\Repository\TaskGroupRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class InsertTaskGroup extends Control
{
    /** @var TaskGroupRepository @inject*/
    public $taskGroupRepository;

    /**
     * @param TaskGroupRepository $taskGroupRepository
     */
    public function __construct(TaskGroupRepository $taskGroupRepository)
    {
        parent::__construct();
        $this->taskGroupRepository = $taskGroupRepository;
    }

    public function render()
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/templates/InsertTaskGroup.latte');
        $template->render();
    }

    /**
     * @return Form
     */
    protected function createComponentInsertTaskGroupForm()
    {
        $form = new Form();
        $form->addText('name', 'Name')
            ->setRequired('Please fill task group name');
        $form->addSubmit('submit', 'Save');
        $form->onSuccess[] = array($this, 'insertTaskGroupFromSuccess');
        return $form;
    }

    /**
     * @param Form $form
     * @param $values
     */
    public function insertTaskGroupFromSuccess(Form $form, $values)
    {
        $taskGroupEntity = new TaskGroup();
        $taskGroupEntity->setName($values->name);
        $this->taskGroupRepository->insert($taskGroupEntity);
        $this->presenter->flashMessage('Task group was created', 'success');
        $this->redirect('this');
    }
}
