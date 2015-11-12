<?php

namespace App\Factories\Form;

/**
 *
 */
interface ITaskFilterFactory {
    
    /**
     * 
     * @param int $idTaskGroup
     * 
     * @param \App\Model\Repository\TaskRepository $taskRepository 
     * 
     * @return \App\Components\Form\TaskFilter
     */
    public function create($idTaskGroup, $taskRepository);
}
