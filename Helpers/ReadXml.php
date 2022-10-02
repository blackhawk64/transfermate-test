<?php

class ReadXml
{
    public static function ReadXml($file)
    {
        libxml_use_internal_errors(true);
        $finalContent = null;
        if ($file->isFile() && strcmp(strtolower($file->getExtension()), "xml") == 0) {
            $xmlContent = simplexml_load_file($file);

            if ($xmlContent === false) {
                $fileContent = file_get_contents($file);
                $xmlContent = simplexml_load_string("<books>{$fileContent}</books>");
            }

            $finalContent = (array)$xmlContent;
        }

        return $finalContent;
    }
}