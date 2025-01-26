document.querySelectorAll('.episode-button').forEach(button => {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      const videoUrl = this.getAttribute('data-video');
      const videoPlayer = document.getElementById('videoPlayer');
      const videoSource = document.getElementById('videoSource');
      if (videoSource) {
        videoSource.src = videoUrl;
        videoPlayer.load();
        videoPlayer.play();
      }
    });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const videoPlayer = document.getElementById('videoPlayer');
    if (videoPlayer) {
      videoPlayer.play();
    }
  });
  