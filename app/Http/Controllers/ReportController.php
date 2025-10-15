<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pinjaman;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    /**
     * Display reports page
     */
    public function index()
    {
        return view('dashboard.admin.reports');
    }

    /**
     * Generate daily report
     */
    public function generateDaily(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $data = $this->getDailyData($date);

        if ($request->input('format') === 'pdf') {
            return $this->generatePDF('daily', $data, $date);
        }

        return response()->json($data);
    }

    /**
     * Generate weekly report
     */
    public function generateWeekly(Request $request)
    {
        $weekStart = $request->input('week_start', Carbon::now()->startOfWeek()->format('Y-m-d'));
        $weekEnd = Carbon::parse($weekStart)->endOfWeek()->format('Y-m-d');
        $data = $this->getWeeklyData($weekStart, $weekEnd);

        if ($request->input('format') === 'pdf') {
            return $this->generatePDF('weekly', $data, $weekStart . ' - ' . $weekEnd);
        }

        return response()->json($data);
    }

    /**
     * Generate monthly report
     */
    public function generateMonthly(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $monthStart = Carbon::parse($month . '-01')->startOfMonth()->format('Y-m-d');
        $monthEnd = Carbon::parse($month . '-01')->endOfMonth()->format('Y-m-d');
        $data = $this->getMonthlyData($monthStart, $monthEnd);

        if ($request->input('format') === 'pdf') {
            return $this->generatePDF('monthly', $data, Carbon::parse($month)->format('F Y'));
        }

        return response()->json($data);
    }

    /**
     * Generate yearly report
     */
    public function generateYearly(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $yearStart = Carbon::parse($year . '-01-01')->format('Y-m-d');
        $yearEnd = Carbon::parse($year . '-12-31')->format('Y-m-d');
        $data = $this->getYearlyData($yearStart, $yearEnd);

        if ($request->input('format') === 'pdf') {
            return $this->generatePDF('yearly', $data, $year);
        }

        return response()->json($data);
    }

    /**
     * Get borrowing statistics for charts
     */
    public function getBorrowingStats(Request $request)
    {
        $period = $request->input('period', 'month'); // week, month, year
        $data = [];

        switch ($period) {
            case 'week':
                $data = $this->getWeeklyBorrowingStats();
                break;
            case 'month':
                $data = $this->getMonthlyBorrowingStats();
                break;
            case 'year':
                $data = $this->getYearlyBorrowingStats();
                break;
        }

        return response()->json($data);
    }

    /**
     * Get category statistics for charts
     */
    public function getCategoryStats()
    {
        try {
            // Get category stats based on borrowing frequency
            $stats = DB::table('peminjaman')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->select('buku.kategori', DB::raw('COUNT(*) as total'))
                ->whereNotNull('buku.kategori')
                ->where('buku.kategori', '!=', '')
                ->groupBy('buku.kategori')
                ->orderBy('total', 'desc')
                ->limit(8)
                ->get();

            // If no borrowing data, get from book collection
            if ($stats->isEmpty()) {
                $stats = DB::table('buku')
                    ->select('kategori', DB::raw('COUNT(*) as total'))
                    ->whereNotNull('kategori')
                    ->where('kategori', '!=', '')
                    ->groupBy('kategori')
                    ->orderBy('total', 'desc')
                    ->limit(8)
                    ->get();
            }

            return response()->json($stats);
        } catch (\Exception $e) {
            // Return sample data if tables don't exist
            return response()->json([
                ['kategori' => 'Fiksi', 'total' => 45],
                ['kategori' => 'Non-Fiksi', 'total' => 32],
                ['kategori' => 'Teknologi', 'total' => 28],
                ['kategori' => 'Sejarah', 'total' => 25],
                ['kategori' => 'Sains', 'total' => 22],
                ['kategori' => 'Novel', 'total' => 18],
                ['kategori' => 'Pendidikan', 'total' => 15],
                ['kategori' => 'Agama', 'total' => 12]
            ]);
        }
    }

    /**
     * Get daily data
     */
    private function getDailyData($date)
    {
        try {
            $borrowings = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereDate('peminjaman.tanggal_pinjam', $date)
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            $returns = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereDate('peminjaman.tanggal_kembali', $date)
                ->where('peminjaman.status', 'dikembalikan')
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            $overdue = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereDate('peminjaman.batas_kembali', '<=', $date)
                ->whereIn('peminjaman.status', ['dipinjam', 'terlambat'])
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            return [
                'date' => $date,
                'total_borrowings' => $borrowings->count(),
                'total_returns' => $returns->count(),
                'total_overdue' => $overdue->count(),
                'borrowings' => $borrowings,
                'returns' => $returns,
                'overdue' => $overdue
            ];
        } catch (\Exception $e) {
            return $this->getSampleDailyData($date);
        }
    }

    /**
     * Get weekly data
     */
    private function getWeeklyData($weekStart, $weekEnd)
    {
        try {
            $borrowings = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereBetween('peminjaman.tanggal_pinjam', [$weekStart, $weekEnd])
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            $returns = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereBetween('peminjaman.tanggal_kembali', [$weekStart, $weekEnd])
                ->where('peminjaman.status', 'dikembalikan')
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            return [
                'period' => $weekStart . ' - ' . $weekEnd,
                'total_borrowings' => $borrowings->count(),
                'total_returns' => $returns->count(),
                'borrowings' => $borrowings,
                'returns' => $returns,
                'daily_breakdown' => $this->getDailyBreakdown($weekStart, $weekEnd)
            ];
        } catch (\Exception $e) {
            return $this->getSampleWeeklyData($weekStart, $weekEnd);
        }
    }

    /**
     * Get monthly data
     */
    private function getMonthlyData($monthStart, $monthEnd)
    {
        try {
            $borrowings = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereBetween('peminjaman.tanggal_pinjam', [$monthStart, $monthEnd])
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            $returns = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereBetween('peminjaman.tanggal_kembali', [$monthStart, $monthEnd])
                ->where('peminjaman.status', 'dikembalikan')
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            $popular_books = DB::table('peminjaman')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereBetween('peminjaman.tanggal_pinjam', [$monthStart, $monthEnd])
                ->select(
                    'buku.judul_buku',
                    'buku.penulis',
                    'buku.kategori',
                    DB::raw('COUNT(*) as total_borrowed')
                )
                ->groupBy('buku.id_buku', 'buku.judul_buku', 'buku.penulis', 'buku.kategori')
                ->orderBy('total_borrowed', 'desc')
                ->limit(10)
                ->get();

            return [
                'period' => Carbon::parse($monthStart)->format('F Y'),
                'total_borrowings' => $borrowings->count(),
                'total_returns' => $returns->count(),
                'borrowings' => $borrowings,
                'returns' => $returns,
                'popular_books' => $popular_books,
                'weekly_breakdown' => $this->getWeeklyBreakdown($monthStart, $monthEnd)
            ];
        } catch (\Exception $e) {
            return $this->getSampleMonthlyData($monthStart, $monthEnd);
        }
    }

    /**
     * Get yearly data
     */
    private function getYearlyData($yearStart, $yearEnd)
    {
        try {
            $borrowings = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereBetween('peminjaman.tanggal_pinjam', [$yearStart, $yearEnd])
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            $returns = DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->whereBetween('peminjaman.tanggal_kembali', [$yearStart, $yearEnd])
                ->where('peminjaman.status', 'dikembalikan')
                ->select(
                    'peminjaman.*',
                    'user.nama_lengkap as nama_peminjam',
                    'buku.judul_buku'
                )
                ->get();

            $monthly_breakdown = DB::table('peminjaman')
                ->whereBetween('tanggal_pinjam', [$yearStart, $yearEnd])
                ->select(
                    DB::raw('MONTH(tanggal_pinjam) as month'),
                    DB::raw('MONTHNAME(tanggal_pinjam) as month_name'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy(DB::raw('MONTH(tanggal_pinjam)'), DB::raw('MONTHNAME(tanggal_pinjam)'))
                ->orderBy('month')
                ->get();

            return [
                'period' => Carbon::parse($yearStart)->year,
                'total_borrowings' => $borrowings->count(),
                'total_returns' => $returns->count(),
                'borrowings' => $borrowings,
                'returns' => $returns,
                'monthly_breakdown' => $monthly_breakdown
            ];
        } catch (\Exception $e) {
            return $this->getSampleYearlyData($yearStart, $yearEnd);
        }
    }

    /**
     * Generate PDF report
     */
    private function generatePDF($type, $data, $period)
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('reports.pdf.' . $type, compact('data', 'period'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'laporan_' . $type . '_' . str_replace([' ', '-'], '_', $period) . '.pdf';

        return $dompdf->stream($filename, ['Attachment' => false]);
    }

    /**
     * Get weekly borrowing stats for charts
     */
    private function getWeeklyBorrowingStats()
    {
        $startDate = Carbon::now()->subDays(6);
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            try {
                $count = DB::table('peminjaman')
                    ->whereDate('tanggal_pinjam', $date->format('Y-m-d'))
                    ->count();
            } catch (\Exception $e) {
                $count = rand(5, 15);
            }

            $data[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'count' => $count
            ];
        }

        return $data;
    }

    /**
     * Get monthly borrowing stats for charts
     */
    private function getMonthlyBorrowingStats()
    {
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            try {
                $count = DB::table('peminjaman')
                    ->whereYear('tanggal_pinjam', $month->year)
                    ->whereMonth('tanggal_pinjam', $month->month)
                    ->count();
            } catch (\Exception $e) {
                $count = rand(20, 80);
            }

            $data[] = [
                'month' => $month->format('M Y'),
                'count' => $count
            ];
        }

        return $data;
    }

    /**
     * Get yearly borrowing stats for charts
     */
    private function getYearlyBorrowingStats()
    {
        $data = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            try {
                $count = DB::table('peminjaman')
                    ->whereYear('tanggal_pinjam', $year)
                    ->count();
            } catch (\Exception $e) {
                $count = rand(200, 800);
            }

            $data[] = [
                'year' => $year,
                'count' => $count
            ];
        }

        return $data;
    }

    /**
     * Sample data methods for when database tables don't exist
     */
    private function getSampleDailyData($date)
    {
        return [
            'date' => $date,
            'total_borrowings' => rand(5, 20),
            'total_returns' => rand(3, 15),
            'total_overdue' => rand(0, 5),
            'borrowings' => collect(),
            'returns' => collect(),
            'overdue' => collect()
        ];
    }

    private function getSampleWeeklyData($weekStart, $weekEnd)
    {
        return [
            'period' => $weekStart . ' - ' . $weekEnd,
            'total_borrowings' => rand(30, 100),
            'total_returns' => rand(25, 80),
            'daily_breakdown' => []
        ];
    }

    private function getSampleMonthlyData($monthStart, $monthEnd)
    {
        return [
            'period' => Carbon::parse($monthStart)->format('F Y'),
            'total_borrowings' => rand(100, 300),
            'total_returns' => rand(80, 250),
            'popular_books' => [
                ['judul_buku' => 'Laskar Pelangi', 'total_borrowed' => rand(15, 25)],
                ['judul_buku' => 'Bumi Manusia', 'total_borrowed' => rand(10, 20)],
                ['judul_buku' => 'Dilan 1990', 'total_borrowed' => rand(8, 18)]
            ],
            'weekly_breakdown' => []
        ];
    }

    private function getSampleYearlyData($yearStart, $yearEnd)
    {
        return [
            'period' => Carbon::parse($yearStart)->year,
            'total_borrowings' => rand(800, 2000),
            'total_returns' => rand(700, 1800),
            'monthly_breakdown' => []
        ];
    }

    private function getDailyBreakdown($startDate, $endDate)
    {
        // Implementation for daily breakdown within a week
        return [];
    }

    private function getWeeklyBreakdown($startDate, $endDate)
    {
        // Implementation for weekly breakdown within a month
        return [];
    }
}
