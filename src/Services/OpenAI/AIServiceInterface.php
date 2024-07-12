<?php

namespace App\Services\OpenAI;

use App\Enum\AIModelEnum;

interface AIServiceInterface
{
    public function ask(string $prompt, AIModelEnum $model): string;
}