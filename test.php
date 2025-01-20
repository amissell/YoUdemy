<?php
// require '../db_conn.php';
// require '../classes/tag.php';
// require '../models/tags.php';

require_once __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/classes/Tag.php';
require __DIR__ . '/../models/tags.php';


use app\classes\Tag;
use app\models\Tags;
use app\batabases\DBConnection;

$conn = new DBConnection();
$connection = $conn->getConnection();
// if ($connection) {
//     echo "tkherbi9a";
// }
$tags = new Tags($connection); // Correct: Passing PDO object


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tag'])) {
    $tagName = trim($_POST['tag_name']);
    // var_dump($connection instanceof PDO);

    if (!empty($tagName)) {
        // var_dump($tagName);
        $newTag = new Tag(null, $tagName);
        if ($tags->saveTag($newTag)) {
            echo "<script>alert('Tag added successfully!');</script>";
        } else {
            echo "<script>alert('Failed to add tag.');</script>";
        }
    } else {
        echo "<script>alert('Tag name cannot be empty.');</script>";
    }
}




// Handle updating a tag
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tag'])) {
    $tagId = $_POST['tag_id'];
    $tagName = trim($_POST['tag_name']);

    if (!empty($tagName)) {
        $updatedTag = new Tag($tagId, $tagName);
        if ($tags->updateTag($updatedTag)) {
            echo "<script>alert('Tag updated successfully!'); window.location.href='category-tag-management.php';</script>";
        } else {
            echo "<script>alert('Failed to update tag.');</script>";
        }
    } else {
        echo "<script>alert('Tag name cannot be empty.');</script>";
    }
}



if (isset($_GET['delete'])) {
    $tagId = $_GET['delete'];
    if ($tags->deleteTag($tagId)) {
        echo "<script>alert('Tag deleted successfully!'); window.location.href='category-tag-management.php';</script>";
    } else {
        echo "<script>alert('Failed to delete tag.'); window.location.href='category-tag-management.php';</script>";
    }
}

// Check if we're in edit mode
$editTagId = isset($_GET['edit']) ? $_GET['edit'] : null;


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category & Tag Management - YoUdemy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen">
        <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
            <div class="py-4 text-gray-500 dark:text-gray-400">
                <!-- Logo -->
                <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="index.php">
                    YoUdemy
                </a>
                <!-- Sidebar Menu -->
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
                    <!-- Category & Tag Management -->
                    <li class="relative px-6 py-3">
                        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="category-tag-management.php">
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
        <main class="h-full overflow-y-auto flex-1">
            <div class="container px-6 mx-auto">
                <!-- Page Title -->
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Category & Tag Management
                </h2>

                <!-- Add Category Form -->
                <div class="mb-8 p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Add New Category</h3>
                    <form action="category-tag-management.php" method="POST">
                        <div class="mb-4">
                            <label for="category_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                            <input type="text" name="category_name" id="category_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label for="category_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="category_description" id="category_description" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"></textarea>
                        </div>
                        <button type="submit" name="add_category" class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700">Add Category</button>
                    </form>
                </div>

                <!-- Add Tag Form -->
                <div class="mb-8 p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Add New Tag</h3>
                    <form action="category-tag-management.php" method="POST">
                        <div class="mb-4">
                            <label for="tag_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tag Name</label>
                            <input type="text" name="tag_name" id="tag_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                        </div>
                        <button type="submit" name="add_tag" class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700">Add Tag</button>
                    </form>
                </div>

                <!-- Categories Table -->
                <div class="mb-8 p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Categories</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Description</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                <!-- Example Category Row -->
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">Web Development</td>
                                    <td class="px-4 py-3">Courses related to web development.</td>
                                    <td class="px-4 py-3">
                                        <button class="text-purple-600 hover:text-purple-900">Edit</button>
                                        <button class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tags Table -->
                <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Tags</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                                <?php
                                $allTags = $tags->getAllTags();
                                foreach ($allTags as $tag) {
                                    $isEditing = isset($_GET['edit']) && $_GET['edit'] == $tag->getId();

                                    if ($isEditing) {
                                        // Display the edit form
                                        echo "
                                        <tr class='text-gray-700 dark:text-gray-400'>
                                            <td class='px-4 py-3'>
                                                <form action='category-tag-management.php' method='POST'>
                                                    <input type='hidden' name='tag_id' value='{$tag->getId()}'>
                                                    <input type='text' name='tag_name' value='{$tag->getName()}' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200' required>
                                            </td>
                                            <td class='px-4 py-3'>
                                                    <button type='submit' name='update_tag' class='text-purple-600 hover:text-purple-900'>Save</button>
                                                    <a href='category-tag-management.php' class='text-red-600 hover:text-red-900 ml-2'>Cancel</a>
                                                </form>
                                            </td>
                                        </tr>
                                        ";
                                    } else {
                                        echo "
                                        <tr class='text-gray-700 dark:text-gray-400'>
                                            <td class='px-4 py-3'>{$tag->getName()}</td>
                                            <td class='px-4 py-3'>
                                                <a href='category-tag-management.php?edit={$tag->getId()}' class='text-purple-600 hover:text-purple-900'>Edit</a>
                                                <a href='category-tag-management.php?delete={$tag->getId()}' class='text-red-600 hover:text-red-900 ml-2' onclick='return confirm(\"Are you sure you want to delete this tag?\");'>Delete</a>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>