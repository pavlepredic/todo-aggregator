<?php declare(strict_types=1);

namespace App\UI\Factory;

use Symfony\Component\HttpFoundation\Response;

class SlackResponseFactory
{
    public function generateResponse(string $text): Response
    {
        $responseData = [
            'response_type' => 'ephemeral',
            'text' => $text,
        ];

        return new Response(
            json_encode($responseData),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}
