<?php

namespace Toanlt\Crawler\Controllers;

use Exception;
use Toanlt\Crawler\Factories\ParserFactory;
use Toanlt\Crawler\Models\Database;

class CrawlerController extends BaseController
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $url = $_POST['url'] ?? '';
            $parser = ParserFactory::make($url);
            $data = $parser->parse();

            if ($data !== null) {
                $inserted = $this->database->insert('posts', $data);
                if ($inserted === false) {
                    echo "Insert to database failed";
                } else {
                    echo "Insert to database success";
                }
            } else {
                echo "Empty data";
            }
        } catch (Exception $e) {
            var_dump($e->getMessage(), $parser);
            echo "Crawl failed";
        }
    }

    public function formCrawler(): void
    {
        $this->view('index.php');
    }
}