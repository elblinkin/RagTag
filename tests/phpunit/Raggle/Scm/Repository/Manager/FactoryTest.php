<?php

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

class Raggle_Scm_Repository_Manager_FactoryTest extends PHPUnit_Framework_TestCase {

    function testCreate() {
        $web_json = '{'
            . '"name": "web",'
            . '"type": "git",'
            . '"url": "git://github.com/Engineering/Web.git",'
            . '"branches": [ "master" ]'
            . '}';
        $schema_json = '{'
            . '"name": "schema",'
            . '"type": "git",'
            . '"url": "git://github.com/Engineering/Schema.git",'
            . '"branches": [ "master" ]'
            . '}';
            
        vfsStream::setup('factoryTest');
        $config_dir =  vfsStream::newDirectory('config')
            ->at(vfsStreamWrapper::getRoot());
        $scm_dir =  vfsStream::newDirectory('scm')
            ->at($config_dir);
        $web_file = vfsStream::newFile('web.json')
            ->withContent($web_json)
            ->at($scm_dir);
        $schema_file = vfsStream::newFile('schema.json')
            ->withContent($schema_json)
            ->at($scm_dir);
            
        $web_repo = $this->getMock('Raggle_Scm_Repository');
        $web_repo
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('web'));
            
        $schema_repo = $this->getMock('Raggle_Scm_Repository');
        $schema_repo
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('schema'));
            
        $repository_parser = $this->getMockBuilder('Raggle_Scm_Repository_Parser')
            ->disableOriginalConstructor()
            ->getMock();
        $repository_parser
            ->expects($this->atLeastOnce())
            ->method('parse')
            ->will(
                $this->returnValueMap(
                    array(
                        array(
                            vfsStream::url('factoryTest/config/scm/web.json'),
                            $web_repo
                        ),
                        array(
                            vfsStream::url('factoryTest/config/scm/schema.json'),
                            $schema_repo
                        )
                    )
                )
            );
        
        $factory = new Raggle_Scm_Repository_Manager_Factory($repository_parser);
        $manager = $factory->create(vfsStream::url('factoryTest/config/scm'));
        
        $this->assertEquals($web_repo, $manager->getRepository('web'));
        $this->assertEquals($schema_repo, $manager->getRepository('schema'));
    }
}