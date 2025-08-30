// Load Font Awesome
const fa = document.createElement("link");
fa.rel = "stylesheet";
fa.href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css";
document.head.appendChild(fa);

document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.createElement("div");
  toggle.className = "darkmode-toggle";

  const icon = document.createElement("i");
  icon.className = "fas fa-moon"; // Start with moon
  toggle.appendChild(icon);
  document.body.appendChild(toggle);

  toggle.addEventListener("click", () => {
    const isDark = document.body.classList.toggle("dark-mode");
    icon.className = isDark ? "fas fa-sun" : "fas fa-moon";
  });

  // Make draggable
  let isDragging = false, offsetX = 0, offsetY = 0;

  toggle.addEventListener("mousedown", (e) => {
    isDragging = true;
    offsetX = e.clientX - toggle.offsetLeft;
    offsetY = e.clientY - toggle.offsetTop;
    toggle.style.transition = "none";
  });

  document.addEventListener("mousemove", (e) => {
    if (isDragging) {
      toggle.style.left = `${e.clientX - offsetX}px`;
      toggle.style.top = `${e.clientY - offsetY}px`;
    }
  });

  document.addEventListener("mouseup", () => {
    isDragging = false;
    toggle.style.transition = "all 0.3s ease";
  });
});
