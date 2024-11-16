<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Administrateur;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
       

        public function created(User $user)
        {
            Log::info('Observer exécuté pour l\'utilisateur ID : ' . $user->id);
        
            if ($user->role === 'admin') {
                $codeAdmin = Str::uuid()->toString();  // Génère un code admin unique
        
                Administrateur::create([
                    'codeAdmin' => $codeAdmin,
                    'user_id' => $user->id,
                ]);
        
                Log::info('Administrateur créé pour l\'utilisateur ID : ' . $user->id);
            }
        }
        
}
