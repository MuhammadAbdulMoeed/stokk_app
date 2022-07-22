<?php

namespace App\Console\Commands;

use App\Services\Socket\ChatService;
use Illuminate\Console\Command;
use PHPSocketIO\SocketIO;
use Workerman\Worker;

class Socket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $socketChatService;

    public function __construct(ChatService $socketChatService)
    {
        parent::__construct();
        $this->socketChatService = $socketChatService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $io = new SocketIO(8081);
        $io->on('connection', function ($socket) use ($io) {

            $socket->on('conversation-list', function ($data) use ($io, $socket) {
                return $this->socketChatService->conversationList($io,$socket,$data);
            });

            $socket->on('send-message', function ($data) use ($io, $socket) {
                return $this->socketChatService->sendMessage($io, $socket, $data);
            });
        });

        Worker::runAll();
    }
}
