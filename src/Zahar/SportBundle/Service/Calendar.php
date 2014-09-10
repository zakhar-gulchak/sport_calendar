<?php
namespace Zahar\SportBundle\Service;

use Doctrine\ORM\EntityManager;
use Zahar\SportBundle\Entity\User;

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

    /**
     * @param User $user
     *
     * @return array
     */
    public function getAllStatistics($user)
    {
        $exerciseRepository = $this->_entityManager->getRepository('Zahar\SportBundle\Entity\Exercise');

        return array(
            'two weeks ago' => $exerciseRepository->findBy(array(
                'user' => $user,
                'date' =>  new \DateTime('2 weeks ago'),
            )),
            'week ago' => $exerciseRepository->findBy(array(
                'user' => $user,
                'date' =>  new \DateTime('1 week ago'),
            )),
            'today' => $exerciseRepository->findBy(array(
                'user' => $user,
                'date' => new \DateTime('now'),
            )),
        );
    }
}
