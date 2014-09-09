<?php
namespace Zahar\SportBundle\Service;

use Doctrine\ORM\EntityManager;
use Zahar\SportBundle\Entity\ExerciseRepository;

class Calendar
{
    /** @var EntityManager */
    private $_entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    public function getAllStatistics()
    {
        /** @var ExerciseRepository $exerciseRepository */
        $exerciseRepository = $this->_entityManager->getRepository('Zahar\SportBundle\Entity\Exercise');

        return array(
            'two week ago' => $exerciseRepository->getAllExercisesByPeriod('two week ago'),
            'week ago' => $exerciseRepository->getAllExercisesByPeriod('week ago'),
            'today' => $exerciseRepository->getAllExercisesByPeriod('today'),
        );
    }
}
