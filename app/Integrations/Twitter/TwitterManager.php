<?php

namespace App\Integrations\Twitter;

use App\Models\Account;
use Illuminate\Http\Client\Response;

class TwitterManager
{
    private function request(Account $account, $method, $url, $data = []): Response
    {
        $authorizationHeaders = collect([
            'oauth_consumer_key' => config('services.twitter.client_id'),
            'oauth_nonce' => \Str::random(32),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => now()->timestamp,
            'oauth_token' => $account->twitter_token,
            'oauth_version' => '1.0',
        ]);

        $url = \Spatie\Url\Url::fromString($url);
        $data = array_filter($data);

        $parameterString = $authorizationHeaders->merge($url->getAllQueryParameters())->merge($data)
            ->mapWithKeys(function ($value, $key) {
                return [
                    rawurlencode($key) => rawurlencode($value)
                ];
            })
            ->sortBy(fn ($value, $key) => $key)
            ->map(fn ($value, $key) => "$key=$value")
            ->join('&');

        $trimmedUrl = $url->getScheme() . '://' . $url->getHost() . $url->getPath();
        $payload = strtoupper($method) . '&' . rawurlencode($trimmedUrl) . '&' . rawurlencode($parameterString);

        $signingSecret = rawurlencode(config('services.twitter.client_secret')) . '&' . rawurlencode($account->twitter_token_secret);

        $signed = hash_hmac('sha1', $payload, $signingSecret, true);
        $encodedSigned = base64_encode($signed);

        $authorizationHeaders = $authorizationHeaders->merge([
            'oauth_signature' => $encodedSigned
        ])->sortBy(fn ($value, $key) => $key);

        $oauthHeaders = $authorizationHeaders
            ->map(function ($value, $key) {
                return rawurlencode($key) . '="' . rawurlencode($value) . '"';
            })
            ->join(', ');

        $lowercaseMethod = strtolower($method);

        $response = \Http::withHeaders(['Authorization' => "OAuth $oauthHeaders",])->{$lowercaseMethod}($url, $data);

        if ($response->json('errors')) {
            throw new \Exception($response->json('errors.0.message') ?? $response->json('errors.0.detail'));
        }

        return $response;
    }

    public function tweet(Account $account, $body)
    {
        $response = $this->request($account, 'POST', 'https://api.twitter.com/2/statuses/update.json', [
            'status' => $body,
        ]);

        return $response;
    }

    public function getTweets(Account $account, array $ids): array
    {
        $response = $this->request($account, 'GET', 'https://api.twitter.com/2/tweets', [
            'ids' => implode(',', $ids),
        ]);

        return $response->json('data');
    }

    public function getTweet(Account $account, string $id): ?array
    {
        $response = $this->request($account, 'GET', 'https://api.twitter.com/2/tweets', [
            'ids' => $id,
        ]);

        return $response->json('data.0');
    }

    public function getUserId(Account $account, string $username): ?string
    {
        $response = $this->request($account, 'GET', 'https://api.twitter.com/2/users/by', [
            'usernames' => $username,
        ]);

        return $response->json('data.0.id');
    }

    public function getUserTimeline(Account $account, $author = null, $paginationToken = null): ?array
    {
        if (! $author) {
            $author = $account->twitter_id;
        }

        if (! is_numeric($author)) {
            $author = $this->getUserId($account, $author);
        }

        $response = $this->request($account, 'GET', "https://api.twitter.com/2/users/{$author}/tweets", [
            'max_results' => 100,
            'pagination_token' => $paginationToken,
        ]);

        return [
            'tweets' => $response->json('data'),
            'paginationToken' => $response->json('meta.next_token')
        ];
    }
}
