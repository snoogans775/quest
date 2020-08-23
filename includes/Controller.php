<?php

class Controller 
{
    public function __construct()
    {
        $this->env = $_ENV;
        $this->currentPage = null;
    }

    public function setPage($pageName)
    {
        $this->currentpage = $pageName;
    }
    public function getPage() {
        return $this->currentPage;
    }
}