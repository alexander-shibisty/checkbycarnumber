<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class SeoController extends Controller
{
    public function robots() {
        $robotsTxt = "User-agent: *\n";
        $robotsTxt .= "Disallow: /admin/\n";
        $robotsTxt .= "Sitemap: " . url('/sitemap.xml');

        $response = Response::make($robotsTxt, 200);
        $response->header('Content-Type', 'text/plain');

        return $response;
    }

    private $pathToXmlsFiles = null;

    public function __construct() {
        $this->pathToXmlsFiles = public_path('xmls');
    }

    public function sitemap() {
        $pathToXmlsFiles = $this->pathToXmlsFiles;
        $files = scandir($pathToXmlsFiles);

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><sitemapindex/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach($files as $file)
        {
            $filePath = $pathToXmlsFiles . '/' . $file;
            $fileTime = date('c', filemtime($filePath));

            if($file !== '.' && $file !== '..' && preg_match('/\.xml\.gz/', $file))
            {
                $url = $xml->addChild('sitemap');

                $url->addChild('loc', url(config('app.canonical') . '/xmls/' . $file));
                $url->addChild('lastmod', $fileTime);
            }
        }

        return $this->xmlResponse($xml->asXML());
    }

    private function xmlResponse($xml) {
        Header('Content-type: text/xml');
        die($xml);
    }
}
