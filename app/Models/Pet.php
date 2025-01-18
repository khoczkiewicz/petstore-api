<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Pet
{
    private static $apiBaseUrl = 'https://petstore.swagger.io/v2/pet';

    private static function makeRequest(string $method, string $endpoint = '', array $data = []): ?array
    {
        try {
            $url = self::$apiBaseUrl . ($endpoint ? '/' . $endpoint : '');
            $response = Http::$method($url, $data);

            if ($response->successful() && is_array($response->json())) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error("API Request Error [{$method} {$url}]", [
                'data' => $data,
                'exception' => $e->getMessage(),
            ]);
        }

        return null;
    }

    private static function transform(array $pet): array
    {
        return [
            'id' => $pet['id'] ?? null,
            'name' => $pet['name'] ?? 'Unnamed',
            'status' => $pet['status'] ?? 'Unknown',
            'category' => $pet['category']['name'] ?? 'N/A',
            'tags' => collect($pet['tags'] ?? [])->pluck('name')->toArray(),
        ];
    }

    public static function getByStatus(string $status): array
    {
        $response = self::makeRequest('get', 'findByStatus', ['status' => $status]);

        if ($response) {
            return collect($response)->map(fn($pet) => self::transform($pet))->toArray();
        }

        return [];
    }

    public static function create(array $data): ?array
    {
        $response = self::makeRequest('post', '', $data);

        return $response ? self::transform($response) : null;
    }

    public static function getById(int $id): ?array
    {
        $response = self::makeRequest('get', (string) $id);

        return $response ? self::transform($response) : null;
    }

    public static function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $response = self::makeRequest('put', '', $data);

        return (bool) $response;
    }

    public static function delete(int $id): bool
    {
        return (bool) self::makeRequest('delete', (string) $id);
    }
}
