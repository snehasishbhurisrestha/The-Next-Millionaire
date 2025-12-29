<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CourseContent extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'course_id',
        'title',
        'content',        // for text lessons
        'content_type',   // text / video / pdf
        'step_number',
    ];

    /**
     * Relationships
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Register media collections for Spatie Media Library.
     */
    public function registerMediaCollections(): void
    {
        // single video file per lesson
        $this->addMediaCollection('videos')->singleFile();

        // single PDF file per lesson
        $this->addMediaCollection('pdfs')->singleFile();

        $this->addMediaCollection('pdf_files')
            ->useDisk('public')
            ->acceptsFile(fn ($file) => $file->mimeType === 'application/pdf');
    }

}
