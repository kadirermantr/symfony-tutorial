<?php

namespace App\Enum;

enum AIModelEnum: string
{
    case MODEL_GPT_4 = 'gpt-4';
    case MODEL_GPT_4O = 'gpt-4o';
    case MODEL_GPT_4_TURBO = 'gpt-4-turbo';
}
