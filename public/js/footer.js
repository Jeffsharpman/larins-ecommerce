// Currently only used for Lucide initialization and year update (already in HTML inline)
// You can add form submission handling here if needed

document.addEventListener('DOMContentLoaded', () => {
  // Example: prevent default form submit (for demo)
  const form = document.querySelector('.newsletter-form');
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Subscribed! (Demo)');
      form.reset();
    });
  }
});