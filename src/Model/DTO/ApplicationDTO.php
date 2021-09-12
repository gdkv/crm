<?php

namespace App\Model\DTO;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Validator\Constraints as Assert;

class ApplicationDTO
{
    public function __construct(
        private string $actionAt,
        private ?string $arrivedAt,
        private ?string $type,
        private ?string $status,
        private array $client,
        private ?array $operator,
        private ?array $manager,
        private ?array $car,
        private ?bool $isCredit,
        private bool $isTradeIn,
        private array $gift,
        private array $attempts,
        private ?string $source,
        private ?string $reason,
        private ?array $credit,
        private ?array $comments,
        private ?array $targets,
        private bool $isProcessed,
    ){}

    public static function resolver(Request $request)
    {
        $request->request = new InputBag($request->toArray());

        return new static(
            $request->request->get('actionAt'),
            $request->request->get('arrivedAt', null),
            $request->request->get('type', 'MANUAL'),
            $request->request->get('status', 'CALL'),
            $request->request->all('client'),
            $request->request->all('operator'),
            $request->request->all('manager'),
            $request->request->all('car'),
            $request->request->get('isCredit', null),
            $request->request->get('isTradeIn', false),
            $request->request->all('gift'),
            $request->request->all('attempts'),
            $request->request->get('source'),
            $request->request->get('reason'),
            $request->request->all('credit'),
            $request->request->all('comments'),
            $request->request->all('targets'),
            $request->request->get('isProcessed', false),
        );
    }

    public function getActionAt(): DateTimeInterface
    {
        return new DateTime($this->actionAt);
    }

    public function getArrivedAt(): ?DateTimeInterface
    {
        return $this->arrivedAt ? new DateTime($this->arrivedAt) : null;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getClient(): array
    {
        return $this->client;
    }

    public function getOperator(): ?string
    {   
        $operatorId = null;
        if (count($this->operator) && isset($this->operator['id'])){
            $operatorId = $this->operator['id'];
        }
        return $operatorId;
    }

      
    public function getManager(): ?string
    {
        $managerId = null;
        if (count($this->manager) && isset($this->manager['id'])){
            $managerId = $this->manager['id'];
        }
        return $managerId;
    }

    public function getCar(): ?array
    {
        return $this->car;
    }

    public function getIsCredit(): ?bool
    {
        return $this->isCredit;
    }

    public function getIsTradeIn(): bool
    {
        return $this->isTradeIn;
    }

    public function getGift(): ?array
    {
        return $this->gift;
    }

    public function getAttempts(): array
    {
        $attempts = [
            ["order" => 1, "success" => null, "date" => null, ],
            ["order" => 2, "success" => null, "date" => null, ],
            ["order" => 3, "success" => null, "date" => null, ],
            ["order" => 4, "success" => null, "date" => null, ],
            ["order" => 5, "success" => null, "date" => null, ],
        ];
        return (array)$this->attempts + $attempts;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function getCredit(): ?array
    {
        return $this->credit;
    }

    public function getComments(): ?array
    {
        return $this->comments;
    }

    public function getTargets(): ?array
    {
        return $this->targets;
    }

    public function getIsProcessed(): bool
    {
        return $this->isProcessed;
    }
}