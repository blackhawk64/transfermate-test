<?php
require 'Helpers/ReadXml.php';
require 'Models/BooksModel.php';

class LoadInformationController
{
    private $MainDirectory;

    public function __construct()
    {
        $this->MainDirectory = 'main-dir';
    }

    public function ReadAndLoadXml()
    {
        $getDirectories = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->MainDirectory)
        );

        foreach ($getDirectories as $pathname => $file) {
            $Records = ReadXml::ReadXml($file);
        }

        print_r($Records);
    }
}