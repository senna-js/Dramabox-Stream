document.addEventListener("DOMContentLoaded", function () {
  const episodeButtons = document.querySelectorAll(".episode-button");
  const episodeTitle = document.getElementById("episodeTitle");
  const videoPlayer = document.getElementById("videoPlayer");
  const videoSource = document.getElementById("videoSource");
  const totalEpisodes = episodeTitle.getAttribute("data-total"); // Ambil total episode dari atribut data

  episodeButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const episodeNumber = this.getAttribute("data-episode");
      const videoUrl = this.getAttribute("data-video");

      // Update judul episode
      episodeTitle.textContent = `Episode [${episodeNumber}/${totalEpisodes}]`;

      // Update sumber video
      videoSource.src = videoUrl;
      videoPlayer.load(); // Muat ulang video player dengan sumber baru
      videoPlayer.play(); // Putar otomatis episode yang dipilih

      // Hapus kelas 'active' dari semua tombol episode
      episodeButtons.forEach((button) => button.classList.remove("active"));

      // Tambah kelas 'active' ke tombol episode yang diklik
      this.classList.add("active");
    });
  });
});
