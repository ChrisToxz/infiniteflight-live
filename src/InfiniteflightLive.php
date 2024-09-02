<?php

namespace Christoxz\InfiniteflightLive;

use Christoxz\InfiniteflightLive\Http\Response;
use Exception;
use GuzzleHttp\Client;

/**
 *
 */
class InfiniteflightLive
{
    /**
     * @var
     */
    private Client $client;

    /**
     * @var string
     */
    private string $url = 'https://api.infiniteflight.com/public/v2/';

    /**
     * @var
     */
    private string $apiToken;

    /**
     * @param  string|null  $token
     */
    public function __construct(string $token = null)
    {
        $token = $token ?: config('ifapi.key');
        $this->setApiToken($token);
        $this->setClient();
    }

    /**
     * @param $token
     * @return void
     */
    public function setApiToken($token): void
    {
        $this->apiToken = $token;
    }

    /**
     * @return string
     */
    public function getApiToken(): string | null
    {
        return $this->apiToken;
    }

    /**
     * @return $this
     */
    public function setClient(): self
    {
        $this->client = new Client([
            'base_uri' => $this->url,
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '.$this->getApiToken(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return $this;
    }

    /**
     * @throws Exception
     */
    public function makeCall(string $endpoint, string $method = 'get', array $body = [], array $options = []): Response
    {
        if (!in_array($method, ['get', 'post'])) {
            throw new Exception('Invalid method');
        }

        if ($body) {
            $body = ['body' => json_encode($body)];
        }

        $response = $this->client->{$method}($endpoint, $body);

        switch ($response->getStatusCode()) {
//            case 400:
//                throw new Exception("Bad Request");
            case 401:
                throw new Exception("Unauthorized");
            case 404:
                throw new Exception("Endpoint `{$endpoint}` not found");
        }

        return new Response($response);
    }


    /**
     * Retrieve active sessions (servers) in Infinite Flight.
     * https://infiniteflight.com/guide/developer-reference/live-api/sessions
     * @throws Exception
     */
    public function getSessions(): Response
    {
        return $this->makeCall(endpoint: "sessions");
    }

    /**
     * Retrieve a list of all flights for a session.
     * https://infiniteflight.com/guide/developer-reference/live-api/flights
     * @throws Exception
     */
    public function getFlights(string $sessionId): Response
    {
        return $this->makeCall(endpoint: "sessions/{$sessionId}/flights");
    }

    /**
     * Retrieve the flown route of a specific flight with position, altitude, speed and track information at different points in time.
     * https://infiniteflight.com/guide/developer-reference/live-api/flight-route
     * @throws Exception
     */
    public function getFlightRoute(string $sessionId, string $flightId): Response
    {
        return $this->makeCall(endpoint: "sessions/{$sessionId}/flights/{$flightId}/route");
    }


    /**
     * Retrieve the flight plan for a specific active flight.
     * https://infiniteflight.com/guide/developer-reference/live-api/flight-plan
     * @param  string  $sessionId
     * @param  string  $flightId
     * @return Response
     * @throws Exception
     */
    public function getFlightPlan(string $sessionId, string $flightId): Response
    {
        return $this->makeCall(endpoint: "session/{sessionId}/flights/{$flightId}/flightplan");
    }

    /**
     * @return void
     */
    public function getActiveAtc()
    {
    }

    /**
     * Retrieve the flight plan for a specific active flight.
     * https://infiniteflight.com/guide/developer-reference/live-api/flight-plan
     * @param  array  $userIds
     * @param  array  $discourseNames
     * @param  array  $userHashes
     * @return Response
     * @throws Exception
     */
    public function getUserStats(array $userIds = [], array $discourseNames = [], array $userHashes = []): Response
    {
        return $this->makeCall(endpoint: "users", method: "post", body: [
            "userIds" => $userIds,
            "discourseNames" => $discourseNames,
            "userHashes" => $userHashes,
        ]);
    }

    /**
     * Retrieve the full grade table and detailed statistics for a user.
     * https://infiniteflight.com/guide/developer-reference/live-api/user-grade
     * @param  string  $userId
     * @return Response
     * @throws Exception
     */
    public function getUserGrade(string $user)
    {
        if (!\Illuminate\Support\Str::isUuid($user)) {
            $user = $this->getUserStats(discourseNames: [$user])->getResult()[0]['userId'];
        }
        return $this->makeCall(endpoint: "users/{$user}");
    }


    /**
     * Retrieve the ATIS for an airport on a specific server if it is active.
     * https://infiniteflight.com/guide/developer-reference/live-api/atis
     * @return void
     */
    public function AirportAtis()
    {
    }

    /**
     * Retrieve active ATC status information for an airport, and the number of inbound and outbound aircraft.
     * https://infiniteflight.com/guide/developer-reference/live-api/atis
     */
    public function getAirportStatus()
    {
    }

    public function getWorldStatus()
    {
    }

    public function getOceanicTracks()
    {
    }

    public function getUserFlights()
    {

    }

    public function getUserFlight()
    {
    }

    public function getUserAtcSessions()
    {
    }

    public function getUserAtcSession()
    {
    }

    public function getNotams()
    {
    }

    public function getAllAircraft()
    {
        return $this->makeCall(endpoint: "aircraft");
    }

    public function getAircraftLiveries(string $aircraftId)
    {
        return $this->makeCall(endpoint: "aircraft/{$aircraftId}/liveries");
    }

    public function getAllLiveries()
    {
        return $this->makeCall(endpoint: "aircraft/liveries");
    }

    public function get3DAirports()
    {
    }

    public function getAirport()
    {
    }

}
