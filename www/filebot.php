<?php

$path = __DIR__.'\..\App';
$dirs =  listFolder($path, 'App');

foreach ($dirs as $key => $path) {
    renameGit($path);
}

function listFolder($dir, $nivel){
    $exceptions = ['.', '..', 'views'];
    $scan       = scandir($dir);
    $dirs       = [];

    foreach($scan as $file) {
        if (!is_dir($dir."/$file") or in_array($file, $exceptions)) continue;
        $dirs[] = [
            'old'      => $nivel.'/'.$file,
            'new'      => $nivel.'/rename',
            'original' => $nivel.'/'.ucfirst($file)
        ];

        $subDirs =  listFolder($nivel.'/'.$file, $nivel.'/'.ucfirst($file));
        if(is_array($subDirs) and !empty($subDirs)){
            $dirs = array_merge($dirs, $subDirs);
        }
        
    }

    return $dirs;
}

function renameGit($path){
    shell_exec('git mv "'.$path['old'].'" "'.$path['new'].'"');
    shell_exec('git mv "'.$path['new'].'" "'.$path['original'].'"');
}

