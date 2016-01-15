<?php
namespace WebStream\Test\UnitTest;

/**
 * Mock Builder for Doctrine objects
 * https://gist.github.com/gnutix/7746893
 */
class TestDatabaseMock extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Doctrine\ORM\EntityManager|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getEntityManagerMock()
    {
        $mock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'getConnection',
                    'getClassMetadata',
                    'close',
                ]
            )
            ->getMock();
        $mock->expects($this->any())
            ->method('getConnection')
            ->will($this->returnValue($this->getConnectionMock()));
        $mock->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue($this->getClassMetadataMock()));
        return $mock;
    }
    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getClassMetadataMock()
    {
        $mock = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadataInfo')
            ->disableOriginalConstructor()
            ->setMethods(['getTableName'])
            ->getMock();
        $mock->expects($this->any())
            ->method('getTableName')
            ->will($this->returnValue('{tableName}'));
        return $mock;
    }
    /**
     * @return \Doctrine\DBAL\Platforms\AbstractPlatform|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getDatabasePlatformMock()
    {
        $mock = $this->getAbstractMock(
            'Doctrine\DBAL\Platforms\AbstractPlatform',
            [
                'getName',
                'getTruncateTableSQL',
            ]
        );
        $mock->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('mysql'));
        $mock->expects($this->any())
            ->method('getTruncateTableSQL')
            ->with($this->anything())
            ->will($this->returnValue('#TRUNCATE {table}'));

        return $mock;
    }
    /**
     * @return \Doctrine\DBAL\Connection|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getConnectionMock()
    {
        $mock = $this->getMockBuilder('Doctrine\DBAL\Connection')
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'beginTransaction',
                    'commit',
                    'rollback',
                    'prepare',
                    'query',
                    'executeQuery',
                    'executeUpdate',
                    'getDatabasePlatform',
                    'inTransaction',
                    'isTransactionActive',
                    'isConnected'
                ]
            )
            ->getMock();
        $mock->expects($this->any())
            ->method('prepare')
            ->will($this->returnValue($this->getStatementMock()));
        $mock->expects($this->any())
            ->method('query')
            ->will($this->returnValue($this->getStatementMock()));
        $mock->expects($this->any())
            ->method('getDatabasePlatform')
            ->will($this->returnValue($this->getDatabasePlatformMock()));
        $mock->expects($this->any())
            ->method('inTransaction')
            ->will($this->returnValue(true));
        $mock->expects($this->any())
            ->method('isTransactionActive')
            ->will($this->returnValue(true));
        $mock->expects($this->any())
            ->method('isConnected')
            ->will($this->returnValue(false));

        return $mock;
    }
    /**
     * @return \Doctrine\DBAL\Driver\Statement|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getStatementMock()
    {
        $mock = $this->getAbstractMock(
            'Doctrine\DBAL\Driver\Statement', // In case you run PHPUnit <= 3.7, use 'Mocks\DoctrineDbalStatementInterface' instead.
            [
                'bindValue',
                'execute',
                'rowCount',
                'fetchColumn',
                'getWrappedStatement'
            ]
        );
        $mock->expects($this->any())
            ->method('fetchColumn')
            ->will($this->returnValue(1));
        $mock->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(true));
        $mock->expects($this->any())
            ->method('rowCount')
            ->will($this->returnValue(1));
        $mock->expects($this->any())
            ->method('getWrappedStatement')
            ->will($this->returnValue($mock));

        return $mock;
    }

    public function getXmlMock()
    {
        $mock = $this->getMockBuilder('SimpleXMLElement')
            ->disableOriginalConstructor()
            ->setMethods(
                ['xpath']
            )
            ->getMock();

        $mockXmlObject = new class()
        {
            public function __call($name, $args) {}
        };

        $mock->expects($this->any())
            ->method('xpath')
            ->will($this->returnValue($mockXmlObject));

        return $mock;
    }

    /**
     * @param string $class   The class name
     * @param array  $methods The available methods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAbstractMock($class, array $methods)
    {
        return $this->getMockForAbstractClass(
            $class,
            [],
            '',
            true,
            true,
            true,
            $methods,
            false
        );
    }
}
