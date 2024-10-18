// Fungsi untuk menambahkan tugas baru
function addTask() {
  // Mengambil nilai teks dari input dengan id 'new-task'
  const taskText = document.getElementById("new-task").value;

  // Jika input kosong, maka tidak akan melakukan apa-apa dan fungsi berhenti
  if (taskText === "") return;

  // Mengambil elemen ul dengan id 'task-list' untuk menyimpan daftar tugas
  const taskList = document.getElementById("task-list");

  // Membuat elemen li baru yang akan menjadi item tugas
  const task = document.createElement("li");
  task.className = "task"; // Menambahkan class CSS 'task' untuk styling

  // Membuat label untuk menampilkan teks tugas
  const label = document.createElement("label");
  label.innerText = taskText; // Mengisi label dengan teks tugas dari input

  // Membuat checkbox untuk menandai tugas selesai atau belum
  const checkbox = document.createElement("input");
  checkbox.type = "checkbox"; // Menentukan tipe elemen menjadi checkbox
  
  // Event ketika checkbox diubah (dicentang/dilepas), akan menambahkan/menghapus class 'checked'
  checkbox.onchange = function() {
    task.classList.toggle("checked"); // Menambahkan atau menghapus class 'checked' (tugas selesai)
  };

  // Membuat tombol edit (✏️) untuk mengedit teks tugas
  const editBtn = document.createElement("button");
  editBtn.innerHTML = "✏️"; // Ikon edit
  
  // Event saat tombol edit diklik, akan muncul prompt untuk mengubah teks tugas
  editBtn.onclick = function() {
    const newTaskText = prompt("Edit task:", label.innerText); // Meminta teks baru dari pengguna
    if (newTaskText) { // Jika ada teks baru yang dimasukkan
      label.innerText = newTaskText; // Mengubah teks label dengan teks yang baru
    }
  };

  // Membuat tombol hapus (🗑️) untuk menghapus tugas
  const deleteBtn = document.createElement("button");
  deleteBtn.innerHTML = "🗑️"; // Ikon hapus
  
  // Event saat tombol hapus diklik, akan menghapus elemen tugas (li) dari daftar (ul)
  deleteBtn.onclick = function() {
    taskList.removeChild(task); // Menghapus item tugas dari ul
  };

  // Menambahkan checkbox, label, tombol edit, dan tombol hapus ke dalam elemen tugas (li)
  task.appendChild(checkbox); // Menambahkan checkbox
  task.appendChild(label); // Menambahkan label tugas
  task.appendChild(editBtn); // Menambahkan tombol edit
  task.appendChild(deleteBtn); // Menambahkan tombol hapus

  // Menambahkan elemen tugas yang lengkap (li) ke dalam daftar tugas (ul)
  taskList.appendChild(task);

  // Mengosongkan input setelah tugas berhasil ditambahkan
  document.getElementById("new-task").value = "";
}
