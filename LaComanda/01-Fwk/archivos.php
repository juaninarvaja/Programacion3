<?php
    class Archivos{

        // Retorna una php array con los datos del archivo. 
        public static function ExtraerMatizArchCsv($urlFile){
            $lista = array();
            
            if (file_exists($urlFile)){                
                $file = fopen($urlFile, "r");
            
                // Cargo el array
                if($file != NULL && $file != false)
                {        
                    for($i = 0; !feof($file); $i++)
                    {         
                        $objJson;
                        $arrayLinea = explode(",", fgets($file)); 
                        for($j = 0; $j < count($arrayLinea); $j++)
                        {                        
                            $KeyValue = explode(":", $arrayLinea[$j]); 
                            if(count($KeyValue) > 1)
                            {
                                $objJson[$KeyValue[0]] = $KeyValue[1];
                                $lista[$i] = $objJson;
                            }                                               
                        }                           
                    }            
                    fclose($file);
                }            
            }    
            
            return $lista;
        }

        // Retorna un array con las líneas del archivo
        public static function ExtraerArrayArchTxt($urlFile){
            $file = fopen($urlFile, "r");
            $lista = array();
            
            // Cargo el array
            if($file != NULL && $file != false)
            {        
                for($i = 0; !feof($file); $i++)
                {         
                    $linea = fgets($file);    
                    if($linea != "")
                    {
                        $lista[] = $linea;                            
                    }                    
                }            
                fclose($file);
            }    

            return $lista;
        }

        // Retorna el array de strings con los datos de fila del id solicitado. En caso de 
        // no encontrarlo retorna NULL. El id se busca en el primer campo.
        public static function GetRowById($urlFile, $id){
            $file = fopen($urlFile, "r");
            $fila= NULL;

            if($file != NULL && $file !=false)
            {
                for($i = 0; !feof($file); $i++)
                {
                    $fila = explode(";", fgets($file));
                    if ($id == $fila[0])
                    {
                        break;
                    }
                }
                fclose($file);
            }

            return $fila;
        }

        // Abre si existe el archivo, lo crea sino, y escribe una línea al final. 
        public static function EscribirLineaArch($fileUrl, $line){
            $file = fopen($fileUrl, "a");
            $retorno = "No se pudo realizar la operación";
            if($file != NULL && $file != false)
            {                        
                fwrite($file, "$line\n");            
                fclose($file);
                $retorno = "$line\n";
            }

            return $retorno;
        }

        // Pisa los datos del archivo con nuevos datos.
        public static function SobreEscribirArchivo ($fileUrl, $txt){
            $file = fopen($fileUrl, "w");
            $retorno = "Error archivo";

            if($file != NULL && $file != false)
            {
                fwrite($file, $txt);
                fclose($file);
                $retorno = $txt;
            }

            return $retorno;
        }

        // Devuelve la lectura de todo el archivo.
        public static function LeerArch ($fileUrl){
            $file = fopen($fileUrl, "r");

            if($file != NULL && $file != false)
            {
                return fread($file, filesize($fileUrl));
                fclose($file);
            }
        }    
    }
    
?>