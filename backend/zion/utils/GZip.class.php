<?php
namespace zion\utils;

use Exception;

class GZip {
    public static function zipFile(){
    }
    
    /**
     * https://stackoverflow.com/questions/11265914/how-can-i-extract-or-uncompress-gzip-file-using-php
     */
    public static function unzipFile(string $file1,string $file2){
        if(!file_exists($file1)){
            throw new Exception("O arquivo ".$file1." não existe");
        }
        
        $bufferSize = 4096;
        
        $file1p = gzopen($file1, 'rb');
        $file2p = fopen($file2, 'wb');
        
        while (!gzeof($file1p)) {
            fwrite($file2p, gzread($file1p, $bufferSize));
        }
        
        fclose($file2p);
        gzclose($file1p);
    }
}
?>