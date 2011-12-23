<?php

namespace Raggle\Scm\Repository;

require_once 'Autoload.php';

class ManagerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Undefined index: GitRepo
     */
    function testGetRepository_noRepositories() {
        $manager = new Manager(array());
        $manager->getRepository('GitRepo');
    }
    
    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Undefined index: GitRepo
     */
    function testGetRepository_repositoryDoesNotExist() {
        $repo = $this->getMockBuilder('Raggle\Scm\Repository')
            ->disableOriginalConstructor()
            ->getMock();
        $manager = new Manager(array('OtherRepo' => $repo));
        $manager->getRepository('GitRepo');
    }
    
    function testGetRepository_repositoryExists() {
        $repo = $this->getMockBuilder('Raggle\Scm\Repository')
            ->disableOriginalConstructor()
            ->getMock();
        $manager = new Manager(array('GitRepo' => $repo));
        $this->assertEquals($repo, $manager->getRepository('GitRepo'));
    }
}
