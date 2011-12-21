<?php

require_once 'Autoload.php';

class Raggle_Scm_ManagerTest extends PHPUnit_Framework_TestCase {

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Undefined index: git
     */
    function testGetScm_doesNotExist() {
        $manager = new Raggle_Scm_Manager(array());
        $manager->getScm('git');
    }
    
    function testGetScm() {
        $git = $this->getMockBuilder('Raggle_Scm_Git');

        $manager = new Raggle_Scm_Manager(array('git' => $git));
        $this->assertEquals($git, $manager->getScm('git'));
    }
}
