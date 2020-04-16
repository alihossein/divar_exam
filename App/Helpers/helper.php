<?php
/**
 * بیشترین تعداد کاراکتر در هر سلول را مشخص می کند
 * @param $file
 * @return array
 */
function getCellLength($file)
{
    $cellCharacterCount=[0,0,0,0,0];
    foreach ($file as $row)
    {

        foreach($row as $key=>$value)
        {
            if(strlen($value) > $cellCharacterCount[$key])
            {
                if (strlen($value) > getConfig('maxCellLength'))
                {
                    $cellCharacterCount[$key]=getConfig('maxCellLength');
                }else
                {
                    $cellCharacterCount[$key]=strlen($value) ;
                }
            }
        }

    }

    return $cellCharacterCount;

}

/**
 * مشخص می کند سطرهای ما شامل چند سلول هستند
 * @param $records
 * @return int
 */
function getCellCount($records){
    return count($records[0]);
}

/**
 * مشخص می کند هر رکورد شامل چند خط است
 * برای مواقعی که طول متن ها زیاد است ناچار هستیم آنها را بشکنیم
 * @param $records
 * @return int|mixed
 */
function getCountOfLinesInPerRow($records)
{
    $defaultLinesCount=getConfig('maxLinesCount');
    $defaultMaxCellLength=getConfig('maxCellLength');
    foreach ($records as $record)
    {
        foreach($record as $key=>$cell)
        {
            $linesCount=(int)ceil(strlen($cell)/$defaultMaxCellLength);
            if ($linesCount> $defaultLinesCount) {
                $defaultLinesCount=$linesCount;
            }
        }

    }

    return $defaultLinesCount;

}


/**
 * محسابه طول هر سطح برای کشیدن خط مابین سطرها
 * @param $cellCharacterCount
 * @return int|mixed
 */
function calculateNumberOfLineCharacters($cellCharacterCount)
{
    $lineLength=0;
    foreach($cellCharacterCount as $key=>$value)
    {
        $lineLength+=$value;
    }
    return $lineLength;
}

/**
 *
 * @param $string
 * @param $fieldLength
 * @return string
 */
function generateSpace($string , $fieldLength)
{
    $result='';
    $spaceCount=$fieldLength - strlen($string);
    for ($i=0;$i<$spaceCount;$i++)
    {
        $result.= ' ';
    }
    return $result;

}

function generateOneLine($lineLength,$cellCount)
{
    $lineLength+=$cellCount-1;
    $result='+';
    for ($i=0;$i<$lineLength;$i++)
    {
        $result.= '-';
    }
    return $result.'+';

}

/**
 * @param $cellValue
 * @param $cellLength
 * @param bool $lineNumber
 * @return string
 */
function drawCell($cellValue, $cellLength,$lineNumber=false)
{
    # اگر لاین نامبر ست شده بود (در پارت ۲ ست می شود)
    if ($lineNumber)
    {
        $startPosition=0;

        $lineCounter=1;

        if (strlen($cellValue)<getConfig('maxCellLength'))
        {
            if ($lineNumber==1)
            {

            }else
            {
                $cellValue=' ';
            }
        }else
        {
            while (true)
            {

                $string=substr($cellValue,$startPosition,getConfig('maxCellLength'));
                # ممکن است تعداد کاراکتر های سلول کوچیکتر از این باشد که قابل تقسیم بندی باشد
                if ($string===false)
                {
                    # مقدار سلول رار خالی میگذاریم
                    $cellValue=' ';
                    break;
                }

                ###################################################################


                $spacePosition=strrpos($string,' ');

                # ممکن است در متن سلول اصلا اسپیسی وجود نداشته باشد
                if ($spacePosition===false){
                    $spacePosition=getConfig('maxCellLength');
                }
                if (strlen($string) < getConfig('maxCellLength'))
                {
                    if ($lineCounter==$lineNumber)
                    {
                        $cellValue=$string;
                        break;
                    }else
                    {
                        $cellValue='';
                        break;
                    }

                    $cellValue=$string;
                    $startPosition+=strlen($string)+1;
                    break;
                }
                if ($lineCounter==$lineNumber)
                {

                    $cellValue=substr($string,0,$spacePosition);
                    break;


                }else
                {
                    $lineCounter++;
                    $startPosition+=$spacePosition;
                    ++$startPosition;
                }


            }
        }



    }
    return  $cellValue.generateSpace($cellValue,$cellLength);
}

/**
 * گرفتن مقدار یک کانفیگ دلخواه
 * @param $configName
 * @return mixed
 */
function getConfig($configName){
    $configs=include 'config/config.php';
    return $configs[$configName];

}