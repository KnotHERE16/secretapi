<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secret;
use Illuminate\Support\Facades\Validator;

class SecretController extends Controller
{
    /**
     * Retreive all records.
     */
    public function getAll()
    {
        $output = [];
        $result = Secret::all(['key', 'value','created_at']);

        if($result->isEmpty()){
            return $this->response_with_message('Empty Record');
        }
        foreach ($result as $k => $v) {
                $output[$v['key']][] = ['value'=>json_decode($v['value']),'timestamp' => $v['created_at']];
        }
         return response()->json($output);
    }

    /**
     * Insert new record
     */
    public function createObject(Request $request)
    {

        $json = json_decode($request->getContent(),true);
       
        if (!is_array($json) || !$json) {
            return $this->response_with_message('Invalid json object',422);
        }

        if (count($json) !== 1) {
            return $this->response_with_message('Only one key value pair allow',422);
        }

        foreach ($json as $k => $v) {
            $secret = new Secret;
            $secret->key = $k;
            $secret->value = json_encode($v);
            $secret->save();
        }
        return $this->response_with_message('New record created',201);
    }

    /**
     * Get the specified record
     */
    public function getObject($mykey, Request $request)
    {

        $validator = Validator::make($request->all(),[
            'timestamp' => 'integer|gt:0'
        ]);

        if ($validator->fails()) {
            $message = 'timestamp need to be in Unix format';
           return $this->response_with_message($message,422);
        }

        $timestamp = $request->timestamp;

        $result = Secret::select('key', 'value')
                            ->where('key', $mykey)
                            ->when($timestamp, function ($query, $timestamp) {
                                return $query->where('created_at', '<=', $timestamp);
                            })
                            ->latest()->first();

        if (!$result) {
            return $this->response_with_message('No records found');
        }

        $output[$result->key] = json_decode($result->value);
        return response()->json($output);
    }

}
