<?php

namespace Modules\Prize\Console;

use Extensions\Bank\Sender;
use Illuminate\Console\Command;
use Modules\Prize\Entities\PrizeTypes;
use Modules\User\Entities\User;
use Modules\User\Entities\UserPrizes;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prize:sendmoney';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending money to winners';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = current(PrizeTypes::where('code', 'money')->get()->toArray());
        $moneyId = $type['id'];

        $prizes = UserPrizes::where('sended', false)->get()->toArray();

        $sended = 0;
        foreach ($prizes as $prize)
        {
            $user = User::find($prize['user_id']);
            if(Sender::send($user->card_number, $prize['amount'])) {
                UserPrizes::where('id', $prize['id'])->update([
                    'sended' => true,
                ]);
                $sended++;
            }
        }

        echo "Sended to {$sended} users.";
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }
}
