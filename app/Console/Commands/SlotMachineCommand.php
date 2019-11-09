<?php
    /**
     * File defines class for a console command to send
     *
     * @category Console_Command
     * @package  App\Console\Commands
     */

    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use App\Http\Controllers\SlotController;

    /**
     * Class SlotMachineCommand
     *
     * @category Console_Command
     * @package  App\Console\Commands
     */
class SlotMachineCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "slot:spin";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Spin the slot to win";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            $slot = new SlotController;
            echo json_encode($slot->run(), JSON_PRETTY_PRINT);
    }
}
