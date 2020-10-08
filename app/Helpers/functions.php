<?php



use Illuminate\Support\Facades\Crypt;

function decryptRequest($data)
{
    $list = [];
    foreach($data as $key=>$val)
        if($key != "_token")
            $list[Crypt::decryptString($key)] = $val;

    return $list;
}
