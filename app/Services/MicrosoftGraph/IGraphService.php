<?php

namespace App\Services\MicrosoftGraph;

interface IGraphService
{
    const API_VERSION_1 = "v1.0";
    const API_VERSION_BETA = "beta";
    const BASE_URL = "https://graph.microsoft.com/";

    const HEADER_AUTHORIZATION = "Authorization";
    const HEADER_BEARER_PREFIX = "Bearer ";
    const HEADERS = "headers";
    const BODY = "body";

    const USERS = "users";
    const DRIVE = "drive";
    const DRIVES = "drives";
    const ITEMS = "items";
    const ROOT = "root";
    const CONTENT = "content";
    const CREATE_UPLOAD_SESSION = "createUploadSession";
    const CHILDREN = "children";

    const API_SEPARATOR = "/";

    const KEY_VALUE = "value";
    const KEY_ODATA_CONTEXT = "@odata.context";

    public function init();

    public static function createClient(string $tenant_id, string $client_id, string $client_secret): IGraphService;

    public function acquireToken(): bool;

    public function users($search): IGraphService;

    public function buildRequest(string $returnType): IGraphService;

    public function get(): mixed;

    public function post(): mixed;

    public function builder(): IGraphService;

    public function setApiVersion($version);

    public function getApiUrl(): string;

    public function getHeaders(): array;

    public function drive(): IGraphService;

    public function items($item_id): IGraphService;

    public function content(): IGraphService;

    public function root(): IGraphService;

    public function createUploadSession(): IGraphService;

    public function getBody(): mixed;

    public function addBody(string $key, mixed $value);

    public function drives(string $search): IGraphService;

    public function processResponse(mixed $response): mixed;

    public function children(): IGraphService;
}
