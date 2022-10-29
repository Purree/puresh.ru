<?php

namespace App\Models;

use App\Helpers\Files\FileDrivers;
use App\Helpers\Results\FunctionResult;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    private function deleteFile(): FunctionResult
    {
        if (Storage::disk(FileDrivers::getDriver())->exists($this->path)) {
            Storage::disk(FileDrivers::getDriver())->delete($this->path);

            return FunctionResult::success();
        }

        return FunctionResult::error(__('File not found'));
    }

    public function delete(): FunctionResult
    {
        if (! Gate::allows('delete', $this)) {
            return FunctionResult::error(__('You can\'t delete this file'));
        }

        $this->deleteFile();

        if (parent::delete()) {
            return FunctionResult::success();
        }

        return FunctionResult::error(__('Something went wrong'));
    }
}
