<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "saving" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function saving(Category $category)
    {
        if(request()->hasFile('image')){
            $category->image = uploadOrUpdateFile(request()->file('image'), $category->image, \constPath::CategoryImage);
        }
    }

}
