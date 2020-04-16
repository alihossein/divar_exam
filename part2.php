<?php

include 'vendor/autoload.php';

use App\Helpers\CSV;

# لود کردن فایل اکسل
$csv=new CSV('public/csv/part2.csv');

# محسابه ماکسیمم طول هر سلول
$cellCharacterCountArray=getCellLength($csv->getHandler());

#  طول هر خط
$lineLength=calculateNumberOfLineCharacters($cellCharacterCountArray);


##########################################################
# گرفتن تمام رکوردها
$records=$csv->getAllRecords();

# تعداد سلول ها
$cellCount=getCellCount($records);

##########################################################

# مشخص کردن تعداد خطوط هر رکورد در نمایش
$countOfLinesInPerRow=getCountOfLinesInPerRow($records);



foreach ($records as $keyRecord=>$record)
{
    echo generateOneLine($lineLength,$cellCount)  . "\n";
    # زمانی که رکورد اول که تایتل ها می باشد را بخواهیم نمایش بدهیم
    if ($keyRecord==0)
    {
        $line='';
        foreach ($record as $cellKey=>$cell)
        {

            if ($cellKey===0)
            {
                # نمایش اولین سلول
                $line.=getConfig('cellDelimiter') . drawCell($cell,$cellCharacterCountArray[$cellKey]).getConfig('cellDelimiter');
            }
            else
            {
                # نمایش مابقی سلول ها
                $line.=drawCell($cell,$cellCharacterCountArray[$cellKey]).getConfig('cellDelimiter');
            }

        }
        echo $line."\n";
    }
    else
    {
        # زمانی که رکوردهایی غیر از رکورد اول را بخواهیم نمایش دهیم

        for ($lineNumber = 1; $lineNumber <= $countOfLinesInPerRow; $lineNumber++)
        {
            $line='';
            foreach ($record as $cellKey=>$cell)
            {

                if ($cellKey===0)
                {
                    # نمایش اولین سلول
                    $line.=getConfig('cellDelimiter') . drawCell($cell,$cellCharacterCountArray[$cellKey],$lineNumber).getConfig('cellDelimiter');
                }
                else
                {
                    # نمایش مابقی سلول ها
                    $line.=drawCell($cell,$cellCharacterCountArray[$cellKey],$lineNumber).getConfig('cellDelimiter');
                }

            }
            echo $line."\n";
        }
    }








}
echo generateOneLine($lineLength,$cellCount)  . "\n";

