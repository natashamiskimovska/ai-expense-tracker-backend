<?php

namespace App\Services;

use OpenAI;

class AIService
{
    public function analyzeExpenses(array $expenses): array
    {
        $key = config('services.openai.key');

        if (empty($key)) {
            return [
                'summary' => [],
                'explanation' => 'OpenAI API key is not set',
            ];
        }

        $client = OpenAI::client($key);

        // Updated prompt with savings prediction
        $prompt = "Analyze these expenses and return a JSON object with:
    - total_spent
    - top_spending_category {name, amount}
    - alerts [{expense_id, title, amount, alert}]
    - predicted_savings {amount, suggestion}
    Expenses: " . json_encode($expenses);

        try {
            $response = $client->responses()->create([
                'model' => 'gpt-4.1-mini',
                'input' => $prompt,
            ]);

            $text = $response->outputText ?? '';

            $text = preg_replace('/^```json|```$/m', '', $text);

            $result = json_decode($text, true);

            if (!$result || !is_array($result)) {
                return [
                    'summary' => [],
                    'explanation' => $text,
                ];
            }

            $explanation = $result['explanation'] ?? '';
            unset($result['explanation']);

            return [
                'summary' => $result,
                'explanation' => $explanation,
            ];

        } catch (\Throwable $e) {
            return [
                'summary' => [],
                'explanation' => 'AI analysis failed: ' . $e->getMessage(),
            ];
        }
    }
}
