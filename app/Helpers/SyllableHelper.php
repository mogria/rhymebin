<?php 

namespace App\Helpers;
use Illuminate\Support\Str;

class SyllableHelper {
    const VOCAL_POSITION_START = 0x04;
    const VOCAL_POSITION_MIDDLE = 0x02;
    const VOCAL_POSITION_END = 0x01;
    const VOCALS = ['a', 'e', 'i', 'o', 'u', 'y'];

    private static function convertSyllable($syllable) {
        return Str::lower(Str::ascii($syllable));
    }

    public static function getVocalPositions($syllable) {
        $vocals = collect(self::VOCALS);
        $lowerAsciiSyllable = self::convertSyllable($syllable);
        // make sure vocals get recognized properly
        return collect(str_split($lowerAsciiSyllable))->map(function($char, $index) use ($vocals) {
            return $vocals->contains($char) ? $index : -1;
        })->filter(function($position) {
            return $position >= 0;
        });

    }

    public static function combineAdjacentVocalPositions($vocalPositions) {
        $vocalPositions = collect($vocalPositions)->values();

        $lastPos = -2;
        return collect($vocalPositions)
            ->map(function($pos) use (&$lastPos) {
                $ret = $lastPos == $pos - 1 ? -1 : $pos;
                $lastPos = $pos;
                return $ret;
            })->filter(function($position) {
                return $position >= 0;
            })->values();
    }

    public static function vocalPosition($syllable) {
        $length = mb_strlen(self::convertSyllable($syllable));
        $vocalPositions = self::getVocalPositions($syllable);
        $vocalCount = $vocalPositions->count();
        $collapsedVocalPositions = self::combineAdjacentVocalPositions($vocalPositions);
        $removedVocalPositions = $vocalPositions->count() - $collapsedVocalPositions->count();
        // test for start end and middle, because a syllable might just be of length 1 or 2

        $result = 0;
        $lastIndex = $length - 1 - $removedVocalPositions;
        if($collapsedVocalPositions->contains(0)) {
            $result |= self::VOCAL_POSITION_START;
        }
        if ($collapsedVocalPositions->last() == $lastIndex) {
            $result |= self::VOCAL_POSITION_END;
        }
        if ($collapsedVocalPositions->diff([0, $lastIndex])->count() > 0 || $length == $vocalCount) {
            $result |= self::VOCAL_POSITION_MIDDLE;
        }
        return $result;
    }

    public static function lexicalSimilarity($syllables) {
    }

}
