<?php
require_once 'includes/config.php';
require_once 'classes/Goal.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

$goal = new Goal();
$userId = getUserId();

// Get current month and year
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Handle month navigation
if(isset($_GET['action'])) {
    if($_GET['action'] == 'prev') {
        $month--;
        if($month < 1) {
            $month = 12;
            $year--;
        }
    } elseif($_GET['action'] == 'next') {
        $month++;
        if($month > 12) {
            $month = 1;
            $year++;
        }
    }
}

// Get first day of month and number of days in month
$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
$numberOfDays = date('t', $firstDayOfMonth);
$firstDayOfWeek = date('w', $firstDayOfMonth);

// Adjust for Sunday being 0
$firstDayOfWeek = $firstDayOfWeek == 0 ? 6 : $firstDayOfWeek - 1;

// Get start and end dates for calendar
$startDate = date('Y-m-d', strtotime("first day of this month", $firstDayOfMonth));
$endDate = date('Y-m-d', strtotime("last day of this month", $firstDayOfMonth));

// Get goals for this month
$calendarGoals = $goal->getCalendarGoals($userId, $startDate, $endDate);

// Organize goals by date
$goalsByDate = [];
foreach($calendarGoals as $goalItem) {
    $goalsByDate[$goalItem->due_date][] = $goalItem;
}

$page_title = "Calendar - GoalTrack Pro";
include 'includes/header.php';
?>

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Calendar Content -->
        <main class="px-6 py-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8 dark:bg-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?php echo date('F Y', $firstDayOfMonth); ?></h3>
                    <div class="flex space-x-2">
                        <a href="?action=prev&month=<?php echo $month; ?>&year=<?php echo $year; ?>" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-chevron-left text-gray-600 dark:text-gray-400"></i>
                        </a>
                        <a href="calendar.php" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-calendar-day text-gray-600 dark:text-gray-400"></i>
                        </a>
                        <a href="?action=next&month=<?php echo $month; ?>&year=<?php echo $year; ?>" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-chevron-right text-gray-600 dark:text-gray-400"></i>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-7 gap-2 mb-2 text-center">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Mon</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Tue</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Wed</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Thu</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Fri</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Sat</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Sun</div>
                </div>

                <div class="grid grid-cols-7 gap-2">
                    <?php 
                    // Fill in blank days from previous month
                    for($i = 0; $i < $firstDayOfWeek; $i++) {
                        echo '<div class="h-24 p-1 border border-gray-200 rounded bg-gray-100 text-gray-400 dark:bg-gray-700 dark:border-gray-600"></div>';
                    }
                    
                    // Current month days
                    for($day = 1; $day <= $numberOfDays; $day++) {
                        $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
                        $isToday = ($day == date('j') && $month == date('n') && $year == date('Y'));
                        
                        echo '<div class="h-24 p-1 border border-gray-200 rounded ' . ($isToday ? 'bg-blue-50 dark:bg-blue-900' : '') . '">';
                        echo '<span class="' . ($isToday ? 'font-bold text-blue-600 dark:text-blue-300' : '') . '">' . $day . '</span>';
                        
                        // Display goals for this day
                        if(isset($goalsByDate[$currentDate])) {
                            foreach($goalsByDate[$currentDate] as $goalItem) {
                                echo '<div class="mt-1 text-xs p-1 rounded truncate ' . getPriorityBadge($goalItem->priority) . '">' . htmlspecialchars($goalItem->title) . '</div>';
                            }
                        }
                        
                        echo '</div>';
                        
                        // Start new row after Sunday
                        if(($day + $firstDayOfWeek) % 7 == 0 && $day != $numberOfDays) {
                            echo '</div><div class="grid grid-cols-7 gap-2">';
                        }
                    }
                    
                    // Fill in blank days from next month
                    $remainingDays = 7 - (($numberOfDays + $firstDayOfWeek) % 7);
                    if($remainingDays < 7) {
                        for($i = 0; $i < $remainingDays; $i++) {
                            echo '<div class="h-24 p-1 border border-gray-200 rounded bg-gray-100 text-gray-400 dark:bg-gray-700 dark:border-gray-600"></div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>