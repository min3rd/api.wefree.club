<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GraphService implements IGraphService
{

    private string $tenant_id;
    private string $client_id;
    private string $client_secret;

    private string $API_VERSION;
    private array $patterns = [];

    private string|null $token;
    private Client|null $guzzle;
    private bool $init = false;

    private string $returnType;

    /**
     * @param string $tenant_id
     * @param string $client_id
     * @param string $client_secret
     */
    public function __construct(string $tenant_id, string $client_id, string $client_secret)
    {
        $this->tenant_id = $tenant_id;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->API_VERSION = self::API_VERSION_1;

        $this->init();
    }


    public static function token(): ?string
    {
        return static::$token;
    }

    public function init()
    {
        $this->guzzle = new Client();
        $this->init = true;
    }

    public function acquireToken(): bool
    {
        if (!$this->init) {
            $this->init();
        }
        $url = 'https://login.microsoftonline.com/' . $this->tenant_id . '/oauth2/v2.0/token';
        try {
            $token = json_decode($this->guzzle->post($url, [
                'form_params' => [
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'scope' => 'https://graph.microsoft.com/.default',
                    'grant_type' => 'client_credentials',
                ],
            ])->getBody()->getContents());
            $this->token = $token->access_token;
            return true;
        } catch (Exception|GuzzleException $exception) {
        }
        return false;
    }

    public static function createClient(string $tenant_id, string $client_id, string $client_secret): IGraphService
    {
        // TODO: Implement createClient() method.
        return new GraphService($tenant_id, $client_id, $client_secret);
    }

    public static function create()
    {
        return self::createClient(env("GRAPH_TENANT_ID"), env("GRAPH_CLIENT_ID"), env("GRAPH_CLIENT_SECRET"));
    }

    public function users($search): IGraphService
    {
        // TODO: Implement users() method.
        $this->patterns[] = self::USERS;
        $this->patterns[] = $search;
        return $this;
    }

    public function buildRequest(string $returnType = ""): IGraphService
    {
        // TODO: Implement buildRequest() method.
        $this->acquireToken();
        $this->returnType = $returnType;
        return $this;
    }

    public function get(): mixed
    {
        // TODO: Implement get() method.
        try {
            $response = $this->guzzle->get($this->getApiUrl(), [
                self::HEADERS => $this->getHeaders()
            ])->getBody()->getContents();
            $data = json_decode($response);
            if (!$this->returnType) {

            } else {
                $data = new ($this->returnType)($data);
            }
        } catch (Exception|GuzzleException $exception) {
            return null;
        }
        return $data;
    }

    public function post(): mixed
    {
        // TODO: Implement post() method.
        return "";
    }

    public function builder(): IGraphService
    {
        // TODO: Implement clean() method.
        $this->patterns = [];
        return $this;
    }

    public function setApiVersion($version)
    {
        // TODO: Implement setApiVersion() method.
        $this->API_VERSION = $version;
    }

    public function getApiUrl(): string
    {
        // TODO: Implement getApiUrl() method.
        return self::BASE_URL . $this->API_VERSION . self::API_SEPERATOR . join(self::API_SEPERATOR, $this->patterns);
    }

    public function getHeaders(): array
    {
        // TODO: Implement getHeaders() method.
        return [
            self::HEADER_AUTHORIZATION => self::HEADER_BEARER_PREFIX . $this->token,
        ];
    }

    public function drive(): IGraphService
    {
        // TODO: Implement drive() method.
        $this->patterns[] = self::DRIVE;
        return $this;
    }

    public function items($item_id): IGraphService
    {
        // TODO: Implement items() method.
        $this->patterns[] = self::ITEMS;
        return $this;
    }

    public function content(): IGraphService
    {
        // TODO: Implement content() method.
        $this->patterns[] = self::CONTENT;
        return $this;
    }

    public function root(): IGraphService
    {
        // TODO: Implement root() method.
        $this->patterns[] = self::ROOT;
        return $this;
    }
}
