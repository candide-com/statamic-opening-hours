<?php

namespace Candide\StatamicOpeningHours\Tests\Unit\Tags;

use Candide\StatamicOpeningHours\Tags\OpeningHoursTag;
use Candide\StatamicOpeningHours\Tests\TestCase;

class OpeningHoursTagTest extends TestCase
{
    protected OpeningHoursTag $tag;

    public function setUp(): void
    {
        parent::setUp();

        $this->tag = new OpeningHoursTag();

        $this->tag->setContext([]);

        /* The test opening hours are defined as follows:
        Monday: closed
        Tuesday: 10:00-12:00 and 13:00-18:00
        Wednesday: 10:00-12:00
        Thursday: 10:00-12:00 and 13:00-18:00
        Friday: 10:00-12:00 and 13:00-18:00
        Saturday: 10:00-18:00
        Sunday: closed
        */
    }

    /** @test */
    public function test_is_open_on() {

        // Is not open on monday
        $this->tag->setParameters(['on' => 'monday']);
        $this->assertFalse($this->tag->isOpen());

        // Is open on tuesday
        $this->tag->setParameters(['on' => 'tuesday']);
        $this->assertTrue($this->tag->isOpen());

        // Is not open on 2022-12-26 (monday)
        $this->tag->setParameters(['on' => '2022-12-26']);
        $this->assertFalse($this->tag->isOpen());

    }

    /** @test */
    public function test_is_open_at() {

        // Is open at 2022-12-22 15:30:00
        $this->tag->setParameters(['at' => '2022-12-22 15:30:00']);
        $this->assertTrue($this->tag->isOpen());

        // Is not open at 2022-12-22 22:00:00
        $this->tag->setParameters(['at' => '2022-12-22 22:00:00']);
        $this->assertFalse($this->tag->isOpen());

        // Is not open at 2022-12-19 15:00:00 (monday)
        $this->tag->setParameters(['at' => '2022-12-19 15:00:00']);
        $this->assertFalse($this->tag->isOpen());

    }

    /** @test */
    public function test_is_closed_on() {

        // Is closed on monday
        $this->tag->setParameters(['on' => 'monday']);
        $this->assertTrue($this->tag->isClosed());

        // Is not closed on tuesday
        $this->tag->setParameters(['on' => 'tuesday']);
        $this->assertFalse($this->tag->isClosed());

        // Is closed on 2022-12-26 (monday)
        $this->tag->setParameters(['on' => '2022-12-26']);
        $this->assertTrue($this->tag->isClosed());

    }

    /** @test */
    public function test_is_closed_at() {

        // Is closed at 2022-12-21 15:30:00
        $this->tag->setParameters(['at' => '2022-12-21 15:30:00']);
        $this->assertTrue($this->tag->isClosed());

        // Is not closed at 2022-12-21 22:00:00
        $this->tag->setParameters(['at' => '2022-12-21 10:30:00']);
        $this->assertFalse($this->tag->isClosed());

        // Is closed at 2022-12-19 15:00:00 (monday)
        $this->tag->setParameters(['at' => '2022-12-19 15:00:00']);
        $this->assertTrue($this->tag->isClosed());

    }

    /** @test */
    public function test_opening_hours_for_day() {

        // No opening hours on monday
        $this->tag->setParameters(['day' => 'monday', 'format' => 'H:i']);
        $this->assertEmpty($this->tag->forDay());

        // Two opening hour ranges on tuesday
        $this->tag->setParameters(['day' => 'tuesday', 'format' => 'H:i']);
        $this->assertCount(2, $this->tag->forDay());

    }

    /** @test */
    public function test_opening_hours_for_week() {

        // Results to 5 days
        $this->tag->setParameters(['format' => 'H:i']);
        $this->assertCount(5, $this->tag->forWeek());

    }

    /** @test */
    public function test_opening_hours_for_date() {

        // Results to 2 opening hour ranges
        $this->tag->setParameters(['date' => '2022-12-22', 'format' => 'H:i']);
        $this->assertCount(2, $this->tag->forDate());

    }

    /** @test */
    public function test_next_open() {

        // Results to 2022-12-21 10:00:00
        $this->tag->setParameters(['date' => '2022-12-20 19:00:00', 'format' => 'Y-m-d H:i:s']);
        $this->assertEquals('2022-12-21 10:00:00', $this->tag->nextOpen());

    }

    /** @test */
    public function test_next_close() {

        // Results to 2022-12-20 18:00:00
        $this->tag->setParameters(['date' => '2022-12-20 15:00:00', 'format' => 'Y-m-d H:i:s']);
        $this->assertEquals('2022-12-20 18:00:00', $this->tag->nextClose());

    }

    /** @test */
    public function test_previous_open() {

        // Results to 2022-12-20 13:00:00
        $this->tag->setParameters(['date' => '2022-12-20 23:00:00', 'format' => 'Y-m-d H:i:s']);
        $this->assertEquals('2022-12-20 13:00:00', $this->tag->previousOpen());

    }

    /** @test */
    public function test_exceptions() {

        // Results to 2022-12-20 13:00:00
        $this->tag->setParameters(['format' => 'H:i']);
        $this->assertCount(2, $this->tag->exceptions());

    }

    /** @test */
    public function test_diff_in_open_hours() {

        // Results to 2
        $this->tag->setParameters(['from' => '2022-12-21 10:00:00', 'to' => '2022-12-21 13:00:00']);
        $this->assertEquals(2, $this->tag->diffInOpenHours());

    }

    /** @test */
    public function test_diff_in_open_minutes() {

        // Results to 120
        $this->tag->setParameters(['from' => '2022-12-21 10:00:00', 'to' => '2022-12-21 13:00:00']);
        $this->assertEquals(120, $this->tag->diffInOpenMinutes());

    }

    /** @test */
    public function test_diff_in_open_seconds() {

        // Results to 7200
        $this->tag->setParameters(['from' => '2022-12-21 10:00:00', 'to' => '2022-12-21 13:00:00']);
        $this->assertEquals(7200, $this->tag->diffInOpenSeconds());

    }

    /** @test */
    public function test_diff_in_closed_hours() {

        // Results to 1
        $this->tag->setParameters(['from' => '2022-12-21 10:00:00', 'to' => '2022-12-21 13:00:00']);
        $this->assertEquals(1, $this->tag->diffInClosedHours());

    }

    /** @test */
    public function test_diff_in_closed_minutes() {

        // Results to 60
        $this->tag->setParameters(['from' => '2022-12-21 10:00:00', 'to' => '2022-12-21 13:00:00']);
        $this->assertEquals(60, $this->tag->diffInClosedMinutes());

    }

    /** @test */
    public function test_diff_in_closed_seconds() {

        // Results to 3600
        $this->tag->setParameters(['from' => '2022-12-21 10:00:00', 'to' => '2022-12-21 13:00:00']);
        $this->assertEquals(3600, $this->tag->diffInClosedSeconds());

    }
}
