<?php

use Illuminate\Support\Facades\Session;
use App\Http\Resources\CertificateResource;
use Jambasangsang\Flash\Facades\LaravelFlash;
use Illuminate\Support\Facades\Config;
use App\Models\{Batch, User, Quiz, BatchUser, Course, Lesson, LessonFolder, LessonResource};
use App\Enums\GeneralStatus;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Creativeorange\Gravatar\Facades\Gravatar;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

if (!function_exists('is_active')) {
    function is_active($uri): string
    {
        return request()->is($uri) ? 'active' : (request()->routeIs($uri) ? 'active' : 'not');
    }
}

if (!function_exists('is_disabled')) {
    function is_disabled($status): string
    {
        return $status !== \App\Enums\GeneralStatus::Enabled ? 'disabled' : 'not';
    }
}

if (!function_exists('is_show')) {
    function is_show($uri): string
    {
        return request()->routeIs($uri . '.*') ? 'show' : 'not';
    }
}

if (!function_exists('should_tilt')) {
    function should_tilt($count): string
    {
        return $count > 0 ? 'constant-tilt-shake' : '';
    }
}

if (!function_exists('is_selected')) {
    function is_selected($param1, $param2): string
    {
        return $param1 == $param2 ? 'selected' : 'not';
    }
}

if (!function_exists('formatCount')) {
    function formatCount($n, $precision = 1)
    {
        $n_format = 0;
        $suffix = '';
        if (is_numeric($n)) {
            if ($n < 999) {
                // 0 - 999
                $n_format = number_format($n, $precision);
                $suffix = '';
            } else if ($n < 999999) {
                // 0.9k-850k
                $n_format = number_format($n / 1000, $precision);
                $suffix = ' K';
            } else if ($n < 999999999) {
                // 0.9m-850m
                $n_format = number_format($n / 1000000, $precision);
                $suffix = ' M';
            } else if ($n < 999999999999) {
                // 0.9b-850b
                $n_format = number_format($n / 1000000000, $precision);
                $suffix = ' B';
            } else {
                // 0.9t+
                $n_format = number_format($n / 1000000000000, $precision);
                $suffix = ' T';
            }

            // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
            // Intentionally does not affect partials, eg "1.50" -> "1.50"
            if ($precision > 0) {
                $dotzero = '.' . str_repeat('0', $precision);
                $n_format = str_replace($dotzero, '', $n_format);
            }
        }
        return '<span class="count">' . $n_format . '</span>' . $suffix . '';
    }
}

if (!function_exists('getCompletedResource')) {
    function getCompletedResource(BatchUser $batchUser, Lesson $lesson)
    {
        $completedResources = $batchUser->completed_resources ?? [];
        $hiddenResources = $batchUser->hidden_resources ?? [];

        // Get all resource slugs
        $courseResources = $lesson->resources()
            ->whereHas('folder', fn ($query) => $query->where('is_published', true))
            ->pluck('slug')
            ->toArray();

        // Filtered resources
        $filteredResources = array_diff($courseResources, $hiddenResources);

        $matchedItmes = array_intersect($completedResources, $filteredResources);
        return count($matchedItmes);
    }
}

if (!function_exists('getFormattedProgress')) {
    function getFormattedProgress($batchUserId, Lesson $lesson)
    {
        $batchUser = BatchUser::find($batchUserId);

        $completedResourcesCount = getCompletedResource($batchUser, $lesson);
        $resourceCount = getResourceCount($lesson);

        $percentage = $resourceCount !== 0 ? ($completedResourcesCount / $resourceCount) * 100 : 0;

        $statusOptions = [
            100 => ['Completed', 'success'],
            0 => ['Not Started', 'danger'],
            1 => ['In Progress', 'primary'],
        ];

        $statusKey = $percentage > 0 ? ($percentage === 100 ? 100 : 1) : 0;
        [$text, $color] = $statusOptions[$statusKey];

        $html = "
        <div class='w-100'>
            " . ($resourceCount > 0 ? "
            <div class='text-right text-$color'>
                <small><em>$text ($completedResourcesCount/$resourceCount)</em></small>
            </div>
            " : '') . "
            <div class='progress' style='height: 5px'>
                <div class='progress-bar bg-$color' role='progressbar' style='width: $percentage%' aria-valuenow='$percentage%' aria-valuemin='0' aria-valuemax='100'></div>
            </div>
        </div>";

        return $html;
    }
}

if (!function_exists('getResourceCount')) {
    function getResourceCount(Lesson $lesson)
    {
        return LessonResource::whereHas('folder', function ($query) use ($lesson) {
            $query->where('is_published', true)
                ->whereHas('lesson', function ($query) use ($lesson) {
                    $query->where('id', $lesson->id);
                });
        })
            ->where('status', GeneralStatus::Enabled)
            ->count();
    }
}

if (!function_exists('getStatus')) {
    function getStatus($batchUserId, LessonResource $resource)
    {
        $batchUser = BatchUser::find($batchUserId);
        $completedResources = $batchUser->completed_resources ?? [];

        $statusOptions = [
            'Completed' => 'success',
            'Not Started' => 'danger',
        ];

        $statusKey = in_array($resource->slug, $completedResources) ? 'Completed' : 'Not Started';
        $color = $statusOptions[$statusKey] ?? 'info';

        $html = '<span class="text-' . $color . '"><em>' . $statusKey . '</em></span>';
        return $html;
    }
}

if (!function_exists('resourceIsVisible')) {
    function resourceIsVisible($batchUserId, LessonResource $resource)
    {
        $batchUser = BatchUser::find($batchUserId);
        $hiddenResources = $batchUser->hidden_resources ?? [];
        return in_array($resource->slug, $hiddenResources) ? false : true;
    }
}

if (!function_exists('uploadOrUpdateFile')) {
    function uploadOrUpdateFile($_file, $old_file, $path)
    {
        // $_file = $request->file('image') ?? $request->file('file');

        if ($_file) {
            if ($old_file) {
                if (Storage::disk(config('filesystems.default'))->exists($old_file)) {
                    Storage::disk(config('filesystems.default'))->delete($old_file);
                }
            }

            $randomName = time() . '.' . $_file->extension();
            $path = $_file->storeAs($path, $randomName);

            if (config('filesystems.default') === 'local') {
                return $randomName;
            } elseif (config('filesystems.default') === 's3') {
                return Storage::disk('s3')->url($path);
            }
        }
        return $old_file;
    }
}

if (!function_exists('storeImage')) {
    function storeImage($old_file, $new_file, $path)
    {
        if ($new_file) {
            if ($old_file) {
                $old_file_path = public_path() . $path . '/' . $old_file;
                unlink($old_file_path);
            }

            $randomName = time() . '_' . $new_file->getClientOriginalName();
            $new_file->storeAs($path, $randomName);

            $new_file = $randomName;
        } else {
            $new_file = $old_file;
        }

        return $new_file;
    }
}


if (!function_exists('removeFile')) {
    function removeFile($image, $path)
    {
        if (!empty($image)) {
            $photo_path = public_path() . $path . $image;
            unlink($photo_path);
        }
        return  $image;
    }
}

if (!function_exists('uploadLogo')) {
    function uploadLogo($request, $image)
    {
        if (!empty($image)) {

            $old_file_path = public_path(\constPath::SystemLogo . '/' . $image);
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        }

        $file = $request->settings['logo'];
        $randomName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path() . \constPath::SystemLogo, $randomName);
        $image = $randomName;
        return  url(\constPath::SystemLogo . $image);
    }
}

if (!function_exists('sessionAlert')) {
    function sessionAlert()
    {
        if (Session::has('message')) {
            LaravelFlash::withSuccess(Session::get('message'));
        }

        if (Session::has('error')) {
            LaravelFlash::withError(Session::get('error'));
        }

        if (Session::has('status') || Session::has('info')) {
            LaravelFlash::withInfo(Session::get('status') ?? Session::get('info'));
        }
    }
}

if (!function_exists('getNextOrPreviousFolder')) {
    function getNextOrPreviousFolder(LessonFolder $currentFolder, $previous = false)
    {
        $foldersForLesson = $currentFolder->lesson->folders()->latest()->orderBy('id')->get();

        $offset = $previous ? -1 : 1;
        $nextOrPreviousFolderIndex = $foldersForLesson->search(function ($folder) use ($currentFolder) {
            return $folder->id === $currentFolder->id;
        }) + $offset;

        if (isset($foldersForLesson[$nextOrPreviousFolderIndex]) && $foldersForLesson[$nextOrPreviousFolderIndex]->is_published) {
            return $foldersForLesson[$nextOrPreviousFolderIndex];
        }

        return null;
    }
}

if (!function_exists('getNextOrPreviousResource')) {
    function getNextOrPreviousResource(LessonResource $currentResource, $previous = false)
    {

        $resourcesForFolder = auth()->user()->isStudent() ? $currentResource->folder->resources()->orderBy('id')->get() : $currentResource->folder->resources()->latest()->get();

        $offset = $previous ? -1 : 1;

        $nextOrPreviousResourceIndex = $resourcesForFolder->search(function ($resource) use ($currentResource) {
            return $resource->id === $currentResource->id;
        }) + $offset;

        if (isset($resourcesForFolder[$nextOrPreviousResourceIndex])) {
            return $resourcesForFolder[$nextOrPreviousResourceIndex];
        }

        return null;
    }
}


if (!function_exists('formatMoney')) {
    function formatMoney($amount)
    {
        return $amount == 0 || $amount == Null ? '0' : Config::get('settings.symbol') . round($amount, 2);
    }
}

if (!function_exists('formatDiscount')) {
    function formatDiscount($amount)
    {
        return $amount == 0 || $amount == Null ? '0' : round($amount, 2) . '%';
    }
}

if (!function_exists('getNotifications')) {
    function getNotifications()
    {
        auth()->user()->notifications;
    }
}

if (!function_exists('getAttempts')) {
    function getAttempts(Quiz $quiz, $user = null)
    {
        $student = User::firstWhere(['id' => $user->id ?? auth()->id()]);

        $attempts = $student->submissions()->exists() ? $student->submissions()->where(['quiz_id' => $quiz->id])->get()->count() : 0;

        return $attempts;
    }
}

if (!function_exists('getAverageScore')) {
    function getAverageScore(Quiz $quiz, $user = null)
    {
        $student = User::firstWhere(['id' => $user->id ?? auth()->id()]);

        $totalQuestions = $quiz->questions()->count(); // Total number of questions
        $obtainableScore = $quiz->obtainable_points / $totalQuestions; // obtainable points

        $averageScore = 0;
        $correctSubmissions = [];
        $totalGradableAttempts = 1;

        $submissions = $student->submissions()->where(['quiz_id' => $quiz->id])->latest()->get();

        if (count($submissions)) {
            // check if final score is suposed to be average of all attempts
            if ($quiz->is_average) {
                $correctSubmissions = $submissions->sum(function ($submission) {
                    return collect($submission->data)->where('is_correct', true)->sum('is_correct');
                });
            } else {
                // else get score of latest attempt
                $correctSubmissions = $submissions->first()->data()->sum('is_correct', true);
            }

            // get actual obtainable score based on set score for the quiz
            $totalObtainedScore = $obtainableScore * $correctSubmissions;

            // get average based on number of allowed attempts
            if ($totalObtainedScore > 0) {
                $averageScore = $totalObtainedScore / $totalGradableAttempts;
            }
        }

        return intval(ceil($averageScore));
    }
}

if (!function_exists('getActiveBatch')) {
    function getActiveBatch()
    {
        $active_batch = session()->get('active_batch') ?? null;

        if (!$active_batch) {
            $active_batch = auth()->user()->batches->first() ?? Batch::latest()->first();
        }
        session()->put('active_batch', $active_batch);

        return $active_batch;
    }
}

if (!function_exists('numberFormatter')) {
    function numberFormatter($value)
    {
        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
        return $numberFormatter->format($value);
    }
}

if (!function_exists('parseDateTime')) {
    function parseDateTime($dateTimeString)
    {
        return Carbon::parse($dateTimeString);
    }
}

if (!function_exists('getAttendeeAvatar')) {
    function getAttendeeAvatar($email)
    {
        return Gravatar::get($email);
    }
}

if (!function_exists('getFilePath')) {
    function getFilePath($file)
    {
        return !filter_var($file, FILTER_VALIDATE_URL) ? asset($file) : $file;
    }
}


if (!function_exists('canManageSession')) {
    function canManageSession($sessonId)
    {
        $event = GoogleCalendarEvent::find($sessonId);

        $attendeeEmails = array_column($event->attendees, 'email');
        return !auth()->user()->isStudent() && in_array(auth()->user()->email, $attendeeEmails);
    }
}

if (!function_exists('hasCertificate')) {
    function hasCertificate(User $user, Course $course, $pivotData = null)
    {
        if (!$user->courses->contains('id', $course->id)) {
            return false;
        }
        $batchUser = BatchUser::find($pivotData->id ?? $course->pivot->id);

        if (!$batchUser) {
            return false;
        }

        // Get all resource slugs
        $courseResources = $course->resources()
                        ->whereHas('folder', fn ($query) => $query->where('is_published', true))
                        ->pluck('lesson_resources.slug')
                        ->toArray();

        // Exclude hidden resources
        $hiddenResources = $batchUser->hidden_resources ?? [];

        // Filtered resources
        $filteredResources = array_diff($courseResources, $hiddenResources);

        // Available course resources
        $completedResources = $batchUser->completed_resources ?? [];

        // Matched resources
        $matchedItems = array_intersect($completedResources, $filteredResources);

        // Get percentage of completed resources
        $percentage = count($courseResources) !== 0 ? (count($matchedItems) / count($courseResources)) * 100 : 0;

        return $percentage >= 90;
    }
}
