<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/21/14
 * Time: 9:42 AM
 */

class PUploadFiles {


    function show()
    {
        $dir =  $_GET['dir'].'/';


        $folder = $dir;
        $response = array();
        if (isset($_FILES['fileName']))
        {
            $file = $_FILES['fileName'];

            if( $file['error'] === 0 && $file['size'] > 0 )
            {
                $path = $folder.$file['name'];

                if (is_writable($folder) )
                {
                    if( move_uploaded_file( $file['tmp_name'], $path ) )
                    {
                        $response['type'] = 'success';
                        $response['fileName'] = $file['name'];
                    }
                    else
                    {
                        $response['type'] = 'error';
                        $response['msg'] = '';
                    }
                }
                else
                {
                    $response['type'] = 'error';
                    $response['msg'] = "Sem permissao: {$path}";
                }
                echo json_encode($response);
            }
        }
    }
} 