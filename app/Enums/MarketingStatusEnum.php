<?php

namespace App\Enums;

enum MarketingStatusEnum: string
{
    case CONFIRM = 'CONFIRM';
    case STILL = 'STILL';
    case CANCEL = 'CANCEL';
}
