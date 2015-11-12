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
    /** @var \App\Factories\Form\ITaskFilterFactory @inject */
    public $taskFilterFactory;

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
     * @param string $filter_task_text
     * @param string $filter_task_group_id
     */
    public function handleTaskFilter($filter_task_text, $filter_task_group_id) 
    {
        $tasks = $this->taskRepository->getTasksFilteredByName($filter_task_text, intval($filter_task_group_id));
        $this->template->tasks = $tasks;
        $this->template->taskGroups = $this->getTaskGroups();
        
        $this->redrawControl('tasks');
    }
    
    /**
     * 
     * @param string $name
     * @param string $date
     */
    public function handleInsertTask($name, $date, $idTaskGroup, $filter_task_text, $filter_task_group_id) {
        
        $taskGroup = $this->taskGroupRepository->getById($idTaskGroup);

        $taskEntity = new \App\Model\Entity\Task();
        $taskEntity->setName($name);
        $taskEntity->setDate($date);
        $taskEntity->setTaskGroup($taskGroup);
        $this->taskRepository->insert($taskEntity);
        $this->presenter->flashMessage('Task was created', 'success');
        
        $tasks = $this->taskRepository->getTasksFilteredByName($filter_task_text, intval($filter_task_group_id));
        $this->template->tasks = $tasks;
        $this->template->taskGroups = $this->getTaskGroups();
        
        $this->redrawControl('tasks');
        
    }
    
    function handleTaskGroupChange($filter_task_text, $filter_task_group_id, $taskGroupId, $taskId) 
    {
        
        $taskGroup = $this->taskGroupRepository->getById($taskGroupId);
        
        $task = $this->taskRepository->getById(intval($taskId));
        $task->setTaskGroup($taskGroup);
        
        $this->taskRepository->updateEntity($task);
        
        $this->template->tasks = $this->taskRepository->getTasksFilteredByName($filter_task_text, intval($filter_task_group_id));
        $this->template->taskGroups = $this->getTaskGroups();
        
        $this->redrawControl('tasks');
    }
    
    /**
     * 
     * @param type $state
     * @param type $task_id
     */
    public function handleCheckTask($state, $task_id)
    {
        if ( $state == 'checked') {
            $completed = TRUE;
        } else {
            $completed = FALSE;
        }
        
        $task = $this->taskRepository->getById(intval($task_id));
        $task->setCompleted($completed);
        $this->taskRepository->updateEntity($task);
        
    }

    /**
     * @param number $idTaskGroup
     */
    public function renderTaskGroup($idTaskGroup)
    {
        
        if ($this->isAjax() === false) {
            $this->idTaskGroup = $idTaskGroup;
            $this->template->tasks = $this->getTasks($idTaskGroup, array('date' => 'DESC'));
            
            $this->template->taskGroups = $this->getTaskGroups();
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

    protected function createComponentTaskFilterForm() {
        $form = $this->taskFilterFactory->create($this->idTaskGroup, $this->taskRepository);
        return $form;
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
    protected function getTasks($idTaskGroup, $orderBy = NULL)
    {
        
        
        if ($orderBy == NULL) {
            $tasks = $this->taskRepository->getByTaskGroup($idTaskGroup);
        } else {
            $tasks = $this->taskRepository->getByTaskGroupOrderByDateDESC($idTaskGroup, $orderBy);
        }
        
        return $this->tasksToArray($tasks);
    }
    
    /**
     * 
     * @param array $tasks array of Task entities
     * @return arrray
     */
    public function tasksToArray($tasks) {
        
        $result = array();
        
        if (count($tasks) > 0) 
        {
            foreach ($tasks as $task) {
                
                /* @var $task \App\Model\Entity\Task */
                $item = array();
                $item['id'] = $task->getId();
                $item['date'] = $task->getDate();
                $item['name'] = $task->getName();
                $item['completed'] = $task->getCompleted();
                $item['taskGroup'] = $task->getTaskGroup()->getId();
                $result[] = $item;
            }
        }
        
        return $result;
    }


}
