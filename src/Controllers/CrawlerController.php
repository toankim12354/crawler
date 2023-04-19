<?php

namespace Toanlt\Crawler\Controllers;

use Exception;
use Toanlt\Crawler\Factories\ParserFactory;
use Toanlt\Crawler\Models\Database;
use Toanlt\Crawler\Models\DatabaseInterface;

class CrawlerController extends BaseController
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
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
                $inserted = $this->database->insert('wrapper', $data);
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

    /**
     * @return void
     */
    public function formCrawler(): void
    {
        $this->view('index.php');
    }
}