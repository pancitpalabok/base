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

function obfuscate_apply($str = "") {
    return base64_encode($str);
}

function obfuscate_undo($str = "") {
    return base64_decode($str);
}

function base64url_encode( $data ){
    return rtrim( strtr( base64_encode( $data ), '+/', '-_'), '=');
  }

  function base64url_decode( $data ){
    return base64_decode( strtr( $data, '-_', '+/') . str_repeat('=', 3 - ( 3 + strlen( $data )) % 4 ));
  }


?>
