<?php
namespace App\Presenters;

/**
 * Class TaskPresenter
 * @package App\Presenters
 */
class TaskPresenter extends BasePresenter
{
    /** @var \App\Model\Repository\TaskGroupRepository @inject */
    public $taskGroupRepository;
    /** @var \App\Model\Repository\TaskRepository @inject */
    public $taskRepository;
    /** @var \App\Factories\Modal\IInsertTaskGroupFactory @inject */
    public $insertTaskGroupFactory;
    /** @var \App\Factories\Form\IInsertTaskFactory @inject */
    public $insertTaskFactory;
    /** @var number */
    protected $idTaskGroup;

    public function renderDefault()
    {
        $this->template->taskGroups = $this->getTaskGroups();
    }

    /**
     * @param int $id
     */
    public function handleDeleteTaskGroup($id)
    {
        $this->taskGroupRepository->delete($id);
        if ($this->isAjax()) {
            $this->redrawControl('taskGroups');
        } else {
            $this->redirect('this');
        }
    }
    
    /**
     * 
     * @param type $state
     * @param type $task_id
     */
    public function handleCheckTask($state, $task_id)
    {
        
        $this->template->result = $state.'+'.$task_id;
        
        if ( $state == 'checked') {
            $completed = TRUE;
        } else {
            $completed = FALSE;
        }
        
        $task = $this->taskRepository->getById(intval($task_id));
        $task->setCompleted($completed);
        $this->taskRepository->updateEntity($task);
        
        $this->redrawControl('result');
    }

    /**
     * @param number $idTaskGroup
     */
    public function renderTaskGroup($idTaskGroup)
    {
        if ($this->isAjax() === false) {
            $this->idTaskGroup = $idTaskGroup;
            $this->template->tasks = $this->getTasks($idTaskGroup);
            $this->template->result = "Zatím nic";
        }
        
    }

    /**
     * @return \App\Components\Modal\InsertTaskGroup
     */
    protected function createComponentInsertTaskGroupModal()
    {
        $control = $this->insertTaskGroupFactory->create();
        return $control;
    }

    /**
     * @return \App\Components\Form\InsertTask
     */
    protected function createComponentInsertTaskForm()
    {
        $control = $this->insertTaskFactory->create();
        $control->setTaskGroupId($this->idTaskGroup);
        return $control;
    }

    /**
     * @return array
     */
    protected function getTaskGroups()
    {
        $result = array();
        $taskGroups = $this->taskGroupRepository->getAll();
        foreach ($taskGroups as $taskGroup) {
            $item = array();
            $item['id'] = $taskGroup->getId();
            $item['name'] = $taskGroup->getName();
            $result[] = $item;
        }
        return $result;
    }

    /**
     * @param number $idTaskGroup
     * @return array
     */
    protected function getTasks($idTaskGroup)
    {
        $result = array();
        $tasks = $this->taskRepository->getByTaskGroup($idTaskGroup);
        foreach ($tasks as $task) {
            $item = array();
            $item['id'] = $task->getId();
            $item['date'] = $task->getDate();
            $item['name'] = $task->getName();
            $item['completed'] = $task->getCompleted();
            $result[] = $item;
        }
        return $result;
    }
}
