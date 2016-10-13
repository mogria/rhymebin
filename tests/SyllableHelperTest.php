<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Helpers\SyllableHelper;

class SyllableHelperTest extends TestCase
{

    public function syllableProvider() {
        return [
            ['and', [0], SyllableHelper::VOCAL_POSITION_START],
            ['Eas', [0, 1], SyllableHelper::VOCAL_POSITION_START],
            ['reA', [1, 2], SyllableHelper::VOCAL_POSITION_END],
            ['ürs', [0, 1], SyllableHelper::VOCAL_POSITION_START],
            ['peAs', [1, 2], SyllableHelper::VOCAL_POSITION_MIDDLE],
            ['sTez', [2], SyllableHelper::VOCAL_POSITION_MIDDLE],
            ['reek', [1, 2], SyllableHelper::VOCAL_POSITION_MIDDLE],
            ['sia', [1, 2], SyllableHelper::VOCAL_POSITION_END],
            ['ne', [1], SyllableHelper::VOCAL_POSITION_END],
            ['nee', [1,2], SyllableHelper::VOCAL_POSITION_END],
            ['ae', [0, 1], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],
            ['ai', [0, 1], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],
            ['e', [0], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],
            ['a', [0], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],
            ['i', [0], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],
            ['O', [0], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],
            ['u', [0], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],
            ['y', [0], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],
            ['ü', [0, 1], SyllableHelper::VOCAL_POSITION_START | SyllableHelper::VOCAL_POSITION_MIDDLE | SyllableHelper::VOCAL_POSITION_END],

        ];
    }
    /**
     * A basic test example.
     *
     * @return void
     * @dataProvider syllableProvider
     */
    public function testGetVocalPositions($syllable, $vocalPositions, $vocalPositionValue)
    {
        $this->assertEquals($vocalPositions, SyllableHelper::getVocalPositions($syllable)->sort()->values()->toArray());
    }

    /**
     * A basic test example.
     *
     * @return void
     * @dataProvider syllableProvider
     */
    public function testVocalPositionValue($syllable, $vocalPositions, $vocalPositionValue)
    {
        $this->assertEquals($vocalPositionValue, SyllableHelper::vocalPosition($syllable));
    }


    public function adjacentPositionsProvider() {
        return [
        //  input          expected output
            [[0],          [0]],
            [[1],          [1]],
            [[0, 1],       [0]],
            [[0, 2],       [0, 2]],
            [[0, 3],       [0, 3]],
            [[0, 1, 3],    [0, 3]],
            [[0, 1, 3, 4], [0, 3]]
        ];
    }

    /**
     * @dataProvider adjacentPositionsProvider
     */
    public function testCombineAdjacentVocalPositions($vocalPositions, $expected) {
        $this->assertEquals($expected, SyllableHelper::combineAdjacentVocalPositions($vocalPositions)->toArray());
    }
}
