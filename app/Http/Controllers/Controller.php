<?php

namespace App\Http\Controllers;

use App\Traits\AdminLog;
use App\Traits\JsonResponder;

abstract class Controller
{
    use AdminLog, JsonResponder;
}
