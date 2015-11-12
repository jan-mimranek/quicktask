<?php

namespace App\Components\Form;

/**
 * Description 
 */
class TaskFilter extends \Nette\Application\UI\Control
{
    
    /** @var int */
    private $idTaskGroup;
    
    /** @var \App\Model\Repository\TaskRepository */
    public $taskRepository;
    
    /**
     * 
     * @param int $idTaskGroup
     * @param \App\Model\Repository\TaskRepository $taskRepository 
     */
    public function __construct($idTaskGroup, $taskRepository) 
    {
        $this->idTaskGroup = $idTaskGroup;
        $this->taskRepository = $taskRepository;
    }
    
    public function render() 
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/templates/taskFilter.latte');
        $template->render();
    }
    
    /**
     * 
     * @param int $idTaskGroup
     */
    public function createComponentTaskFilterForm() 
    {
        
        $form = new \Nette\Application\UI\Form();
        
        
        $form->addText('filter_task_text', 'Zadejte název tasku');
        $form->addHidden('filter_task_group_id', $this->idTaskGroup);
        
        $form->addSubmit('filter_task_submit', 'Filtruj');
        
        return $form;
    }
    
    
}
