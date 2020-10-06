<?php

namespace Rogue\Services;

use Rogue\Models\Signup;
use RuntimeException;

class Gambit
{
    /**
     * The HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Create a new Gambit API client.
     */
    public function __construct()
    {
        $config = config('services.gambit');

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $config['url'],
            'auth' => [$config['user'], $config['password']],
        ]);
    }

    /**
     * Relay a signup event to Gambit so that we can switch
     * the user's conversation topic.
     *
     * @see https://git.io/JUAiB
     *
     * @param Signup $signup
     */
    public function relaySignup(Signup $signup)
    {
        $payload = [
            'userId' => $signup->northstar_id,
            'campaignId' => $signup->campaign_id,
        ];

        if (!config('features.gambit')) {
            info('Signup would have been sent to Gambit.', [
                'id' => $signup->id,
                'payload' => $payload,
            ]);

            return;
        }

        $this->client->post('/api/v2/messages?origin=signup', [
            'json' => $payload,
        ]);

        info('Signup sent to Gambit.', ['id' => $signup->id]);
    }
}