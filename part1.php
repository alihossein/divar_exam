<?php

include 'vendor/autoload.php';
use App\Helpers\CSV;
##########################################################

# لود کردن فایل اکسل
$csv=new CSV('public/csv/part1.csv');
# محسابه ماکسیمم طول هر سلول
$cellCharacterCountArray=getCellLength($csv->getHandler());
$lineLength=calculateNumberOfLineCharacters($cellCharacterCountArray);
##########################################################
# گرفتن تمام رکوردها
$records=$csv->getAllRecords();

# تعداد سلول ها
$cellCount=getCellCount($records);

##########################################################
foreach ($records as $record)
{
    $line='';
    echo generateOneLine($lineLength,$cellCount)  . "\n";
    foreach ($record as $key=>$cell)
    {
        if ($key===0)
        {
            $line.=getConfig('cellDelimiter') . drawCell($cell,$cellCharacterCountArray[$key]).getConfig('cellDelimiter');
        }
        else
        {
            $line.=drawCell($cell,$cellCharacterCountArray[$key]).getConfig('cellDelimiter');
        }

    }
    echo $line."\n";



}
echo generateOneLine($lineLength,$cellCount)  . "\n";
