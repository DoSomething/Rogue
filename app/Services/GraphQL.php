<?php

namespace Rogue\Services;

use Illuminate\Support\Facades\Log;
use Softonic\GraphQL\ClientBuilder;

class GraphQL
{
    /**
     * Build a new GraphQL client.
     */
    public function __construct()
    {
        $this->client = ClientBuilder::build(config('services.graphql.url'));
    }

    /**
     * Run a GraphQL query using the client and return the data result.
     *
     * @param  $query     String
     * @param  $variables Array
     * @return array
     */
    public function query($query, $variables)
    {
        $response = $this->client->query($query, $variables);

        return $response ? $response->getData() : [];
    }

    /**
     * Query for a CampaignWebsite by campaignId field.
     *
     * @param  $campaignId String
     * @return array
     */
    public function getCampaignWebsiteByCampaignId($campaignId)
    {
        $query = '
        query GetCampaignWebsiteByCampaignId($campaignId: String!) {
          campaignWebsiteByCampaignId(campaignId: $campaignId) {
            title
            slug
          }
        }';

        $variables = [
            'campaignId' => $campaignId,
        ];

        return $this->query($query, $variables);
    }
}
