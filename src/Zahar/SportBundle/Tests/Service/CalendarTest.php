<?php
namespace Zahar\SportBundle\Tests\Service;

use Zahar\SportBundle\Service\Calendar as CalendarService;
use Zahar\SportBundle\Entity\User as UserEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Test for Zahar\SportBundle\Tests\Service\Calendar;
 *
 * @group unit
 */
class CalendarTest extends \PHPUnit_Framework_TestCase
{
    /** @var  CalendarService */
    protected $service;

    /** @var \PHPUnit_Framework_MockObject_MockObject | EntityManager */
    public $entityManagerMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject | EntityRepository */
    protected $repositoryMock;

    /** @var  \PHPUnit_Framework_MockObject_MockObject | UserEntity */
    protected $userMock;

    /**
     * set up
     */
    public function setUp()
    {
        $this->initEntityManagerMock(array('getRepository'));
//            $this->entityManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
//            ->setMethods(array('getRepository'))
//            ->disableOriginalConstructor()
//            ->getMock();
        $this->userMock = $this->getMockBuilder('Zahar\SportBundle\Entity\User')
            ->getMock();
        $this->repositoryMock = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->setMethods(array('findBy'))
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new CalendarService($this->entityManagerMock);
    }

    /**
     * tear Down
     */
    public function tearDown()
    {
        unset($this->entityManagerMock);
        unset($this->repositoryMock);
        unset($this->userMock);
        unset($this->service);
    }

    /**
     * test main method
     */
    public function testGetAllStatistics()
    {
        $mock1 = $this->getMockBuilder('Zahar\SportBundle\Entity\Exercise')->getMock();
        $mock2 = $this->getMockBuilder('Zahar\SportBundle\Entity\Exercise')->getMock();
        $mock3 = $this->getMockBuilder('Zahar\SportBundle\Entity\Exercise')->getMock();

        $today = new \DateTime('10-09-2014');
        $twoWeeksAgo = new \DateTime('27-08-2014');
        $weekAgo = new \DateTime('03-09-2014');

        $expectedResult = array(
            'two weeks ago' => array($mock1),
            'week ago' => array($mock2),
            'today' => array($mock3),
        );

        $this->entityManagerMock->expects($this->once())->method('getRepository')
            ->with('Zahar\SportBundle\Entity\Exercise')
            ->will($this->returnValue($this->repositoryMock));

        $this->repositoryMock->expects($this->at(0))->method('findBy')
            ->with(array('user' => $this->userMock, 'date' => $twoWeeksAgo), null, null, null)
            ->will($this->returnValue(array($mock1)));

        $this->repositoryMock->expects($this->at(1))->method('findBy')
            ->with(array('user' => $this->userMock, 'date' => $weekAgo), null, null, null)
            ->will($this->returnValue(array($mock2)));

        $this->repositoryMock->expects($this->at(2))->method('findBy')
            ->with(array('user' => $this->userMock, 'date' => $today), null, null, null)
            ->will($this->returnValue(array($mock3)));

        $this->assertEquals($expectedResult, $this->service->getAllStatistics($this->userMock, $today));
    }

    /**
     * Create Doctrine Entity Manager Mock
     *
     * @param array $methods
     */
    public function initEntityManagerMock(array $methods)
    {
        /** @var \PHPUnit_Framework_TestCase $defiant */
        $defiant = $this;
        $this->entityManagerMock = $defiant->getMockBuilder('\Doctrine\ORM\EntityManager')->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
