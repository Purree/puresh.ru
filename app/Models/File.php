<?php

namespace App\Models;

use App\Exceptions\InsufficientPermissionsException;
use App\Helpers\Files\FileDrivers;
use Gate;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Log;

class File extends Model
{
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @throws FileNotFoundException
     */
    private function deleteFileFromStorage(): void
    {
        if ($this->path === null || $this->path === '' || ! Storage::disk(FileDrivers::getDriver())->exists($this->path)) {
            throw new FileNotFoundException(__('File not found'));
        }

        Storage::disk(FileDrivers::getDriver())->delete($this->path);
    }

    /**
     * @throws InsufficientPermissionsException
     */
    public function delete(): ?bool
    {
        if (! Gate::check('delete', $this)) {
            throw new InsufficientPermissionsException(__('You can\'t delete this file'));
        }

        try {
            $this->deleteFileFromStorage();
        } catch (FileNotFoundException $e) {
            Log::critical($e);
        }

        return parent::delete();
    }
}
