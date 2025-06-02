<?php

namespace App\Console\Commands;

use App\Enums\EmailTypeEnum;
use App\Models\Borrow;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Russel\Communicationservice\Contracts\ServiceCommunicatorInterface;

class SendBorrowDueReminders extends Command
{
    protected $signature = 'borrows:send-due-reminders';
    protected $description = 'Envoie des rappels pour les emprunts dont il reste 3 jours ou moins avant l\'échéance';

    public function handle(ServiceCommunicatorInterface $communicator)
    {
        Log::info('Début de l\'exécution de borrows:send-due-reminders');
        $this->info('Recherche des emprunts arrivant à échéance dans 1 à 3 jours...');

        // Recherche des emprunts avec due_date dans 1 à 3 jours
        $minDueDate = now()->addDay()->startOfDay();
        $maxDueDate = now()->addDays(3)->endOfDay();

        $borrows = Borrow::whereNull('return_date')
                         ->whereBetween('due_date', [$minDueDate, $maxDueDate])
                         ->with(['book', 'borrower'])
                         ->get();

        // Affichage des emprunts trouvés dans la console
        $this->info("\nEmprunts trouvés (" . $borrows->count() . ") :");
        $this->table(
            ['ID', 'Livre', 'Emprunteur', 'Date retour', 'Jours restants'],
            $borrows->map(function ($borrow) {
                $daysRemaining = now()->diffInDays($borrow->due_date, false);
                return [
                    $borrow->id,
                    $borrow->book->title ?? 'N/A',
                    $borrow->borrower->username ?? 'N/A',
                    $borrow->due_date,
                    $daysRemaining
                ];
            })
        );

        if ($borrows->isEmpty()) {
            Log::info('Aucun emprunt avec une échéance dans les 3 prochains jours.');
            $this->info('Aucun rappel à envoyer.');
            return;
        }

        $this->info("\nEnvoi des notifications...");
        $successCount = 0;

        foreach ($borrows as $borrow) {
            $daysRemaining = now()->diffInDays($borrow->due_date, false);
            
            if (!$borrow->book || !$borrow->borrower) {
                $message = "Livre ou emprunteur introuvable pour l'emprunt ID {$borrow->id}";
                Log::error($message);
                $this->error($message);
                continue;
            }

            $notificationData = [
                'type' => EmailTypeEnum::EMAILDUEREMINDER->value,
                'data' => [
                    'dueDate' => $borrow->due_date,
                    'bookTitle' => $borrow->book->title,
                    'borrowerName' => $borrow->borrower->username,
                    'to' => $borrow->borrower->email,
                    'daysRemaining' => $daysRemaining,
                ]
            ];

            if (empty($notificationData['data']['to'])) {
                $message = "Adresse email manquante pour l'emprunt ID {$borrow->id}";
                Log::error($message);
                $this->error($message);
                continue;
            }

            $this->info("\nEnvoi à: {$notificationData['data']['to']}");
            $this->line("Livre: {$notificationData['data']['bookTitle']}");
            $this->line("Date retour: {$notificationData['data']['dueDate']} (J-{$daysRemaining})");

            $response = $communicator->call(
                service: 'NOTIFICATION-service',
                method: 'post',
                endpoint: '/api/notification/send',
                data: $notificationData,
                headers: []
            );

            if ($response->successful()) {
                $successCount++;
                Log::info("Notification envoyée pour l'emprunt ID {$borrow->id} (J-{$daysRemaining})");
                $this->info("✔ Succès");
            } else {
                Log::error("Échec de l'envoi pour l'emprunt ID {$borrow->id}");
                $this->error("✖ Échec: " . $response->status());
            }
        }

        Log::info("Fin de l'exécution. Notifications envoyées: {$successCount}/{$borrows->count()}");
        $this->info("\nRésumé:");
        $this->info("• Emprunts traités: " . $borrows->count());
        $this->info("• Notifications envoyées avec succès: {$successCount}");
        $this->info("• Échecs: " . ($borrows->count() - $successCount));
        $this->info("\nTraitement terminé.");
    }
}