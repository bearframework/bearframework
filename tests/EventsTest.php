<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class EventsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function testBasics()
    {
        $object = new class
        {
            use \BearFramework\EventsTrait;
        };

        $result = '';

        $listener1 = function () use (&$result) {
            $result .= '1';
        };
        $listener2 = function () use (&$result) {
            $result .= '2';
        };

        $object->addEventListener('done', $listener1);
        $object->addEventListener('done', $listener2);

        $this->assertTrue($result === '');

        $object->dispatchEvent('other');
        $this->assertTrue($result === '');

        $object->dispatchEvent('done');
        $this->assertTrue($result === '12');

        $object->removeEventListener('done', $listener1);
        $this->assertTrue($result === '12');
        $object->dispatchEvent('done');
        $this->assertTrue($result === '122');

        $object->removeEventListener('done', $listener1);
        $this->assertTrue($result === '122');
        $object->dispatchEvent('done');
        $this->assertTrue($result === '1222');

        $object->removeEventListener('done', $listener2);
        $this->assertTrue($result === '1222');
        $object->dispatchEvent('done');
        $this->assertTrue($result === '1222');
    }

    /**
     * 
     */
    function testEventArgument()
    {
        $object = new class
        {
            use \BearFramework\EventsTrait;
        };

        $result = '';

        $object->addEventListener('done', function () use (&$result) {
            $result .= '1';
        });
        $object->dispatchEvent('done');

        $this->assertTrue($result === '1');
    }

    /**
     * 
     */
    function testHasEventListeners()
    {
        $object = new class
        {
            use \BearFramework\EventsTrait;
        };

        $result = [
            'event1Dispached' => 0,
            'event1Handled' => 0,
            'event2Dispached' => 0,
        ];

        $object->addEventListener('event1', function () use (&$result) {
            $result['event1Handled'] = 1;
        });
        if ($object->hasEventListeners('event1')) {
            $result['event1Dispached'] = 1;
            $object->dispatchEvent('event1');
        }
        if ($object->hasEventListeners('event2')) {
            $result['event2Dispached'] = 1;
            $object->dispatchEvent('event2');
        }

        $this->assertEquals($result['event1Dispached'], 1);
        $this->assertEquals($result['event1Handled'], 1);
        $this->assertEquals($result['event2Dispached'], 0);
    }

    /**
     * 
     */
    function testCustomData()
    {
        $object = new class
        {
            use \BearFramework\EventsTrait;
        };

        $details = new class
        {
            public $value = '1';
        };

        $result = '';

        $object->addEventListener('done', function ($details) use (&$result) {
            $result .= $details->value;
        });
        $object->dispatchEvent('done', $details);

        $this->assertTrue($result === '1');
    }

    /**
     * 
     */
    function testDispatcherArgument1()
    {
        $object = new class
        {
            use \BearFramework\EventsTrait;
        };

        $object->addEventListener('test', function ($eventDetails, $dispatcher) {
            $dispatcher->continue();
            $eventDetails->value .= '1';
        });

        $object->addEventListener('test', function ($eventDetails, $dispatcher) {
            $eventDetails->value .= '2';
        });

        $eventDetails = new stdClass();
        $eventDetails->value = '';

        $object->dispatchEvent('test', $eventDetails, [
            'defaultListener' => function ($eventDetails) {
                $eventDetails->value .= '3';
            }
        ]);

        $this->assertEquals($eventDetails->value, '231');
    }

    /**
     * 
     */
    function testDispatcherArgument2()
    {
        $object = new class
        {
            use \BearFramework\EventsTrait;
        };

        $object->addEventListener('test', function ($eventDetails, $dispatcher) {
            $eventDetails->value .= '1';
            $dispatcher->cancel();
        });

        $eventDetails = new stdClass();
        $eventDetails->value = '';

        $object->dispatchEvent('test', $eventDetails, [
            'defaultListener' => function ($eventDetails) {
                $eventDetails->value .= '3';
            }
        ]);

        $this->assertEquals($eventDetails->value, '1');
    }

    /**
     * 
     */
    function testDispatcherArgument3()
    {
        $object = new class
        {
            use \BearFramework\EventsTrait;
        };

        $object->addEventListener('test', function ($eventDetails, $dispatcher) {
            $eventDetails->value .= '1';
        });

        $object->addEventListener('test', function ($eventDetails, $dispatcher) {
            $dispatcher->continue();
            $eventDetails->value .= '2';
        });

        $eventDetails = new stdClass();
        $eventDetails->value = '';

        $object->dispatchEvent('test', $eventDetails);

        $this->assertEquals($eventDetails->value, '12');
    }
}
