<?php

namespace App\Services;

use JsonSerializable;
use Microsoft\Graph\Model\User;

interface IGraphService
{
    const API_VERSION_1 = "v1.0";
    const API_VERSION_BETA = "beta";
    const BASE_URL = "https://graph.microsoft.com/";

    const HEADER_AUTHORIZATION = "Authorization";
    const HEADER_BEARER_PREFIX = "Bearer ";
    const HEADERS = "headers";

    const USERS = "users";
    const DRIVE = "drive";
    const ITEMS = "items";
    const ROOT = "root";
    const CONTENT = "content";
    const CREATE_UPLOAD_SESSION = "createUploadSession";

    const API_SEPERATOR = "/";

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
}
