<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * NoteController Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Note::class, 'note');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return back()
            ->with('status', __('Note deleted!'));
    }
}
