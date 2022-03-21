<?php
namespace App\Traits;
use Illuminate\Http\Request;

trait SlugTrait
{
    public function verifyAndStoreSlug($request) {
 
        $stringspcermv = str_replace(' ', '', $request['name']);
        $stringlower = strtolower($stringspcermv);
        $randomgnrt= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"),0,4);
        $mixslugs = $stringlower . '' . $randomgnrt;
         
        return $mixslugs;
 
    }
}
