<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatAttachment;
use Illuminate\Support\Facades\File;

class ChatAttachmentsController extends Controller
{
    public function show($id)
    {
      $attachment = ChatAttachment::find($id);
      $path = storage_path('app/'. $attachment->attachment);

      if (!File::exists($path)) {
          abort(404);
      }

      return response()->download($path, $attachment->original_name);
    }
}
