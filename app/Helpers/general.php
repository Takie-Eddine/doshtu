<?php





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



function getXmlDetails($file){
    $xml = file_get_contents($file);

    $content = new SimpleXMLElement($xml);
    $array =  json_encode($content);

    return  json_decode($array,true);
}




function getXML($file){

    $url = $file;
        $xml = simplexml_load_file($url);
        $content = json_encode($xml);
        return $content ;
}

