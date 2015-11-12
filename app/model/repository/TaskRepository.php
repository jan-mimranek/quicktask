<?php
namespace App\Model\Repository;

use App\Model\Entity;
use Kdyby\Doctrine\EntityManager;

class TaskRepository extends AbstractRepository
{
    /** @var \Kdyby\Doctrine\EntityRepository */
    private $task;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->task = $this->entityManager->getRepository(Entity\Task::getClassName());
    }

    /**
     * @param number $id
     * @return Entity\Task|null
     */
    public function getById($id)
    {
        return $this->task->find($id);
    }

    /**
     * @param number $idTaskGroup
     * @return Entity\Task[]
     */
    public function getByTaskGroup($idTaskGroup)
    {
        return $this->task->findBy(array('taskGroup' => $idTaskGroup));
    }

    /**
     * @param Entity\Task $task
     */
    public function insert(Entity\Task $task)
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
    
    /**
     * @param number $idTaskGroup
     * @return Entity\Task[]
     */
    public function getByTaskGroupOrderByDateDESC($idTaskGroup, $oderBy)
    {
        return $this->task->findBy(array('taskGroup' => $idTaskGroup), $oderBy);
    }
    
    
    /**
     * 
     * @param type $name
     * @param type $id
     * @return array
     */
    public function getTasksFilteredByName($name, $id) {
        
        $repository = $this->entityManager->getRepository('\App\Model\Entity\Task');
        $builder    = $repository->createQueryBuilder('t');
        
        $tasks   = $builder
                ->select('t.id', 'IDENTITY(t.taskGroup) as taskGroup', 't.name', 't.date', 't.completed')
                ->where('t.taskGroup = :taskid')
                ->andWhere('t.name LIKE :taskname')
                ->orderBy('t.date', 'DESC')
                ->setParameter('taskid', $id)
                ->setParameter('taskname', '%'.$name.'%')
                ->getQuery()
                ->getResult();
        
        return $tasks;
        
    }
    
    
}
