<?php

namespace App\Services\MicrosoftGraph;

use App\Services\Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class GraphService implements IGraphService
{

    private static GraphService|null $instance = null;

    private string $tenant_id;
    private string $client_id;
    private string $client_secret;

    private string $API_VERSION;
    private array $patterns = [];
    private array $body = [];
    private array $headers = [];
    private string $api_url = "";

    private string|null $token = "";
    protected Client|null $guzzle = null;
    private bool $init = false;

    protected string $returnType;

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
        if (!self::$instance) {
            self::$instance = new GraphService($tenant_id, $client_id, $client_secret);
        }
        return self::$instance;
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
        $this->api_url = self::BASE_URL . $this->API_VERSION . self::API_SEPARATOR . join(self::API_SEPARATOR, $this->patterns);
        $this->headers = [
            self::HEADER_AUTHORIZATION => self::HEADER_BEARER_PREFIX . $this->token,
        ];
        Log::debug('GraphService: api_url=' . $this->getApiUrl());
        return $this;
    }

    public function get(): mixed
    {
        // TODO: Implement get() method.
        try {
            $response = $this->guzzle->get($this->getApiUrl(), [
                self::HEADERS => $this->getHeaders()
            ])->getBody()->getContents();
            return $this->processResponse($response);
        } catch (Exception|GuzzleException $exception) {
            return null;
        }
    }

    public function post(): mixed
    {
        // TODO: Implement post() method.
        try {
            $response = $this->guzzle->post($this->getApiUrl(), [
                self::HEADERS => $this->getHeaders(),
                self::BODY => $this->getBody(),
            ])->getBody()->getContents();
            return $this->processResponse($response);
        } catch (Exception|GuzzleException $exception) {
            return null;
        }
    }

    public function builder(): IGraphService
    {
        // TODO: Implement clean() method.
        $this->patterns = [];
        $this->body = [];
        $this->api_url = "";
        $this->headers = [];
        $this->returnType = "";
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
        return $this->api_url;
    }

    public function getHeaders(): array
    {
        // TODO: Implement getHeaders() method.
        return $this->headers;
    }

    public function drive(): IGraphService
    {
        // TODO: Implement drive() method.
        $this->patterns[] = self::DRIVE;
        return $this;
    }

    public function items($item_id = false): IGraphService
    {
        // TODO: Implement items() method.
        $this->patterns[] = self::ITEMS;
        if ($item_id != false) {
            $this->patterns[] = $item_id;
        }
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

    public function createUploadSession(): IGraphService
    {
        // TODO: Implement createUploadSession() method.
        $this->patterns[] = self::CREATE_UPLOAD_SESSION;
        return $this;
    }

    public function getBody(): mixed
    {
        // TODO: Implement getBody() method.
        return $this->body;
    }

    public function addBody(string $key, mixed $value)
    {
        // TODO: Implement addBody() method.
        $this->body[$key] = $value;
    }

    public function drives(string $search = ""): IGraphService
    {
        // TODO: Implement drives() method.
        $this->patterns[] = self::DRIVES;
        if (!!$search) {
            $this->patterns[] = $search;
        }
        return $this;
    }

    public function processResponse(mixed $response): mixed
    {
        // TODO: Implement processResponse() method.
        try {
            $data = json_decode($response, true);
            if (!$this->returnType) {
                return $data;
            } else if (!isset($data[self::KEY_VALUE])) {
                $data = new ($this->returnType)($data);
            } else if (!is_array($data[self::KEY_VALUE])) {
                $data = new ($this->returnType)($data[self::KEY_VALUE]);
            } else {
                $result = [];
                foreach ($data as $value) {
                    $tmp = new($this->returnType)($value);
                    $result[] = $tmp;
                }
                $data = $result;
            }
        } catch (Exception $exception) {
            return null;
        }
        return $data;
    }

    public function children(): IGraphService
    {
        // TODO: Implement children() method.
        $this->patterns[] = self::CHILDREN;
        return $this;
    }
}
