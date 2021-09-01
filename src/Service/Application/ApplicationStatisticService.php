<?php
namespace App\Service\Application;

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
        $statisticArray = [];
        $statistic = $this->applicationRepository->findStatistic($filters, [], $limit);
        foreach($statistic as $statisticValues) {
            $statisticArray[$statisticValues['status']->getValue()] = $statisticValues['count'];
        }

        $currentStatic = array_map(
            fn(string $key): array => [
                $key => isset($statisticArray[$key]) ? $statisticArray[$key] : 0
            ], 
            array_keys($this->statisticArray)
        );
        
        return $this->arrayToKey($currentStatic);
            
    }

    private function arrayToKey (array $arr = []):array 
    {
        $fixedArray = [];
        foreach($arr as $item) {

            foreach($item as $key => $value) {
                $fixedArray[$key] = $value;
            }
        }
        return $fixedArray;
    }
}