<?php

namespace Tests\Feature;

use Tests\TestCase;

class DatabaseSafetyTest extends TestCase
{
    public function test_database_is_in_memory(): void
    {
        $this->assertSame('sqlite', config('database.default'));

        $this->assertSame(
            ':memory:',
            config('database.connections.sqlite.database')
        );
    }
}
