<?php

namespace Modules\Prize\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Draw\Http\Controllers\DrawController;
use Modules\Prize\Entities\PrizeTypes;
use Modules\User\Entities\User;
use Modules\User\Entities\UserPrizes;

class PrizeController extends Controller
{
    public function convert($draw)
    {
        $user = \request()->user();

        $convert = false;

        $type = current(PrizeTypes::where('code', 'chips')->get()->toArray());
        $chipsId = $type['id'];

        $type = current(PrizeTypes::where('code', 'money')->get()->toArray());
        $moneyId = $type['id'];

        $prize = UserPrizes::where('user_id', $user->id)
            ->where('draw_id', $draw)
            ->where('type', $moneyId)
            ->get()->toArray();

        if(count($prize) !== 0) {
            $prize = current($prize);
            $amount = $prize['amount'];
            $chips = DrawController::convertMoneyToChips($amount);

            UserPrizes::where('id', $prize['id'])->delete();

            User::where('id', $user->id)->update([
                'chips' => (int)$user->chips + $chips
            ]);

            $convert = true;
        }

        return response()->json(
            [
                'money' => $amount ?? null,
                'chips' => $chips ?? null,
                'convert' => $convert
            ]
        );
    }
}
