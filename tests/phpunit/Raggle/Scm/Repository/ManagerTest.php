<?php

require_once 'Autoload.php';

class Raggle_Scm_Repository_ManagerTest extends PHPUnit_Framework_TestCase {

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Undefined index: GitRepo
     */
    function testGetRepository_noRepositories() {
        $manager = new Raggle_Scm_Repository_Manager(array());
        $manager->getRepository('GitRepo');
    }
    
    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Undefined index: GitRepo
     */
    function testGetRepository_repositoryDoesNotExist() {
        $repo = $this->getMockBuilder('Raggle_Scm_Repository')
            ->disableOriginalConstructor()
            ->getMock();
        $manager = new Raggle_Scm_Repository_Manager(array('OtherRepo' => $repo));
        $manager->getRepository('GitRepo');
    }
    
    function testGetRepository_repositoryExists() {
        $repo = $this->getMockBuilder('Raggle_Scm_Repository')
            ->disableOriginalConstructor()
            ->getMock();
        $manager = new Raggle_Scm_Repository_Manager(array('GitRepo' => $repo));
        $this->assertEquals($repo, $manager->getRepository('GitRepo'));
    }
}
