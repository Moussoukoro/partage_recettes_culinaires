<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StandardizePhotoPaths extends Command
{
    protected $signature = 'photos:standardize';
    protected $description = 'Standardise les chemins des photos et nettoie les anciennes photos';

    // Nouveau chemin standard pour les photos
    const NEW_PHOTO_PATH = 'photos/users';
    // Photo par défaut
    const DEFAULT_PHOTO = 'photos/pp.png';
    
    public function handle()
    {
        $this->info('Début de la standardisation des chemins des photos...');
        
        // Vérifie si la photo par défaut existe, sinon la crée
        $this->ensureDefaultPhotoExists();
        
        // Début d'une transaction pour assurer l'intégrité des données
        DB::beginTransaction();
        
        try {
            $users = User::whereNotNull('photo')->get();
            
            foreach ($users as $user) {
                $this->standardizeUserPhoto($user);
            }
            
            // Si tout s'est bien passé, on valide les changements
            DB::commit();
            $this->info('Standardisation terminée avec succès!');
            
        } catch (\Exception $e) {
            // En cas d'erreur, on annule toutes les modifications
            DB::rollback();
            $this->error('Une erreur est survenue: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    protected function ensureDefaultPhotoExists()
    {
        if (!Storage::disk('public')->exists(self::DEFAULT_PHOTO)) {
            $this->info('Création du dossier pour la photo par défaut...');
            Storage::disk('public')->makeDirectory(dirname(self::DEFAULT_PHOTO));
            
            // Copie une image par défaut si elle existe dans resources
            $defaultSourcePath = resource_path('images/default-profile.png');
            if (file_exists($defaultSourcePath)) {
                Storage::disk('public')->put(
                    self::DEFAULT_PHOTO,
                    file_get_contents($defaultSourcePath)
                );
            } else {
                // Crée une image par défaut simple si nécessaire
                $this->createBasicDefaultImage();
            }
        }
    }

    protected function createBasicDefaultImage()
    {
        // Crée une image par défaut basique
        $img = imagecreatetruecolor(200, 200);
        $bgColor = imagecolorallocate($img, 240, 240, 240);
        imagefill($img, 0, 0, $bgColor);
        
        ob_start();
        imagepng($img);
        $imageData = ob_get_clean();
        imagedestroy($img);
        
        Storage::disk('public')->put(self::DEFAULT_PHOTO, $imageData);
    }
    
    protected function standardizeUserPhoto(User $user)
    {
        $oldPath = $user->photo;
        
        // Vérifie si le chemin est déjà correct
        if (str_starts_with($oldPath, self::NEW_PHOTO_PATH)) {
            $this->info("Photo de l'utilisateur {$user->id} déjà dans le bon format: {$oldPath}");
            return;
        }
        
        // Extrait le nom du fichier de l'ancien chemin
        $fileName = basename($oldPath);
        
        // Construit le nouveau chemin
        $newPath = self::NEW_PHOTO_PATH . '/' . $fileName;
        
        // Vérifie si l'ancien fichier existe
        if (Storage::disk('public')->exists($oldPath)) {
            try {
                // Crée le répertoire de destination s'il n'existe pas
                Storage::disk('public')->makeDirectory(self::NEW_PHOTO_PATH);
                
                // Déplace le fichier vers le nouveau chemin
                Storage::disk('public')->move($oldPath, $newPath);
                
                // Met à jour le chemin dans la base de données
                $user->update(['photo' => $newPath]);
                
                $this->info("Photo déplacée pour l'utilisateur {$user->id}: {$oldPath} -> {$newPath}");
            } catch (\Exception $e) {
                $this->warn("Impossible de déplacer la photo de l'utilisateur {$user->id}: {$e->getMessage()}");
                // Utilise la photo par défaut en cas d'erreur
                $user->update(['photo' => self::DEFAULT_PHOTO]);
            }
        } else {
            $this->warn("Fichier non trouvé pour l'utilisateur {$user->id}: {$oldPath}");
            // Utilise la photo par défaut si le fichier n'existe pas
            $user->update(['photo' => self::DEFAULT_PHOTO]);
        }
    }
}