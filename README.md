Simple PHP Web Crawler
==============================
***

###WHAT

>This Crawler scans the content of a page pushes found URl's on the stack to keep crawling
and calls a abstract method to get specific links of the content.
To create a new Crawler just extend from the WebCrawler like Mp3WebCrawler or ImageWebCrawler
and adjust the Patterns.

###HOWTO

Create repository to save the results
```
$memoryCrawlRepository = new InMemoryCrawlRepository();
```
Create instance of your specific WebCrawler

*   Param 1: first url on crawl stack
*   Param 2: repository for the results
*   Param 3: number of pages to crawl (set to -1 for infinity)

```
$targetUrl = "want-to-crawl.com";
$mp3crawler = new Mp3WebCrawler([$targetUrl],$memoryCrawlRepository,1);
```
Start the crawler
```
$mp3crawler->process();
```

###REQUIREMENTS

>* PHP 5.5