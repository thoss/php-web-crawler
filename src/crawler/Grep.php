<?php

namespace crawler;

class Grep {
    /**
     * @var string
     */
    private $content;

    /**
     * @var RegExPattern
     */
    private $pattern;

    /**
     * the text we will scan for patterns
     * @param null $content
     * thr regex pattern
     * @param RegExPattern $pattern
     */
    public function __construct($content = null, RegExPattern $pattern = null){
        $this->setContent($content);
        $this->setPattern($pattern);
    }

    /**
     * searches for the patterns in the given result
     * on match the resultset will be filles wiht the
     * given group of the regex pattern
     * @return array
     * @throws NotProperlyConfiguredException
     */
    public function getResult() {
        if ($this->content == null || $this->pattern == null) {
            throw new NotProperlyConfiguredException();
        }
        $resultSet = [];
        preg_match_all($this->pattern->getPattern(),$this->content,$matches);
        foreach ($matches[$this->pattern->getGroup()] as $match) {
            $resultSet[] = $match;
        }
        return $resultSet;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param RegExPattern $pattern
     */
    public function setPattern(RegExPattern $pattern) {
        $this->pattern = $pattern;
    }

    /**
     * @return mixed
     */
    public function getPattern() {
        return $this->pattern;
    }
} 