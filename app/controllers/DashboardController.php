<?php
/**
 * Dashboard Controller — TSILIZY Nexus
 */

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $userId = Auth::id();
        $taskModel = new Task();
        $projectModel = new Project();
        $contactModel = new Contact();
        $noteModel = new Note();

        // Stats
        $totalTasks = $taskModel->count(['user_id' => $userId]);
        $todoTasks = $taskModel->count(['user_id' => $userId, 'status' => 'todo']);
        $inProgressTasks = $taskModel->count(['user_id' => $userId, 'status' => 'in_progress']);
        $doneTasks = $taskModel->count(['user_id' => $userId, 'status' => 'done']);
        $totalProjects = $projectModel->count(['user_id' => $userId]);
        $activeProjects = $projectModel->count(['user_id' => $userId, 'status' => 'active']);
        $totalContacts = $contactModel->count(['user_id' => $userId]);
        $totalNotes = $noteModel->count(['user_id' => $userId]);

        // Recent tasks
        $recentTasks = $taskModel->where(['user_id' => $userId], 'updated_at', 'DESC');
        $recentTasks = array_slice($recentTasks, 0, 5);

        // Active projects
        $projects = $projectModel->where(['user_id' => $userId, 'status' => 'active'], 'updated_at', 'DESC');
        $projects = array_slice($projects, 0, 4);

        // Upcoming events
        $eventModel = new Event();
        $upcomingEvents = $eventModel->raw(
            "SELECT * FROM events WHERE user_id = :uid AND start_date >= NOW() AND deleted_at IS NULL ORDER BY start_date ASC LIMIT 5",
            ['uid' => $userId]
        );

        $this->view('dashboard.index', [
            'pageTitle'       => __('dashboard'),
            'totalTasks'      => $totalTasks,
            'todoTasks'       => $todoTasks,
            'inProgressTasks' => $inProgressTasks,
            'doneTasks'       => $doneTasks,
            'totalProjects'   => $totalProjects,
            'activeProjects'  => $activeProjects,
            'totalContacts'   => $totalContacts,
            'totalNotes'      => $totalNotes,
            'recentTasks'     => $recentTasks,
            'projects'        => $projects,
            'upcomingEvents'  => $upcomingEvents,
        ]);
    }
}
