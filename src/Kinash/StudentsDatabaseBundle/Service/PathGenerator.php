<?php
namespace Kinash\StudentsDatabaseBundle\Service;

class PathGenerator{

    protected $_pathArray = array();
    /**
     * Clean all non alphanumeric digits
     * @param string $name
     * @return string
     */
    public   function encodePath($name)
    {
        $lowered = mb_strtolower($name);
        $path = preg_replace('/[^\da-z]/i', '_', $lowered);
        while(strpos($path,'__')) {
            $path = str_replace('__', '_', $path);
        }
        return trim($path, '_');
    }

    /**
     * @param  string $name
     * @return string
     */
    public function generateUniquePath($name){
        $path = $this->encodePath($name);
        if(count($this->_pathArray) > 0) {
            # use isset because it is the fastest of(in_array,isset,array_key_exists) http://maettig.com/1397246220
            if (isset($this->_pathArray[$path])) {

                $i = 1;

                do {

                    $newPath = $path . '_' . $i;
                    $i++;

                } while (isset($this->_pathArray[$newPath]));

                $path = $newPath;
            }
        }
        $this->_pathArray[$path] = true;
        return $path;
    }

}