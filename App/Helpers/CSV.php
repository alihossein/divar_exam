<?php
namespace App\Helpers;


use SplFileObject;

class CSV
{

    /** @var bool */
    private $headersInFirstRow ;
    /**
     * @var string
     */
    private $mode;
    /**
     * @var
     */
    private $path;
    /**
     * @var bool|resource
     */
    private $handle;

    public function __construct( $path, $mode = 'r+', $headersInFirstRow = true)
    {
        $this->headersInFirstRow = $headersInFirstRow;
        $this->mode=$mode;
        $this->path=$path;
        $this->setHandler();


    }

    public function __destruct()
    {

        $this->handle = null;
    }

    public function setHandler()
    {
        $this->handle= new SPLFileObject($this->path);
        $this->handle->setFlags(SplFileObject::READ_CSV);
    }

    public function getHandler()
    {
        return $this->handle;
    }

    /**
     * گرفتن کل سطرهای فایل اکسل
     * @return array
     */
    public function getAllRecords()
    {
        $records=[];
        foreach ($this->handle as $row)
        {
            $records[]=$row;

        }

        return $records;

    }
}