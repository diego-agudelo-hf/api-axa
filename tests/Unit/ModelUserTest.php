<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class ModelUserTest extends TestCase
{
    
    public function testUserModelWorks()
    {
        $user = new User();
        $user->name = 'Juan P';
        $user->email = 'Juan.p@example.com';
        $this->assertEquals('Juan P', $user->name);
        $this->assertEquals('Juan.p@example.com', $user->email);
    }
}
