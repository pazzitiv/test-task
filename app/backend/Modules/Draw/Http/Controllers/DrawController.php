<?php

namespace Modules\Draw\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Draw\Entities\Draw;
use Modules\Draw\Entities\DrawPrizes;
use Modules\Draw\Transformers\DrawResource;
use Modules\Prize\Entities\Prize;
use Modules\Prize\Entities\PrizeTypes;
use Modules\User\Entities\User;
use Modules\User\Entities\UserPrizes;

class DrawController extends Controller
{
    const MONEYMULTIPLER = .1;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function list()
    {
        return response()->json(
            DrawResource::collection(Draw::all())
        );
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function draw($id)
    {
        $user = \request()->user();

        $hasPrize = UserPrizes::where('draw_id', $id)->where('user_id', $user->id)->get()->count();

        if ($hasPrize !== 0) {
            return response()->json([
                'hasPrize' => true
            ]);
        }

        $prizes = DrawPrizes::where('draw_id', $id)->get();

        $countPrizes = count($prizes);

        $thisPrize = $prizes[(int)rand(0, $countPrizes * 333) / 333];
        $prizeType = $thisPrize->prize_type;
        $prizeTypeCode = PrizeTypes::find($prizeType)->code;
        $maxPrize = $thisPrize->max_count;

        $prize = rand(1, $maxPrize);

        $convert = $thisPrize->amount - $prize < 0;

        if ($convert) {
            switch ($prizeTypeCode) {
                case 'money':
                    $prize = $this->convertMoneyToChips($prize);
                    break;
                case 'item':
                    $prize = $this->convertItemToChips(Prize::find($thisPrize->item_id)->price);
                    break;
            }

            $type = current(PrizeTypes::where('code', 'chips')->get()->toArray());
            $chipsId = $type['id'];

            User::where('id', $user->id)->update([
                'chips' => (int)$user->chips + $prize
            ]);

            UserPrizes::create([
                'user_id' => $user->id,
                'draw_id' => $id,
                'type' => $chipsId,
                'amount' => $prize,
            ]);
        } else {
            if ($prizeTypeCode !== 'chips') {
                DrawPrizes::where('id', $thisPrize->id)->update([
                    'amount' => $thisPrize->amount - $prize,
                ]);
            }

            switch ($prizeTypeCode) {
                case 'chips':
                    User::where('id', $user->id)->update([
                        'chips' => (int)$user->chips + $prize
                    ]);
                case 'money':
                    UserPrizes::create([
                        'user_id' => $user->id,
                        'draw_id' => $id,
                        'type' => $thisPrize->prize_type,
                        'amount' => $prize,
                    ]);
                    break;
                case 'item':
                    UserPrizes::create([
                        'user_id' => $user->id,
                        'draw_id' => $id,
                        'type' => $thisPrize->prize_type,
                        'amount' => $prize,
                        'prize_id' => $thisPrize->item_id
                    ]);
                    $prizeName = Prize::find($thisPrize->item_id)->name;
                    break;
            }
        }

        return response()->json([
            'name' => $prizeName ?? null,
            'code' => $prizeTypeCode,
            'amount' => $prize,
            'convert' => $convert,
        ]);
    }

    public static function convertMoneyToChips(int $money)
    {
        return (int) ceil($money * self::MONEYMULTIPLER);
    }

    public function convertItemToChips(int $price)
    {
        return self::convertMoneyToChips($price);
    }
}
