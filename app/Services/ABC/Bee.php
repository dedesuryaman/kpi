<?php

namespace App\Services\ABC;

class Bee
{
    /**
     * Bobot KPI
     * [attendance, productivity, quality, discipline, innovation]
     */
    public array $solution = [];

    /**
     * Nilai fitness solusi
     */
    public float $fitness = 0.0;

    /**
     * Probabilitas dipilih oleh Onlooker Bee
     */
    public float $probability = 0.0;

    /**
     * Jumlah percobaan tanpa perbaikan
     */
    public int $trial = 0;

    /**
     * Konstruktor
     */
    public function __construct(array $solution = [])
    {
        $this->solution = $solution;
    }

    /**
     * Mengembalikan bobot Attendance
     */
    public function attendance(): float
    {
        return $this->solution[0] ?? 0;
    }

    /**
     * Mengembalikan bobot Productivity
     */
    public function productivity(): float
    {
        return $this->solution[1] ?? 0;
    }

    /**
     * Mengembalikan bobot Quality
     */
    public function quality(): float
    {
        return $this->solution[2] ?? 0;
    }

    /**
     * Mengembalikan bobot Discipline
     */
    public function discipline(): float
    {
        return $this->solution[3] ?? 0;
    }

    /**
     * Mengembalikan bobot Innovation
     */
    public function innovation(): float
    {
        return $this->solution[4] ?? 0;
    }

    /**
     * Mengubah solusi
     */
    public function setSolution(array $solution): void
    {
        $this->solution = $solution;
    }

    /**
     * Mengubah nilai fitness
     */
    public function setFitness(float $fitness): void
    {
        $this->fitness = $fitness;
    }

    /**
     * Mengubah probabilitas
     */
    public function setProbability(float $probability): void
    {
        $this->probability = $probability;
    }

    /**
     * Reset trial
     */
    public function resetTrial(): void
    {
        $this->trial = 0;
    }

    /**
     * Tambah trial
     */
    public function increaseTrial(): void
    {
        $this->trial++;
    }
}
