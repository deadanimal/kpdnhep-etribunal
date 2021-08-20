<?php

namespace App\Repositories;

use App\CaseModel\ClaimCaseOpponent;

class ClaimCaseRepository
{
    /**
     * Update finish status of case by claim case
     * @param $claim_case
     */
    public static function updateFinishStatus($claim_case)
    {
        $cco_not_finish = self::findNotFinishCase($claim_case->claim_case_id);

        if (empty($cco_not_finish)) {
            $claim_case->update(['is_finished' => 1]);
        }

        return;
    }

    /**
     * Find all cco that are not finish yet.
     * @param $claim_case_id
     * @return \App\CaseModel\ClaimCaseOpponent|\Illuminate\Database\Eloquent\Model|null
     */
    public static function findNotFinishCase($claim_case_id)
    {
        return ClaimCaseOpponent::where('claim_case_id', $claim_case_id)
            ->where('status_id', 1) // not finished
            ->first();
    }
}
