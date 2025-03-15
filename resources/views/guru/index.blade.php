<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Extended Tables
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Roboto', sans-serif;
        }
        .sidebar-link {
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar-link:hover {
            background-color: #4a5568;
            color: #ffffff;
        }
        .active {
            background-color: #2d3748;
            color: #ffffff;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .submit-btn {
            transition: background-color 0.3s, transform 0.3s;
        }
        .submit-btn:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }
        .table-row {
            transition: background-color 0.3s;
        }
        .table-row:hover {
            background-color: #f3f4f6;
        }
        .sidebar {
            background: rgba(0, 0, 0, 0.7);
            background-image: url('https://placehold.co/300x600');
            background-size: cover;
            background-blend-mode: darken;
        }
  </style>
 </head>
 <body class="bg-gray-100">
  <div class="flex">
   <!-- Sidebar -->
   <div class="sidebar w-64 text-white min-h-screen">
    <div class="p-4 flex items-center">
     <img alt="User profile picture" class="rounded-full mr-3" height="40" src="https://storage.googleapis.com/a1aa/image/WaoPjqCJgZuy-pYKkUhnokfd7Quy63wxfF83rEbNiSk.jpg" width="40"/>
     <div>
      <h2 class="text-lg font-semibold">
       Jenifer Lopez
      </h2>
     </div>
    </div>
    <nav class="mt-10">
     <a class="sidebar-link flex items-center py-2 px-6 text-gray-300" href="#" onclick="showPage('dashboard')">
      <i class="fas fa-tachometer-alt mr-3">
      </i>
      Dashboard
     </a>
     <a class="sidebar-link flex items-center py-2 px-6 text-gray-300" href="#" onclick="showPage('input-nilai')">
      <i class="fas fa-edit mr-3">
      </i>
      Input Nilai
     </a>
     <a class="sidebar-link flex items-center py-2 px-6 text-gray-300" href="#" onclick="showPage('daftar-nilai')">
      <i class="fas fa-table mr-3">
      </i>
      Daftar Nilai
     </a>
     <a class="sidebar-link flex items-center py-2 px-6 text-gray-300 mt-6" href="#">
      <i class="fas fa-sign-out-alt mr-3">
      </i>
      Logout
     </a>
    </nav>
   </div>
   <!-- Main Content -->
   <div class="flex-1 p-6">
    <!-- Dashboard Page -->
    <div class="page" id="dashboard">
     <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold">
       Dashboard
      </h1>
     </div>
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="card bg-white p-6 rounded-lg shadow">
       <div class="flex items-center">
        <div class="bg-blue-500 text-white rounded-full p-3 mr-4">
         <i class="fas fa-users">
         </i>
        </div>
        <div>
         <h2 class="text-lg font-semibold">
          Total Students
         </h2>
         <p class="text-gray-600">
          150
         </p>
        </div>
       </div>
      </div>
      <div class="card bg-white p-6 rounded-lg shadow">
       <div class="flex items-center">
        <div class="bg-green-500 text-white rounded-full p-3 mr-4">
         <i class="fas fa-book">
         </i>
        </div>
        <div>
         <h2 class="text-lg font-semibold">
          Total Subjects
         </h2>
         <p class="text-gray-600">
          10
         </p>
        </div>
       </div>
      </div>
      <div class="card bg-white p-6 rounded-lg shadow">
       <div class="flex items-center">
        <div class="bg-red-500 text-white rounded-full p-3 mr-4">
         <i class="fas fa-chalkboard-teacher">
         </i>
        </div>
        <div>
         <h2 class="text-lg font-semibold">
          Total Teachers
         </h2>
         <p class="text-gray-600">
          20
         </p>
        </div>
       </div>
      </div>
     </div>
     <div class="mt-6">
      <h2 class="text-xl font-semibold mb-4">
       Schedule
      </h2>
      <div class="bg-white p-6 rounded-lg shadow">
       <ul>
        <li class="flex items-center mb-4">
         <div class="bg-blue-500 text-white rounded-full p-3 mr-4">
          <i class="fas fa-calendar-alt">
          </i>
         </div>
         <div>
          <p class="text-gray-600">
           UTS Start Date:
           <span class="font-semibold">
            1st March 2023
           </span>
          </p>
          <p class="text-gray-600">
           UTS End Date:
           <span class="font-semibold">
            10th March 2023
           </span>
          </p>
         </div>
        </li>
        <li class="flex items-center mb-4">
         <div class="bg-green-500 text-white rounded-full p-3 mr-4">
          <i class="fas fa-calendar-alt">
          </i>
         </div>
         <div>
          <p class="text-gray-600">
           UAS Start Date:
           <span class="font-semibold">
            1st June 2023
           </span>
          </p>
          <p class="text-gray-600">
           UAS End Date:
           <span class="font-semibold">
            10th June 2023
           </span>
          </p>
         </div>
        </li>
       </ul>
      </div>
     </div>
    </div>
    <!-- Input Nilai Page -->
    <div class="page hidden" id="input-nilai">
     <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold">
       Input Nilai
      </h1>
     </div>
     <form>
      <div class="mb-4">
       <label class="block text-gray-700">
        Nama Siswa
       </label>
       <input class="w-full border rounded py-2 px-4" placeholder="Nama Siswa" type="text"/>
      </div>
      <div class="mb-4">
       <label class="block text-gray-700">
        Mata Pelajaran
       </label>
       <select class="w-full border rounded py-2 px-4">
        <option value="matematika">
         Matematika
        </option>
        <option value="bahasa_indonesia">
         Bahasa Indonesia
        </option>
        <option value="bahasa_inggris">
         Bahasa Inggris
        </option>
        <option value="ipa">
         IPA
        </option>
        <option value="ips">
         IPS
        </option>
       </select>
      </div>
      <div class="mb-4">
       <label class="block text-gray-700">
        Nilai Tugas
       </label>
       <input class="w-full border rounded py-2 px-4" placeholder="Nilai Tugas" type="number"/>
      </div>
      <div class="mb-4">
       <label class="block text-gray-700">
        Nilai UTS
       </label>
       <input class="w-full border rounded py-2 px-4" placeholder="Nilai UTS" type="number"/>
      </div>
      <div class="mb-4">
       <label class="block text-gray-700">
        Nilai UAS
       </label>
       <input class="w-full border rounded py-2 px-4" placeholder="Nilai UAS" type="number"/>
      </div>
      <button class="submit-btn bg-blue-500 text-white py-2 px-4 rounded" type="submit">
       Submit
      </button>
     </form>
    </div>
    <!-- Daftar Nilai Page -->
    <div class="page hidden" id="daftar-nilai">
     <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold">
       Daftar Nilai
      </h1>
     </div>
     <table class="w-full text-left" id="nilai-table">
      <thead>
       <tr class="border-b">
        <th class="py-2">
         #
        </th>
        <th class="py-2">
         Nama Siswa
        </th>
        <th class="py-2">
         Mata Pelajaran
        </th>
        <th class="py-2">
         Nilai Tugas
        </th>
        <th class="py-2">
         Nilai UTS
        </th>
        <th class="py-2">
         Nilai UAS
        </th>
       </tr>
      </thead>
      <tbody>
       <tr class="table-row border-b">
        <td class="py-2">
         1
        </td>
        <td class="py-2">
         John Doe
        </td>
        <td class="py-2">
         Matematika
        </td>
        <td class="py-2">
         90
        </td>
        <td class="py-2">
         85
        </td>
        <td class="py-2">
         88
        </td>
       </tr>
       <tr class="table-row border-b">
        <td class="py-2">
         2
        </td>
        <td class="py-2">
         Jane Smith
        </td>
        <td class="py-2">
         Bahasa Indonesia
        </td>
        <td class="py-2">
         80
        </td>
        <td class="py-2">
         75
        </td>
        <td class="py-2">
         78
        </td>
       </tr>
      </tbody>
     </table>
    </div>
   </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js">
  </script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js">
  </script>
  <script>
   $(document).ready(function() {
            $('#nilai-table').DataTable();
        });

        function showPage(pageId) {
            const pages = document.querySelectorAll('.page');
            pages.forEach(page => {
                page.classList.add('hidden');
            });
            document.getElementById(pageId).classList.remove('hidden');

            const links = document.querySelectorAll('.sidebar-link');
            links.forEach(link => {
                link.classList.remove('active');
            });
            document.querySelector(`[onclick="showPage('${pageId}')"]`).classList.add('active');
        }
  </script>
 </body>
</html>
