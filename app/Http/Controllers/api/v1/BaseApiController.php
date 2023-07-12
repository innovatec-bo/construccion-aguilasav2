<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        if(is_array($result))
        {
            $response = [
                'success' => true,
                'data'    => $result,
                'message' => $message,
            ];
    
            return response()->json($response, 200);
        }
        else
        {
            $response = [
                'success' => true,
                'message' => $message
            ];
            return $result->additional($response);
        }
    	
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
