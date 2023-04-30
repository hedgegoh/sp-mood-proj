<?php

class FileSystem
{
    public $monthPrefix = "CurrMonth:";
    public $yearPrefix = "CurrYear:";

    public function ReadFile($prefix)
    {
        $content = "";
        $filneName = "UserConfig.txt";
        if (file_exists($filneName))
        {
            $file = file($filneName);
            if ($file != null)
            {
                foreach ($file as $line)
                {
                    if (str_starts_with($line, $prefix))
                    {
                        $content = str_replace($prefix, "", $line);
                    }
                }
            }
        }
        return $content;
    }

    public function WriteFile($month, $year)
    {
        $file = fopen("UserConfig.txt", "w") or die("Unable to open file!");
        $contentMonth = $this->monthPrefix . $month . "\n";
        fwrite($file, $contentMonth);
        $contentYear = $this->yearPrefix . $year . "\n";
        fwrite($file, $contentYear);
        fclose($file);
    }
}
?>