<?php

namespace Raggle\Scm;

require_once 'Autoload.php';

class ManagerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Undefined index: git
     */
    function testGetScm_doesNotExist() {
        $manager = new Manager(array());
        $manager->getScm('git');
    }
    
    function testGetScm() {
        $git = $this->getMockBuilder('Raggle\Scm\Git');

        $manager = new Manager(array('git' => $git));
        $this->assertEquals($git, $manager->getScm('git'));
    }
}
