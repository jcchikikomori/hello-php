<?php

namespace libraries;

/**
 * Quick Pagination Class
 *
 * PHP version 7.2
 *
 * @category Pagination
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  0.5.1-alpha
 * @link     https://github.com/jcchikikomori/hello-php
 */
class Pagination
{

    public $id;     //page id from GET or POST (untested)
    public $start;  //starting line (NOTE: This is different to page id)
    public $limit;  //item limit each page

    /**
     * Pagination constructor.
     *
     * @param int $id    ID from get or POST for Paging
     * @param int $limit Row limit
     * @param int $rows  Total rows
     */
    public function __construct($id, $limit = null, $rows = null)
    {
        //init vars
        $this->id = (!isset($id)) ? $id : 1;
        $this->start = 1;
        $this->limit = (!empty($limit)) ? $limit : 10; // items per page

        $this->paginate($this->id, $this->start, $this->limit);
    }

    /**
     * @param int $id
     * @param int $start
     * @param int $limit
     */
    public function paginate($id, $start, $limit)
    {
        if (isset($id)) {
            $this->id = $id;
            $this->start = ($id - 1) * $limit;
        } else {
            $this->start = $this->id;
        }
    }

    public function getTotalRows($rows)
    {
        return ceil($rows / $this->limit);
    }
}
