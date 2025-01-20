<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Course - YoUdemy Dashboard</title>
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
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="teacher_dashboard.php">
                <span class="ml-4">Dashboard</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="create_course.php">
                <span class="ml-4">Add a New Course</span>
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
            <h1 class="text-2xl font-semibold">Create Course</h1>
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
                Create a New Course
              </h2>
              <p class="text-gray-600 dark:text-gray-400">
                Fill out the form below to add a new course.
              </p>
            </div>

            <!-- Course Creation Form -->
            <div class="mb-8">
              <form>
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Course Title</span>
                  <input
                    type="text"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Introduction to Programming"
                    required
                  />
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Description</span>
                  <textarea
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    rows="3"
                    placeholder="A beginner-friendly course on programming fundamentals."
                    required
                  ></textarea>
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Content</span>
                  <textarea
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    rows="5"
                    placeholder="Course content goes here..."
                    required
                  ></textarea>
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Tags</span>
                  <input
                    type="text"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="programming, beginner, coding"
                    required
                  />
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Category</span>
                  <select
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    required
                  >
                    <option value="programming">Programming</option>
                    <option value="web-development">Web Development</option>
                    <option value="data-science">Data Science</option>
                  </select>
                </label>

                <button
                  type="submit"
                  class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                  Create Course
                </button>
              </form>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>