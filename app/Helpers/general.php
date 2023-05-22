<?php
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Str ;
use Illuminate\Support\Facades\File;




function getFolder(){

    return app() -> getLocale() == 'ar' ? 'css-rtl' : 'css' ;
}



function getAllChildIds($category)
{
        $childIds = [];

        foreach ($category->children as $child) {
            $childIds[] = $child;
            $childIds = array_merge($childIds, getAllChildIds($child));
        }

        return $childIds;
}



function getXmlDetails($xml){

    $xmlObject = simplexml_load_file($xml);

    $laravelObject = json_decode(json_encode($xmlObject));
    return $laravelObject ;
}


// function getXmlDetails($file){
//     $xml = file_get_contents($file);

//     $content = new SimpleXMLElement($xml);
//     $array =  json_encode($content);

//     return  json_decode($array,true);
// }




function getXML($file){

    $url = $file;
        $xml = simplexml_load_file($url);
        $content = json_encode($xml);
        return $content ;
}



function uploadImage($photo, $folder, $name)
    {
        $file_name = Str::slug($name).".".$photo->getClientOriginalExtension();
            $path = public_path('/images/'.$folder.'/' .$file_name);
            Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                $constraint->aspectRatio();
            })->save($path,100);
            return $file_name;
    }


    function UnlinkImage($folder, $name, $value){
        if(File::exists('images/'.$folder.'/'.$name) && $name) {
            unlink('images/'.$folder.'/'.$name);
            $name = null ;
            $value->save();
        }

    }
