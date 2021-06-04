<?php

class ArrayUtil {    

    /**
     * move position of tho element
     *
     * @param  mixed $a
     * @param  mixed $oldPosition
     * @param  mixed $newPosition
     * @return void
     */
    public static function move(&$a, $oldPosition, $newPosition) {
        if ($oldPosition==$newPosition) {return;}
        array_splice($a,max($newPosition,0),0,array_splice($a,max($oldPosition,0),1));
    }
}