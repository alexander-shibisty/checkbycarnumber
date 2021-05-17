<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use Arr;

class CreateSitemap extends Command
{
    private $pathToXmlsFiles = null;
    private $maxLinksOnXmlFile = 10000;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for generator new sitemaps files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->pathToXmlsFiles = public_path('xmls');
        
        try
        {
            $this->makeXmlsDirIfNeed($this->pathToXmlsFiles);
        } catch(Exaption $error) {
            Log::error($error->getMessage());
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pathToXmlsFiles = $this->pathToXmlsFiles;
        $hrefs = [
            [
                'loc' => url('/'),
                'lastmod' => date('c'),
            ]
        ];

        $content = Car::take(1000);
        foreach($content as $car)
        {
            $date = date('c');

            if($car->created_at)
            {
                $date = date('c', strtotime($car->created_at));
            }

            $hrefs[] = [
                'loc' => url('/nomer/' . $car->slug),
                'lastmod' => $date,
            ];
        } unset($date, $page);

        ///

        $pages = [];
        $iteration = 0;
        $page = 0;
        foreach($hrefs as $index => $href)
        {
            $pages[$page][] = $href;

            $iteration++;
            if($iteration >= $this->maxLinksOnXmlFile)
            {
                $iteration = 0;
                $page++;
            }
        }

        foreach($pages as $pageNumber => $hrefsArray)
        {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><urlset/>');
            $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

            foreach($hrefsArray as $href)
            {
                $url = $xml->addChild('url');
    
                $url->addChild(
                    'loc', 
                    Arr::get($href, 'loc')
                );
    
                if(Arr::get($href, 'lastmod'))
                {
                    $url->addChild('lastmod', Arr::get($href, 'lastmod'));
                }
    
                $iteration++;
            }

            file_put_contents('compress.zlib://' . $pathToXmlsFiles . '/sitemap_' . $pageNumber . '.xml.gz', $xml->asXML());
        }

        die("Ok\n");
    }

    private function makeXmlsDirIfNeed($pathToDir)
    {
        if(! is_dir($pathToDir))
        {
            if(! mkdir($pathToDir, 0755))
            {
                throw new \Exception('Cannot make dir ' . $pathToDir);
            }
        }
    }
}
