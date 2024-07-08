<?php
if (!function_exists('json_response')) {
  function json_response($status, $message, $data)
  {
    return response()->json([
      'status' => $status,
      'message' => $message,
      'data' => $data,
    ]);
  }
}
