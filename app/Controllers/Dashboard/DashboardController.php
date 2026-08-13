<?php

declare(strict_types=1);

class DashboardController extends Controller
{
    private DashboardService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new DashboardService();
    }
    public function index(): void
    {

        $this->view->render(
            'dashboard/index',
            [
                'title' => 'Dashboard',
                'dashboardStats' => $this->service->getDashboardStatistics2('month'),
                'recentActivities' => $this->service->getRecentActivity(10), // past 10 days of activity
                // 'attentionNeeded' => $this->service->getAttentionRequired(),
                // 'schedule' => $this->service->getClinicSchedule(),
                // 'upcomingVisites' => $this->service->getUpcomingFollowups(),
                // 'upcommingBirths' => $this->service->getUpcomingBirths(),
                // 'chartData' => $this->service->getChartData()
            ]
        );
    }

    // get time period related statistics
    public function statisticsApi(): void
    {
        $category = $this->request->query('category') ?? '';
        $period = $this->request->query('period') ?? 'month';

        $stats = $this->service->getTrendStatistics($category, $period);
        echo json_encode($stats);
    }
}
