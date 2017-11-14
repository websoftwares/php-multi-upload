<?php
declare(strict_types=1);
namespace VC4A\Test;

use PDO;

class MockPdo extends PDO
{
    public function __construct()
    {
    }
}
