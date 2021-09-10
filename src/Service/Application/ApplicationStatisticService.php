<?php
namespace App\Service\Application;

use App\Model\Enum\ApplicationStatus;
use App\Repository\ApplicationRepository;

class ApplicationStatisticService {
    public function __construct(
        private ApplicationRepository $applicationRepository,
        private array $statisticArray = [
            'CALL' => 0,
            'MEETING' => 0,
            'ARRIVED' => 0,
            'IMPORTANT' => 0,
            'CREDIT' => 0,
        ],
    ){}

    public function __invoke(array $filters=[], int $limit=0): array
    {
        $statistic = $this->applicationRepository->findStatistic($filters, [], $limit);
        foreach($this->statisticArray as $statisticKey => $statisticValue) {
            $currentStatus = ApplicationStatus::get($statisticKey);
            $index = array_search($currentStatus, array_column($statistic, 'status'));

            if ($index !== false) {
                $this->statisticArray[$statisticKey] = $statistic[$index]['count'];
            }
        }
        
        return $this->statisticArray;
    }

}