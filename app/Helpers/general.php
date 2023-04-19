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

