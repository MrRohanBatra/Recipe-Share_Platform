
function startProgress() {
    const progress = document.getElementById("progress");
    const progressBar = document.querySelector(".progress-bar");
    progressBar.style.visibility = "visible";
    let width = 0;
    progress.style.width = width + "%";

    const interval = setInterval(() => {
      if (width >= 100) {
        clearInterval(interval);
        document.getElementById("registerForm").submit();
      } else {
        width += 10;
        progress.style.width = width + "%";
      }
    }, 200);
  }