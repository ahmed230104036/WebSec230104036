<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class AssignReviewPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:assign-review {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign add_review permission to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }
        
        $permission = Permission::where('name', 'add_review')->first();
        
        if (!$permission) {
            $this->error("Permission 'add_review' not found!");
            return 1;
        }
        
        $user->givePermissionTo($permission);
        
        $this->info("Successfully assigned 'add_review' permission to user {$user->name}");
        
        return 0;
    }
}
