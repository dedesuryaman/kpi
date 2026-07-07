<?php

namespace App\Services\ABC;


use App\Models\KpiScore;
use App\Models\KpiMaster;

class ArtificialBeeColony
{
    protected int $populationSize;
    protected int $maxIteration;
    protected int $limit;

    protected array $population = [];
    protected ?Bee $best = null;
    protected array $history = [];

    protected array $masters = [];

    public function __construct(
        int $populationSize = 20,
        int $maxIteration = 100,
        int $limit = 20
    ) {
        $this->populationSize = $populationSize;
        $this->maxIteration = $maxIteration;
        $this->limit = $limit;
    }

    public function run(int $periodId): array
    {
        $start = microtime(true);

        /*
        |-----------------------------------------
        | LOAD DATA
        |-----------------------------------------
        */


        $scores = KpiScore::with('indicator')
            ->where('period_id', $periodId)
            ->get();


        if ($scores->isEmpty()) {
            throw new \Exception('KPI Score tidak ditemukan.');
        }

        // 🔥 LOAD KPI MASTER (DINAMIS)
        $this->masters = KpiMaster::where('status', 1)
            ->orderBy('id')
            ->get()
            ->values()
            ->all();

        $dimension = count($this->masters);

        /*
        |-----------------------------------------
        | GENERATE POPULATION (DINAMIS DIMENSION)
        |-----------------------------------------
        */

        $this->population = (new Population())
            ->generate($this->populationSize, $dimension);

        /*
        |-----------------------------------------
        | FITNESS AWAL
        |-----------------------------------------
        */

        $fitness = new Fitness();

        foreach ($this->population as $bee) {
            $bee->fitness = $fitness->calculate(
                $bee->solution,
                $scores,
                $this->masters
            );
        }

        $this->memorizeBest();

        /*
        |-----------------------------------------
        | MAIN LOOP
        |-----------------------------------------
        */

        for ($i = 1; $i <= $this->maxIteration; $i++) {

            (new EmployedBee())->run($this->population, $scores, $this->masters);

            (new OnlookerBee())->run($this->population, $scores, $this->masters);

            (new ScoutBee())->run($this->population, $scores, $this->limit, $this->masters);

            $this->memorizeBest();

            $this->history[] = [
                'iteration' => $i,
                'fitness' => $this->best->fitness,
            ];
        }

        /*
        |-----------------------------------------
        | SIMPAN HASIL ABC (DINAMIS)
        |-----------------------------------------
        */


        $executionTime = (microtime(true) - $start) * 1000;


        return [

            'fitness' => $this->best->fitness,

            'weights' => $this->buildWeights(),

            'history' => $this->history,

            'population_size' => $this->populationSize,

            'max_iteration' => $this->maxIteration,

            'limit_trial' => $this->limit,

            'execution_time' => round($executionTime),

        ];
    }

    /**
     * 🔥 BUILD WEIGHTS DINAMIS
     */
    protected function buildWeights(): array
    {
        $weights = [];

        foreach ($this->masters as $index => $master) {
            $weights[$master->id] = [
                'kpi_master_id' => $master->id,
                'name' => $master->name,
                'weight' => $this->best->solution[$index] ?? 0,
            ];
        }

        return $weights;
    }

    /**
     * SIMPAN BEST SOLUTION
     */
    protected function memorizeBest(): void
    {
        foreach ($this->population as $bee) {

            if ($this->best === null || $bee->fitness > $this->best->fitness) {
                $this->best = clone $bee;
            }
        }
    }
}
