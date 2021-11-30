<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function response_with_message($message,$status=200,$option = null){
        $output['message'] = $message;
        if($option){
            $output['body'] = $option;
        }
        return response()->json($output, $status);
    }
}
