<?php

class EstrattoreTest extends PHPUnit\Framework\TestCase
{
    public function testOSterone()
    {
        $estr = new Estrattore(MyFirstEntity::class);
        $annotations = $estr->getVo();

        $email = [
            '_fields' => [
                'email' => [
                    'default' => 'sensorario@gmail.com',
                ]
            ]
        ];

        $this->assertEquals(
            $email,
            $annotations
        );
    }

    public function testHardO()
    {
        $estr = new Estrattore(AnnotatedClass::class);
        $annotations = $estr->getVo();

        $email = [
            '_fields' => [
                'campo' => [
                    'ciaone' => 'proprio'
                ]
            ]
        ];

        $this->assertEquals(
            $email,
            $annotations
        );
    }
}

class MyFirstEntity
{
    /**
     * @Json({
     *      "default": "sensorario@gmail.com"
     * })
     */
    private $email;
}
