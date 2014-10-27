<?php

require_once '../src/autoload.php';

use crawler\Mp3WebCrawler;
use crawler\ImageWebCrawler;
use crawler\InMemoryCrawlRepository;

$targetUrl = "want-to-crawl.com";

/* mp3's example */
$memoryCrawlRepository = new InMemoryCrawlRepository();

$mp3crawler = new Mp3WebCrawler([$targetUrl],$memoryCrawlRepository,1);
$mp3crawler->process();

echo "saved mp3's: \n";
print_r($memoryCrawlRepository->getUrlStack());

/* images example */
$memoryCrawlRepository->clear();
$imageCrawler = new ImageWebCrawler([$targetUrl],$memoryCrawlRepository,1);
$imageCrawler->process();

echo "saved images: \n";
print_r($memoryCrawlRepository->getUrlStack());