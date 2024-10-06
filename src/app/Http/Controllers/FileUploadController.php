<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // バリデーション: 最大10MB、jpg, png, pdfファイルのみを許可
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:10240', // 最大10MB
        ]);

        // ファイルをS3にアップロード
        $filePath = $request->file('file')->store('uploads', 's3');

        // アップロード後のファイルのURLを取得
        $fileUrl = Storage::disk('s3')->url($filePath);

        // 成功メッセージとURLを返す
        return response()->json(['url' => $fileUrl], 200);
    }
}
