<?php

namespace crawler;


abstract class WebCrawler {
    /**
     * @var string[]
     */
    private $crawlUrlStack;

    /**
     * number of urls which will be stored in RAM
     * @var int
     */
    private $maxStackSize = 10000;

    /**
     * number of pages which will be scanned
     * @var int
     */
    private $maxPages;

    /**
     * @var CrawlRepository
     */
    protected $repository;

    /**
     * RegEx Patterns
     */
    private $hrefPattern;
    private $hostPattern;
    private $absoluteUrlPattern;
    private $validCrawlPatterns;

    /**
     * the crawler will start with this stack
     * @param array $crawlUrlStack
     *
     * the crawler will save the result in this repository
     * @param CrawlRepository $repository
     *
     * number of pages the crawler will scan
     * set to "-1" for infinity
     * @param $maxPages
     */
    public function __construct(array $crawlUrlStack,CrawlRepository $repository,$maxPages = -1){
        $this->crawlUrlStack = $crawlUrlStack;
        $this->repository = $repository;
        $this->maxPages = $maxPages;

        // setup patterns
        $this->hrefPattern = new RegExPattern('/<a\s+(?:[^>]*?\s+)?href=["\']((http:\/)?\/[^\'"]*)[\'"]/',1);
        $this->hostPattern = new RegExPattern('/^(http:\/\/([^\/?#]+))(?:[\/?#]|$)/',1);
        $this->absoluteUrlPattern = new RegExPattern('/^(http:\/\/)[^ :]+/');

        // expand this array if you want to get more URl's on stack
        // at the moment just HTML and PHP pages will be regarded
        $this->validCrawlPatterns = [
            new RegExPattern('/^http:\/\/(.*)\.html$/'),
            new RegExPattern('/^http:\/\/(.*)\.php(.*)$/')
        ];

        $this->init();
    }

    public function process(){
        $crawledPages = 0;
        while(count($this->crawlUrlStack) > 0 && ($crawledPages < $this->maxPages || $this->maxPages == -1)){
            $nextUrl = array_pop($this->crawlUrlStack);
            $host = (new Grep($nextUrl,$this->hostPattern))->getResult()[0];
            $content = $this->getHtmlContent($nextUrl);

            $links = (new Grep($content,$this->hrefPattern))->getResult();
            foreach ($links as $link) {
                $absUrl = $link;
                if (!$this->isAbsoluteUrl($absUrl)) {
                    $absUrl = $host . $link;
                }

                $this->pushUrlOnStack($absUrl);
            }
            $this->crawl($content,$host);
            $crawledPages++;
        }
    }

    /**
     * @param $url
     * @return bool
     */
    protected function isAbsoluteUrl($url) {
        return preg_match($this->absoluteUrlPattern->getPattern(),$url) === 1;
    }

    /**
     * @param $url
     * @return string
     */
    private function getHtmlContent($url){
        $content = file_get_contents($url);
        return $content == null ? 'empty' : $content;
    }

    /**
     * @param $url
     */
    private function pushUrlOnStack($url){
        if ($this->isValidCrawlUrl($url)){
            if (count($this->crawlUrlStack) < $this->maxStackSize && !in_array($url,$this->crawlUrlStack)) {
                array_push($this->crawlUrlStack,$url);
            }
        }
    }

    /**
     * @param $url
     * @return bool
     */
    private function isValidCrawlUrl($url) {
        foreach ($this->validCrawlPatterns as $pattern) {
            if (preg_match($pattern->getPattern(),$url)) {
                return true;
            }
        }return false;
    }

    /**
     * @param $hayStack
     * @param $needle
     * @return bool
     */
    protected function startWith($hayStack, $needle){
        return $needle === "" || strpos($hayStack, $needle) === 0;
    }

    /**
     * @param $content
     * @param $host
     * @return mixed
     */
    abstract protected function crawl($content,$host);

    /**
     * @return mixed
     */
    abstract protected function init();
}