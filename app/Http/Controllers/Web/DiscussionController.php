<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Discussion;

class DiscussionController extends Controller
{
    /**
     * DiscussionController Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Discussion::class, 'discussion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discussion $discussion)
    {
        $discussion->delete();

        return back()
            ->with('status', __('Discussion deleted!'));
    }
}
