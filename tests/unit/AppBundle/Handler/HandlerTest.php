<?php

class HandlerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function testCanConstruct()
    {
        $repo = $this->getMockRepo();

        $handler = $this->getHandler($repo);

        $this->assertInstanceOf(AppBundle\Handler\ProductsHandler::class, $handler);
    }

    public function testCanGetWithValidId()
    {
        $data = [
            'id' => 1,
            'category' => 'Computer Accessories',
            'name' => 'Basic Mouse',
            'sku' => 'A001',
            'price' => 9.99,
            'quantity' => 1
        ];

        $repo = $this->getMockRepo();

        $repo->expects($this->once())
            ->method('find')
            ->will($this->returnValue($data));

        $handler = $this->getHandler($repo);

        $this->assertEquals(
            $data,
            $handler->get(1)
        );
    }

    public function testCannotGetWithInvalidId()
    {
        $repo = $this->getMockRepo();

        $repo->expects($this->once())
            ->method('find')
            ->will($this->returnValue(null));

        $handler = $this->getHandler($repo);

        $this->assertNull($handler->get(12345));
    }

    public function testCanGetAll()
    {
        $data = [
            [
                'id' => 1,
                'category' => 'Computer Accessories',
                'name' => 'Basic Mouse',
                'sku' => 'A001',
                'price' => 9.99,
                'quantity' => 1
            ],
            [
                'id' => 2,
                'category' => 'Games',
                'name' => 'Pong',
                'sku' => 'A002',
                'price' => 29.99,
                'quantity' => 10
            ]
        ];

        $repo = $this->getMockRepo();

        $repo->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue($data));

        $handler = $this->getHandler($repo);

        $this->assertEquals(
            $data,
            $handler->all(1,1)
        );

    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockRepo()
    {
        return $this->getMockBuilder(AppBundle\Repository\ProductsRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @param $repo
     * @return \AppBundle\Handler\ProductsHandler
     */
    private function getHandler($repo)
    {
        return new AppBundle\Handler\ProductsHandler($repo);
    }
}
