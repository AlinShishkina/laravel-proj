<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Сохранить визит (принимает данные от JS)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ip' => 'nullable|string|max:45',
            'city' => 'nullable|string|max:255',
            'device' => 'nullable|string|max:50',
        ]);

        Visit::create($validated);

        return response()->json(['message' => 'OK'], 201);
    }

    /**
     * Показать страницу статистики (только после авторизации)
     */
    public function index()
    {
        return view('statistics');
    }

    /**
     * Отдать данные для графиков в формате JSON
     */
    public function getChartData()
    {
        // Данные для графика посещений по часам (уникальные IP за час)
        $hourlyData = Visit::select(
                DB::raw("strftime('%Y-%m-%d %H:00:00', created_at) as hour"),
                DB::raw("COUNT(DISTINCT ip) as unique_visitors")
            )
            ->where('created_at', '>=', now()->subDays(7)) // последние 7 дней
            ->groupBy('hour')
            ->orderBy('hour', 'asc')
            ->get()
            ->map(fn($item) => [
                'hour' => $item->hour,
                'count' => $item->unique_visitors
            ]);

        // Данные для диаграммы: разбивка по городам (топ-5, остальные – "Другие")
        $cityStats = Visit::select('city', DB::raw('COUNT(*) as total'))
            ->whereNotNull('city')
            ->where('city', '!=', 'unknown')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        $topCities = $cityStats->take(5);
        $otherCount = $cityStats->skip(5)->sum('total');

        $pieData = $topCities->map(fn($item) => [
            'city' => $item->city,
            'total' => $item->total
        ])->values();

        if ($otherCount > 0) {
            $pieData->push(['city' => 'Другие', 'total' => $otherCount]);
        }

        return response()->json([
            'hourly' => $hourlyData,
            'cities' => $pieData
        ]);
    }

    /**
     * Авторизация (пароль: secret123)
     */
    public function login(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        if ($request->password === 'secret123') {
            session(['statistics_authenticated' => true]);
            return redirect()->route('statistics');
        }

        return back()->withErrors(['password' => 'Неверный пароль']);
    }

    /**
     * Выход (сброс сессии)
     */
    public function logout()
    {
        session()->forget('statistics_authenticated');
        return redirect('/');
    }
}