<?php
if (!function_exists('dd')) {
    /**
     * Dump the given variables and end the script.
     *
     * @param  mixed  ...$vars
     * @return void
     */
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            var_dump($var);
        }
        die(1); // Beendet das Skript und gibt den Statuscode 1 zurück
    }
}
