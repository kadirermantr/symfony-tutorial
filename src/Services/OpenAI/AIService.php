<?php

namespace App\Services\OpenAI;

use App\Enum\AIModelEnum;
use OpenAI;
use OpenAI\Client;

class AIService implements AIServiceInterface
{
    public function __construct($apiKey, private Client $client)
    {
        $this->client = OpenAI::client($apiKey);
    }

    public function ask(string $prompt, AIModelEnum $model): string
    {
        $result = $this->client->chat()->create([
            'model' => $model->value,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ]);

        return trim($result->choices[0]->message->content);
    }
}