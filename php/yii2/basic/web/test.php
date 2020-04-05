<?php
function xing($type)
{
    if($type==1)
    {
        $a =  'this type is one';
    }else
    {
        $a =  'this type is two';
    }
    echo 'this is a breakpoint';
    return  $a.' liang';
}

function ming()
{
    return 'my name is '.xing(1).' xi feng';
}

echo ming();
