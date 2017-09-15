<?php

namespace AppTest\Unit\Utilities;

use AppTest\BaseCase;

class MailTest extends BaseCase
{
    /**
     * @test
     */
    public function correctly_sets_from_property()
    {
        $mail = static::$container->make('mail');

        $mail->addFrom('info@ssdtutorials.com', 'SSD Tutorials');

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials'
            ],
            $mail->getFrom(),
            "Single Mail::addFrom call failed to set the from property"
        );


        $mail->addFrom('seb@ssdtutorials.com');

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials',
                'seb@ssdtutorials.com' => 'seb@ssdtutorials.com'
            ],
            $mail->getFrom(),
            "Single Mail::addFrom call failed to set the second from property"
        );


        $mail->addFrom(['nathan@ssdtutorials.com' => 'Nathan Sulinski']);

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials',
                'seb@ssdtutorials.com' => 'seb@ssdtutorials.com',
                'nathan@ssdtutorials.com' => 'Nathan Sulinski'
            ],
            $mail->getFrom(),
            "Single Mail::addFrom call failed to set the third from property"
        );


        $mail->addFrom(['chris@ssdtutorials.com']);

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials',
                'seb@ssdtutorials.com' => 'seb@ssdtutorials.com',
                'nathan@ssdtutorials.com' => 'Nathan Sulinski',
                'chris@ssdtutorials.com' => 'chris@ssdtutorials.com'
            ],
            $mail->getFrom(),
            "Single Mail::addFrom call failed to set the fourth from property"
        );


        $mail->addFrom(['pete@ssdtutorials.com', 'josh@ssdtutorials.com']);

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials',
                'seb@ssdtutorials.com' => 'seb@ssdtutorials.com',
                'nathan@ssdtutorials.com' => 'Nathan Sulinski',
                'chris@ssdtutorials.com' => 'chris@ssdtutorials.com',
                'pete@ssdtutorials.com' => 'pete@ssdtutorials.com',
                'josh@ssdtutorials.com' => 'josh@ssdtutorials.com'
            ],
            $mail->getFrom(),
            "Single Mail::addFrom call failed to set the fifth from property"
        );

    }

    /**
     * @test
     */
    public function correctly_sets_to_property()
    {
        $mail = static::$container->make('mail');

        $mail->addTo('info@ssdtutorials.com', 'SSD Tutorials');

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials'
            ],
            $mail->getTo(),
            "Single Mail::addTo call failed to set the to property"
        );


        $mail->addTo('seb@ssdtutorials.com');

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials',
                'seb@ssdtutorials.com' => 'seb@ssdtutorials.com'
            ],
            $mail->getTo(),
            "Single Mail::addTo call failed to set the second to property"
        );


        $mail->addTo(['nathan@ssdtutorials.com' => 'Nathan Sulinski']);

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials',
                'seb@ssdtutorials.com' => 'seb@ssdtutorials.com',
                'nathan@ssdtutorials.com' => 'Nathan Sulinski'
            ],
            $mail->getTo(),
            "Single Mail::addTo call failed to set the third to property"
        );


        $mail->addTo(['chris@ssdtutorials.com']);

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials',
                'seb@ssdtutorials.com' => 'seb@ssdtutorials.com',
                'nathan@ssdtutorials.com' => 'Nathan Sulinski',
                'chris@ssdtutorials.com' => 'chris@ssdtutorials.com'
            ],
            $mail->getTo(),
            "Single Mail::addTo call failed to set the fourth to property"
        );


        $mail->addTo(['pete@ssdtutorials.com', 'josh@ssdtutorials.com']);

        $this->assertEquals(
            [
                'info@ssdtutorials.com' => 'SSD Tutorials',
                'seb@ssdtutorials.com' => 'seb@ssdtutorials.com',
                'nathan@ssdtutorials.com' => 'Nathan Sulinski',
                'chris@ssdtutorials.com' => 'chris@ssdtutorials.com',
                'pete@ssdtutorials.com' => 'pete@ssdtutorials.com',
                'josh@ssdtutorials.com' => 'josh@ssdtutorials.com'
            ],
            $mail->getTo(),
            "Single Mail::addTo call failed to set the fifth to property"
        );

    }

    /**
     * @test
     */
    public function correctly_sets_subject_property()
    {
        $mail = static::$container->make('mail');

        $mail->setSubject('Test subject');

        $this->assertEquals(
            'Test subject',
            $mail->getSubject(),
            "Mail::setSubject call failed to set the subject property"
        );
    }

    /**
     * @test
     */
    public function correctly_sets_body_property()
    {
        $mail = static::$container->make('mail');

        $mail->setBody('Test body');

        $this->assertEquals(
            'Test body',
            $mail->getBody(),
            "Mail::setBody call failed to set the body property"
        );
    }

    /**
     * @test
     */
    public function send_fails_with_invalid_parameters()
    {
        $mail = static::$container->make('mail');

        $this->assertEquals(
            0,
            $mail->send(),
            "Mail::send did not return false with invalid parameters"
        );

        $this->assertEquals(
            "Message is incomplete",
            $mail->exception,
            "Mail::send did not set exception property on failure"
        );
    }

    /**
     * @test
     */
    public function send_succeeds_with_valid_parameters()
    {
        $mail = static::$container->make('mail')
            ->addFrom('info@ssdtutorials.com', 'SSD Tutorials')
            ->addTo('seb@ssdtutorials.com', 'Sebastian Sulinski')
            ->addTo('nathan@ssdtutorials.com', 'Nathan Sulinski')
            ->setSubject('Test email')
            ->setBody('Test body');

        $this->assertEquals(
            2,
            $mail->send(),
            "Mail::send did not return true with valid parameters"
        );
    }
}