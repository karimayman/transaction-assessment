<?php

namespace App\Services;

class NotesParser
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function parseNotes($notes): ?array
    {
        if ($notes == ''){
            return null;
        }
        $notesCollection = [];
        $noteParts = explode("/", $notes);
        for ($i = 0 ;$i < count($noteParts) - 1  ; $i+=2){
            $key = $noteParts[$i];
            $value = $noteParts[$i+1];
            $notesCollection[$key] = $value;
        }
        return $notesCollection;
    }
}
