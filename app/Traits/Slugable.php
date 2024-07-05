<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait Slugable
{

    public static function bootSlugable()
    {

        // if user is logged in
        if (auth()->check()) {

            // Creating Function
            static::creating(function ($model) {

                if (Schema::hasColumn($model->getTable(), 'created_by_id')) {
                    $model->created_by_id = auth()->user()->id;
                }

                if (Schema::hasColumn($model->getTable(), 'updated_by_id')) {
                    $model->updated_by_id = auth()->user()->id;
                }

                if (Schema::hasColumn($model->getTable(), 'code')) {
                    $model->code = Str::substr(Str::upper($model->name), 0, 2) . rand(000000, 999999);
                }

                if (Schema::hasColumn($model->getTable(), 'slug')) {
                    if (Schema::hasColumn($model->getTable(), 'title')) {
                        $model->slug = Str::slug($model->title);
                        // $model->slug = $model->where('slug', 'like', $slug . '%')->exists() ? $slug . '-' . Str::random(8) : $slug;
                    } else {
                        $value = $model->title ?? substr(str_shuffle(sha1(now())), 0, 8);
                        $model->slug = Str::slug($value);
                    }
                }
            });

            // Updating Function
            static::updating(function ($model) {
                if (Schema::hasColumn($model->getTable(), 'updated_by_id')) {
                    $model->updated_by_id = auth()->user()->id;
                }
            });
        } else {
            static::creating(function ($model) {

                if (Schema::hasColumn($model->getTable(), 'code')) {
                    $model->code = Str::substr(Str::upper($model->name), 0, 2) . rand(000000, 999999);
                }

                if (Schema::hasColumn($model->getTable(), 'slug')) {
                    if (Schema::hasColumn($model->getTable(), 'title')) {
                        $model->slug = Str::slug($model->title);
                    } else {
                        $value = $model->title ?? substr(str_shuffle(sha1(now())), 0, 8);
                        $model->slug = Str::slug($value);
                    }
                }
                // if (!App::runningInConsole() && $model->getTable() !== 'categories') {
                //     $model->assignRole('Student');
                // }

            });
        }
    }

    public function link()
    {

        if (Schema::hasColumn($this->getTable(), 'slug')) {

            if (request()->routeIs('students.*')) {
                return Route('students.show', $this->slug);
            } elseif (request()->routeIs('instructors.*')) {
                return Route('instructors.show', $this->slug);
            } elseif (request()->routeIs('Courses.*') || request()->is('/') || request()->routeIs('Categories.*')) {
                return Route('Courses.single', [$this->id, $this->slug]);
            } elseif (request()->routeIs('instructors.*')) {
                return Route('users.show', ['group' => 'instructor', 'user' => $this->slug]);
            } elseif (request()->routeIs('Events.*')) {
                return Route('Events.single', $this->slug);
            } elseif (auth()->user()->hasRole('Student')) {
                return Route('users.show', ['group' => 'student', 'user' => $this->slug]);
            }
            // return Route($this->getTable() . '.show', $this->slug);
        }
    }

    public function slug()
    {
        if (Schema::hasColumn($this->getTable(), 'slug')) {
            return $this->slug;
        }
    }

    protected function status(): Attribute
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return Attribute::make(
                get: fn ($value) => ucfirst($value),
                set: fn ($value) => strtolower($value),
            );
        }
    }

    public function status_color()
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return [
                'Enabled' => 'primary',
                'Disabled' => 'secondary',
                'Ongoing' => 'warning',
                'Cancelled' => 'danger',
                'Completed' => 'success',
                'Closed' => 'success',
            ][$this->status] ?? 'primary';
        }
    }

    public function image()
    {
        $column = Schema::hasColumn($this->getTable(), 'image') ? 'image' : (Schema::hasColumn($this->getTable(), 'banner') ? 'banner' : null);

        if (!$column) {
            return null;
        }

        $defaultImage = \constPath::DefaultImage;
        $fileExists = !empty($this->{$column});

        if (!$fileExists) {
            return asset($defaultImage);
        }

        if (config('filesystems.default') === 'local' || !filter_var($this->{$column}, FILTER_VALIDATE_URL)) {
            $pathPrefix = '/jambasangsang/assets/' . $this->getTable() . '/images/';
            $filePath = $pathPrefix . $this->{$column};
            return asset($filePath);
        } elseif (config('filesystems.default') === 's3') {
            return $this->{$column};
        }

        return null;
    }

    public function file()
    {
        if (Schema::hasColumn($this->getTable(), 'url') && $this->url) {
            return $this->url;
        } else if (Schema::hasColumn($this->getTable(), 'file')) {
            return !filter_var($this->file, FILTER_VALIDATE_URL) ? asset(!empty($this->file) ? '/jambasangsang/assets/' . $this->getTable() . '/' . $this->file : '') : $this->file;
        } else {
            return $this->url;
        }
    }
}
