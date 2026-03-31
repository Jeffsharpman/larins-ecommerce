// trust-badges.js
document.addEventListener('DOMContentLoaded', () => {
  const grid = document.querySelector('.badges-grid');
  if (!grid) return;

  const observer = new IntersectionObserver(
    ([entry]) => {
      if (entry.isIntersecting) {
        grid.classList.add('visible');
        observer.unobserve(grid);
      }
    },
    { threshold: 0.1 }
  );

  observer.observe(grid);
});