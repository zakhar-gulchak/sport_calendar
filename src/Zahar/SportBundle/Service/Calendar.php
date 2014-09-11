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
     * @param User               $user
     * @param \DateTimeImmutable $today
     *
     * @return array
     */
    public function getAllStatistics($user, $today = null)
    {
        if(!$today)
        {
            $today = new \DateTimeImmutable('now');
        }
        $oneWeekAgo = $today->modify('1 week ago');
        $twoWeeksAgo = $today->modify('2 weeks ago');
        $exerciseRepository = $this->_entityManager->getRepository('Zahar\SportBundle\Entity\Exercise');

        return array(
            'two weeks ago' => $exerciseRepository->findBy(array(
                'user' => $user,
                'date' =>  $twoWeeksAgo,
            )),
            'week ago' => $exerciseRepository->findBy(array(
                'user' => $user,
                'date' =>  $oneWeekAgo,
            )),
            'today' => $exerciseRepository->findBy(array(
                'user' => $user,
                'date' => $today,
            )),
        );
    }
}
