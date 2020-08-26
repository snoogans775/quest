<?php
namespace Quest;

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
    static public function redirect($url) {
        echo "<script type='text/javascript'> document.location = '{$url}'; </script>";
        exit;
    }
}