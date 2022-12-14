<?php

namespace App\Models;

use App\Exceptions\InsufficientPermissionsException;
use App\Helpers\Files\FileDrivers;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemException;

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

    /**
     * @throws InsufficientPermissionsException
     * @throws FilesystemException
     * @throws FileNotFoundException
     */
    public function deleteImage(NoteImage $noteImage): ?bool
    {
        $note = Note::where('id', $noteImage->note_id)->first();

        if (! Gate::allows('update', $note)) {
            throw new InsufficientPermissionsException(__('You can\'t delete this file'));
        }

        if (! Storage::disk(FileDrivers::getDriver())->has($noteImage->note_image_path)) {
            throw new FileNotFoundException(__('File not found'));
        }

        Storage::disk(FileDrivers::getDriver())->delete($noteImage->note_image_path);

        return $noteImage->delete();
    }
}
