<?php

namespace App\Modules\Contact\Application\Services;

use App\Modules\Contact\Domain\Interfaces\ContactRepositoryInterface;
use App\Modules\Shared\Application\Services\MailRelayService;

class ContactService
{
    public function __construct(
        protected ContactRepositoryInterface $repository
    ) {}

    public function paginate(int $perPage = 15, string $search = '', string $filterType = '', string $sortBy = 'created_at', string $sortDirection = 'desc')
    {
        return $this->repository->paginate($perPage, $search, $filterType, $sortBy, $sortDirection);
    }
    
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function delete(int $id): bool
    {
        $submission = $this->repository->find($id);
        if ($submission) {
            return $this->repository->delete($submission);
        }
        return false;
    }

    public function subscribeToNewsletter(int $id): array
    {
        $submission = $this->repository->find($id);
        
        if (!$submission) {
             return ['success' => false, 'message' => 'Submission not found'];
        }

        if ($submission->subscribed_to_mailrelay) {
            return ['success' => false, 'message' => 'El usuario ya está suscrito al newsletter.', 'type' => 'warning'];
        }

        $mailRelayService = new MailRelayService();

        $additionalData = [];
        if ($submission->telefono) {
            $additionalData['telefono'] = $submission->telefono;
        }
        if ($submission->organizacion) {
            $additionalData['organizacion'] = $submission->organizacion;
        }

        $success = $mailRelayService->subscribeContact(
            $submission->email,
            $submission->nombre ?? $submission->email,
            $additionalData
        );

        if ($success) {
            $this->repository->update($submission, ['subscribed_to_mailrelay' => true]);
            return ['success' => true, 'message' => 'Usuario suscrito al newsletter exitosamente.', 'type' => 'success'];
        } else {
            return ['success' => false, 'message' => 'Error al suscribir usuario al newsletter. Intenta de nuevo.', 'type' => 'error'];
        }
    }
}
