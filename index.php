<?php

use Toanlt\Crawler\Controllers\CrawlerController;
use Toanlt\Crawler\Models\Database;
use Toanlt\Crawler\Router;

require_once __DIR__ . '/vendor/autoload.php';

const DB_HOST = 'localhost';
const DB_NAME = 'crawler';
const DB_USERNAME = 'sammy';
const DB_PASSWORD = 'Toanlt@123';
const BASE_PATH = __DIR__;
const VIEW_PATH = BASE_PATH . '/views';

$route = new Router();

$database = new Database(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

$route->post('/crawler', [new CrawlerController($database), 'handle']);
$route->get('/crawler', [new CrawlerController($database), 'formCrawler']);

$route->dispatch();
