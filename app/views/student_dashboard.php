<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Dashboard - YoUdemy Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../public/assets/css/tailwind.output.css" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="../../assets/js/init-alpine.js"></script>
  </head>
  <body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
      <!-- Sidebar -->
      <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
        <div class="py-4 text-gray-500 dark:text-gray-400">
          <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            Windmill Dashboard
          </a>
          <ul class="mt-6">
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="student_dashboard.php">
                <span class="ml-4">Dashboard</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="enroll.php">
                <span class="ml-4">Enroll in a Course</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="my_courses.php">
                <span class="ml-4">My Courses</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="logout.php">
                <span class="ml-4">Logout</span>
              </a>
            </li>
          </ul>
        </div>
      </aside>

      <!-- Main Content -->
      <div class="flex flex-col flex-1 w-full">
        <!-- Header -->
        <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
          <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
            <h1 class="text-2xl font-semibold">Student Dashboard</h1>
            <div class="flex items-center">
              <span class="mr-4">Welcome, John Doe!</span>
            </div>
          </div>
        </header>

        <!-- Main Section -->
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <!-- Welcome Message -->
            <div class="my-6">
              <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
                Welcome back, John Doe!
              </h2>
              <p class="text-gray-600 dark:text-gray-400">
                Here's what's happening with your courses and assignments.
              </p>
            </div>

            <!-- Quick Stats -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Total Courses -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Courses
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    5
                  </p>
                </div>
              </div>

              <!-- Completed Assignments -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Completed Assignments
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    12
                  </p>
                </div>
              </div>

              <!-- Pending Assignments -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Pending Assignments
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    3
                  </p>
                </div>
              </div>

              <!-- Overall Progress -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Overall Progress
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    75%
                  </p>
                </div>
              </div>
            </div>

            <!-- Courses Enrolled -->
            <div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                Your Courses
              </h3>
              <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
                <!-- Course Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                  <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                      Course Name
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                      Introduction to Programming
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                      Progress: <span class="font-semibold">60%</span>
                    </p>
                  </div>
                </div>
                <!-- Add more course cards here -->
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>