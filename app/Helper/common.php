<?php

if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}


if (! function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $parameters
     * @param  string  $domain
     * @param  string  $locale
     * @return string
     */
    function trans($id = null, $parameters = [], $domain = 'messages', $locale = null)
    {
        if (is_null($id)) {
            return app('translator');
        }

        return app('translator')->trans($id, $parameters, $domain, $locale);
    }
}


if (! function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }
}


if (! function_exists('endWith')) {
    /**
     * 第一个是原串,第二个是 部份串
     * @param  [type] $haystack [description]
     * @param  [type] $needle   [description]
     * @return [type]           [description]
     */
    function endWith($haystack, $needle) 
    {   
        $length = strlen($needle);  
        if($length == 0)
        {    
          return true;  
        }  
        return (substr($haystack, -$length) === $needle);
    }
}

if (! function_exists('formatPhoto')) {
    /**
     * Format Photo
     * 
     * @param  string $photo
     * @return array
     */
    function formatPhoto($photo)
    {   
        return [
            'thumb' => $photo,
            'large' => $photo,
        ];
    }
}
