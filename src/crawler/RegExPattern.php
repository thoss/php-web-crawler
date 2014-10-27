<?php

namespace crawler;

class RegExPattern {
    /**
     * @var string
     */
    private $pattern;
    /**
     * @var int
     */
    private $group;

    /**
     * the regex pattern
     * @param $pattern
     * the group you want to get from the matched result
     * @param $group
     */
    public function __construct($pattern, $group = 0){
        $this->setGroup($group);
        $this->setPattern($pattern);
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group) {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * @param mixed $pattern
     */
    public function setPattern($pattern) {
        $this->pattern = $pattern;
    }

    /**
     * @return mixed
     */
    public function getPattern() {
        return $this->pattern;
    }
}