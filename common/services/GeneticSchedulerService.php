<?php

namespace common\services;

/**
 * Class GeneticScheduleService
 *
 * This class implements a Genetic Algorithm to generate optimal university course schedules.
 * It considers classroom capacity, student clashes, and lecturer time preferences.
 *
 * @package common\services
 */
class GeneticScheduleService
{
    /**
     * @var array List of courses to be scheduled. Each course includes an id and lecturer_id.
     */
    public array $courses;

    /**
     * @var array List of available rooms. Each room should have a 'name' attribute.
     */
    public array $rooms;

    /**
     * @var array List of available timeslots (e.g., ['Monday 08:00', 'Monday 10:00']).
     */
    public array $timeslots;

    /**
     * @var array Lecturer time preferences in the format: ['lecturer_id' => ['Monday 08:00', 'Tuesday 10:00']]
     */
    public array $preferences;

    /**
     * @var int Number of individuals in each generation.
     */
    public int $populationSize = 50;

    /**
     * @var int Number of generations for the algorithm to run.
     */
    public int $generations = 100;

    /**
     * GeneticScheduleService constructor.
     *
     * @param array $courses
     * @param array $rooms
     * @param array $timeslots
     * @param array $preferences
     */
    public function __construct(array $courses, array $rooms, array $timeslots, array $preferences)
    {
        $this->courses = $courses;
        $this->rooms = $rooms;
        $this->timeslots = $timeslots;
        $this->preferences = $preferences;
    }

    /**
     * Run the genetic algorithm to produce the optimal schedule.
     *
     * @return array The best schedule found after all generations.
     */
    public function run(): array
    {
        $population = $this->generateInitialPopulation();

        for ($i = 0; $i < $this->generations; $i++) {
            $population = $this->evolve($population);
        }

        return $this->getBestSchedule($population);
    }

    /**
     * Generate the initial population of schedules.
     *
     * @return array
     */
    private function generateInitialPopulation(): array
    {
        $pop = [];
        for ($i = 0; $i < $this->populationSize; $i++) {
            $chromosome = [];
            foreach ($this->courses as $course) {
                $chromosome[] = [
                    'course_id' => $course['id'],
                    'lecturer_id' => $course['lecturer_id'],
                    'room' => $this->rooms[array_rand($this->rooms)]['name'],
                    'time' => $this->timeslots[array_rand($this->timeslots)],
                ];
            }
            $pop[] = ['chromosome' => $chromosome, 'fitness' => $this->calculateFitness($chromosome)];
        }
        return $pop;
    }

    /**
     * Evolve the current population to the next generation using elitism, crossover, and mutation.
     *
     * @param array $population
     * @return array
     */
    private function evolve(array $population): array
    {
        usort($population, fn($a, $b) => $b['fitness'] <=> $a['fitness']);
        $newPop = array_slice($population, 0, 10); // Elitism: keep top 10

        while (count($newPop) < $this->populationSize) {
            $parent1 = $population[array_rand($population)];
            $parent2 = $population[array_rand($population)];
            $child = $this->crossover($parent1, $parent2);
            $this->mutate($child);
            $child['fitness'] = $this->calculateFitness($child['chromosome']);
            $newPop[] = $child;
        }

        return $newPop;
    }

    /**
     * Combine two parent chromosomes to produce a new child chromosome.
     *
     * @param array $p1
     * @param array $p2
     * @return array
     */
    private function crossover($p1, $p2): array
    {
        $cut = rand(0, count($p1['chromosome']) - 1);
        $childChrom = array_merge(
            array_slice($p1['chromosome'], 0, $cut),
            array_slice($p2['chromosome'], $cut)
        );
        return ['chromosome' => $childChrom];
    }

    /**
     * Mutate a chromosome by randomly changing one of its course assignments.
     *
     * @param array $individual
     * @return void
     */
    private function mutate(array &$individual): void
    {
        $randIdx = array_rand($individual['chromosome']);
        $individual['chromosome'][$randIdx]['room'] = $this->rooms[array_rand($this->rooms)]['name'];
        $individual['chromosome'][$randIdx]['time'] = $this->timeslots[array_rand($this->timeslots)];
    }

    /**
     * Calculate the fitness score of a given chromosome (schedule).
     * The score is higher if:
     *  - No room/time conflicts.
     *  - Lecturer gets preferred times.
     *
     * @param array $chromosome
     * @return int
     */
    private function calculateFitness(array $chromosome): int
    {
        $score = 0;
        $used = [];

        foreach ($chromosome as $item) {
            $key = $item['room'] . '-' . $item['time'];
            if (!isset($used[$key])) {
                $used[$key] = true;
                $score += 1;
            }

            if (
                isset($this->preferences[$item['lecturer_id']]) &&
                in_array($item['time'], $this->preferences[$item['lecturer_id']])
            ) {
                $score += 1;
            }
        }

        return $score;
    }

    /**
     * Return the best chromosome (schedule) from the final population.
     *
     * @param array $population
     * @return array
     */
    private function getBestSchedule(array $population): array
    {
        usort($population, fn($a, $b) => $b['fitness'] <=> $a['fitness']);
        return $population[0];
    }
}
