// Fungsi untuk menampilkan nilai dari tombol yang ditekan ke layar kalkulator
function show(value) {
  // Mengambil elemen layar berdasarkan id dan menambahkan nilai yang ditekan ke konten layar
  document.getElementById("screen").value += value;
}

// Fungsi untuk menghapus semua isi di layar kalkulator (reset penuh)
function wipe() {
  // Mengatur nilai layar menjadi string kosong untuk menghapus semua input
  document.getElementById("screen").value = "";
}

// Fungsi untuk menghapus karakter terakhir pada layar kalkulator
function backspace() {
  // Mengambil elemen layar
  const screen = document.getElementById("screen");
  // Mengambil isi layar dan memotong karakter terakhir, lalu mengembalikan hasilnya ke layar
  screen.value = screen.value.slice(0, -1);
}

// Fungsi untuk melakukan perhitungan dari ekspresi yang ditampilkan di layar
function calc() {
  try {
    // Mengambil elemen layar
    const screen = document.getElementById("screen");
    // Mengevaluasi ekspresi matematika yang ada di layar menggunakan eval()
    screen.value = eval(screen.value);
  } catch (error) {
    // Jika ada kesalahan (misalnya input tidak valid), tampilkan pesan "Error" di layar
    document.getElementById("screen").value = "Error";
  }
}
