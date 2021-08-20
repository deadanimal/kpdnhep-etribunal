<?php

namespace App\Repositories;

use App\Models\Runner;

class RunnerRepository
{
    /**
     * To generate running number form various rule (up to 7) and type of number.
     *
     * Lets learn some magic!
     * TTPM-P-(B)-57-2020
     *      {TTPM} . - . {P} . - . ({B}) . - . RUNNER . - . {2020}
     *      rule_1 = TTPM; rule_2 = P; rule_3 = 2020; non_indexed_rule_1 = B;
     * B1-WPPJ-996-2019
     *      {B1} . - . {WPPJ} . - . RUNNER . - . {2019}
     *      rule_1 = B1; rule_2 = WPPJ; rule_3 = 2020;
     * T20010357
     *      {T} . {20} . STRPAD(RUNNER,6,'0',STR_PAD_LEFT)
     *      rule_1 = T; rule_2 = 20;
     *
     * @param $rule_1
     * @param null $rule_2
     * @param null $rule_3
     * @param null $rule_4
     * @param null $rule_5
     * @param null $non_indexed_rule_1
     * @return array|string
     */
    public static function generateAppNumber($rule_1, $rule_2 = null, $rule_3 = null, $rule_4 = null, $rule_5 = null, $non_indexed_rule_1 = null)
    {
        $runner = Runner::where('rule_1', '=', $rule_1)
            ->where('rule_2', '=', $rule_2)
            ->where('rule_3', '=', $rule_3)
            ->where('rule_4', '=', $rule_4)
            ->where('rule_5', '=', $rule_5)
            ->first();

        if (!$runner) {
            $runnerCreate = new Runner;
            $runnerCreate->create([
                'rule_1' => $rule_1,
                'rule_2' => $rule_2,
                'rule_3' => $rule_3,
                'rule_4' => $rule_4,
                'rule_5' => $rule_5,
                'runner' => 1
            ]);

            $runningNumberRaw = 1;
        } else {
            Runner::where('rule_1', '=', $rule_1)
                ->where('rule_2', '=', $rule_2)
                ->where('rule_3', '=', $rule_3)
                ->where('rule_4', '=', $rule_4)
                ->where('rule_5', '=', $rule_5)
                ->increment('runner');

            $runner = Runner::where('rule_1', '=', $rule_1)
                ->where('rule_2', '=', $rule_2)
                ->where('rule_3', '=', $rule_3)
                ->where('rule_4', '=', $rule_4)
                ->where('rule_5', '=', $rule_5)
                ->first();

            $runningNumberRaw = $runner->runner;
        }

        switch ($rule_1) {
            case 'INQUIRY':
                /*
                 * {I} . - . {K} . - . RUNNER . - . {2020}
                 * rule_1 = INQUIRY; rule_2 = K; rule_3 = 2020; non_indexed_rule_1 = I;
                 */
                return $non_indexed_rule_1 . '-' . $rule_2 . '-' . $runningNumberRaw . '-' . $rule_3;
                break;
            case 'TTPM':
                /*
                 * {TTPM} . - . {P} . - . ({B}) . - . RUNNER . - . {2020}
                 * rule_1 = TTPM; rule_2 = P; rule_3 = 2020; non_indexed_rule_1 = B;
                 */
                return [
                    'number' => $rule_1 . '-' . $rule_2 . '-(' . $non_indexed_rule_1 . ')-' . $runningNumberRaw . '-' . $rule_3,
                    'runner' => $runningNumberRaw,
                ];
                break;
            case 'B1':
                /*
                 * {B1} . - . {WPPJ} . - . RUNNER . - . {2019}
                 * rule_1 = B1; rule_2 = WPPJ; rule_3 = 2020;
                 */
                return $rule_1 . '-' . $rule_2 . '-' . $runningNumberRaw . '-' . $rule_3;
                break;
            case 'T':
                /*
                 * {T} . {20} . STRPAD(RUNNER,6,'0',STR_PAD_LEFT)
                 * rule_1 = T; non_indexed_rule_1 = 20;
                 */
                return $rule_1 . $non_indexed_rule_1 . str_pad($runningNumberRaw, 6, '0', STR_PAD_LEFT);
                break;
            default:
                return 'INVALID';
                break;
        }
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Runner::class;
    }
}