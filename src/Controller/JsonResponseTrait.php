<?php
namespace App\Controller;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait JsonResponseTrait
{

    private function jsonResponseError(
        string $message = "Internal Error",
        string $code = 'internal_error',
        array $data = [],
        int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $headers = []
    ){
        return new JsonResponse(
            $this->serializer->serialize([
                'status' => $code,
                'message' => $message,
                'data' => $data,
            ], 'json'),
            $httpCode,
            $headers,
            true
        );
    }

    private function jsonResponse(
        $data = [], 
        int $httpCode = Response::HTTP_OK, 
        array $headers = []
    ){
        return new JsonResponse(
            $this->serializer->serialize(
                [
                    'status' => 'ok',
                    'data' => $data,
                ], 
                'json', 
                [
                    AbstractNormalizer::IGNORED_ATTRIBUTES => [
                        '__cloner__',
                        '__initializer__',
                        '__isInitialized__',
                        'lazyPropertiesNames',
                        'lazyPropertiesDefaults',
                        'transitions',
                    ]
                ]
            ),
            $httpCode,
            $headers,
            true
        );
    }

}