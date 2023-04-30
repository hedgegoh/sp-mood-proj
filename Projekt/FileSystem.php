<?php

class FileSystem
{
    public $monthPrefix = "CurrMonth:";
    public $yearPrefix = "CurrYear:";

    /*
    / Checks if file exists and reads the line with the specified prefix.
    / @param: $prefix; takes either $monthPrefix or $yearPrefix from FileSystem class
    / @returns: The month or year written in file without the prefix.
    */
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

    /*
    / Creates file and writes in the month and year with the prefix.
    / @param: $month; takes the string or int of the current month.
    / @param: $year; takes the string or int of the current year.
    */
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