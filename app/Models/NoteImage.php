<?php

namespace App\Models;

use App\Helpers\Files\FileDrivers;
use App\Helpers\Results\FunctionResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class NoteImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get the notes who owns the image
     *
     * @return BelongsToMany
     */
    public function note(): BelongsToMany
    {
        return $this->belongsToMany(Note::class);
    }

    public function deleteImage(NoteImage $noteImage): FunctionResult
    {
        $note = Note::where('id', $noteImage->note_id)->first();

        if (! Gate::allows('update', $note)) {
            return FunctionResult::error(['permissions', __("You haven't permissions")]);
        }

        if (! Storage::disk(FileDrivers::getDisk())->has($noteImage->note_image_path)) {
            return FunctionResult::success($noteImage->delete());
        }

        Storage::disk(FileDrivers::getDisk())->delete($noteImage->note_image_path);

        return FunctionResult::success($noteImage->delete());
    }
}
