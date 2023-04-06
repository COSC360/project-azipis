<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require(__DIR__.'/../functions.php');

class FunctionsTest extends PHPUnit\Framework\TestCase {
    
    public function testIsValidIntParam() {
        $this->assertTrue(is_valid_int_param(5, 1, 10));
        $this->assertTrue(is_valid_int_param(1, 1, 10));
        $this->assertTrue(is_valid_int_param(10, 1, 10));
        $this->assertFalse(is_valid_int_param(0, 1, 10));
        $this->assertFalse(is_valid_int_param(11, 1, 10));
    }
    
}
