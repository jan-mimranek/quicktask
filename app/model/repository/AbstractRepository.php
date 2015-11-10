<?php
namespace App\Model\Repository;

use Nette\Object;
use Kdyby\Doctrine\EntityManager;

abstract class AbstractRepository extends Object
{
    /** @var EntityManager */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateEntity($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($id)
    {
        $entity = $this->getById($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    abstract public function getById($id);
}
