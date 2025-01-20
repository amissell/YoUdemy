<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Courses - YoUdemy Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../public/assets/css/tailwind.output.css" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="../assets/js/init-alpine.js"></script>
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
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="student-dashboard.html">
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
            <h1 class="text-2xl font-semibold">My Courses</h1>
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
                My Courses
              </h2>
              <p class="text-gray-600 dark:text-gray-400">
                Here are the courses you're enrolled in and your progress.
              </p>
            </div>

            <!-- Courses List -->
            <div class="mb-8">
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