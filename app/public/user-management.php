<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Management - YoUdemy Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="./assets/js/init-alpine.js"></script>
</head>

<body>
  <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}">
    <!-- Desktop sidebar -->
    <aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block">
      <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
          YoUdemy
        </a>
        <ul class="mt-6">
          <!-- Dashboard -->
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="index.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              <span class="ml-4">Dashboard</span>
            </a>
          </li>

          <!-- User Management -->
          <li class="relative px-6 py-3">
            <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="user-management.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
              <span class="ml-4">User Management</span>
            </a>
          </li>
          <!-- Category & Tag Management -->
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="category-tag-management.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
              </svg>
              <span class="ml-4">Category & Tag Management</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex flex-col flex-1 w-full">
      <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
        <!-- Header content (if any) -->
      </header>

      <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
          <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            User Management
          </h2>

          <!-- Pending Teacher Applications Table -->
          <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Pending Teacher Applications
          </h4>
          <div class="w-full overflow-hidden rounded-lg shadow-xs mb-8">
            <div class="w-full overflow-x-auto">
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">User ID</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Application Date</th>
                    <th class="px-4 py-3">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                  <!-- Example Row 1 -->
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">3</td>
                    <td class="px-4 py-3 text-sm">Alice Johnson</td>
                    <td class="px-4 py-3 text-sm">alice.johnson@example.com</td>
                    <td class="px-4 py-3 text-sm">2023-10-01</td>
                    <td class="px-4 py-3">
                      <div class="flex items-center space-x-4 text-sm">
                        <!-- Accept Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 transition-colors duration-150 bg-green-100 rounded-lg hover:bg-green-200 focus:outline-none focus:shadow-outline-green" onclick="acceptTeacher(3)">
                          Accept
                        </button>
                        <!-- Reject Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 transition-colors duration-150 bg-red-100 rounded-lg hover:bg-red-200 focus:outline-none focus:shadow-outline-red" onclick="rejectTeacher(3)">
                          Reject
                        </button>
                      </div>
                    </td>
                  </tr>

                  <!-- Example Row 2 -->
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">4</td>
                    <td class="px-4 py-3 text-sm">Bob Brown</td>
                    <td class="px-4 py-3 text-sm">bob.brown@example.com</td>
                    <td class="px-4 py-3 text-sm">2023-10-05</td>
                    <td class="px-4 py-3">
                      <div class="flex items-center space-x-4 text-sm">
                        <!-- Accept Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 transition-colors duration-150 bg-green-100 rounded-lg hover:bg-green-200 focus:outline-none focus:shadow-outline-green" onclick="acceptTeacher(4)">
                          Accept
                        </button>
                        <!-- Reject Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 transition-colors duration-150 bg-red-100 rounded-lg hover:bg-red-200 focus:outline-none focus:shadow-outline-red" onclick="rejectTeacher(4)">
                          Reject
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <span class="flex items-center col-span-3">
                Showing 1-2 of 2
              </span>
              <span class="col-span-2"></span>
              <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                  <ul class="inline-flex items-center">
                    <li>
                      <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                        <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                          <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                        1
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                        2
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                        3
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                        4
                      </button>
                    </li>
                    <li>
                      <span class="px-3 py-1">...</span>
                    </li>
                    <li>
                      <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                        <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                          <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293 3.293a1 1 0 01-1.414 1.414l4-4a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </li>
                  </ul>
                </nav>
              </span>
            </div>
          </div>

          <!-- User Table -->
          <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Active Users
          </h4>
          <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">User ID</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                  <!-- Example Row 1 -->
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">1</td>
                    <td class="px-4 py-3 text-sm">John Doe</td>
                    <td class="px-4 py-3 text-sm">john.doe@example.com</td>
                    <td class="px-4 py-3 text-sm">Teacher</td>
                    <td class="px-4 py-3 text-sm text-green-600 font-bold">Active</td>
                    <td class="px-4 py-3">
                      <div class="flex items-center space-x-4 text-sm">
                        <!-- Activate Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 transition-colors duration-150 bg-blue-100 rounded-lg hover:bg-blue-200 focus:outline-none focus:shadow-outline-blue">
                          Activate
                        </button>
                        <!-- Suspend Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-yellow-600 transition-colors duration-150 bg-yellow-100 rounded-lg hover:bg-yellow-200 focus:outline-none focus:shadow-outline-yellow">
                          Suspend
                        </button>
                        <!-- Delete Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 transition-colors duration-150 bg-red-100 rounded-lg hover:bg-red-200 focus:outline-none focus:shadow-outline-red">
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>

                  <!-- Example Row 2 -->
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">2</td>
                    <td class="px-4 py-3 text-sm">Jane Smith</td>
                    <td class="px-4 py-3 text-sm">jane.smith@example.com</td>
                    <td class="px-4 py-3 text-sm">Student</td>
                    <td class="px-4 py-3 text-sm text-red-600 font-bold">Suspended</td>
                    <td class="px-4 py-3">
                      <div class="flex items-center space-x-4 text-sm">
                        <!-- Activate Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 transition-colors duration-150 bg-blue-100 rounded-lg hover:bg-blue-200 focus:outline-none focus:shadow-outline-blue">
                          Activate
                        </button>
                        <!-- Suspend Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-yellow-600 transition-colors duration-150 bg-yellow-100 rounded-lg hover:bg-yellow-200 focus:outline-none focus:shadow-outline-yellow">
                          Suspend
                        </button>
                        <!-- Delete Button -->
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 transition-colors duration-150 bg-red-100 rounded-lg hover:bg-red-200 focus:outline-none focus:shadow-outline-red">
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <span class="flex items-center col-span-3">
                Showing 1-2 of 2
              </span>
              <span class="col-span-2"></span>
              <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                  <ul class="inline-flex items-center">
                    <li>
                      <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                        <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                          <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                        1
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                        2
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 text-white transition-colorsOops! DeepSeek is experiencing high traffic at the moment. Please check back in a little while.Oops! DeepSeek is experiencing high traffic at the moment. Please check back in a little while.