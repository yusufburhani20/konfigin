// TJKT SMK Fadris - Admin Dashboard JavaScript

document.addEventListener('DOMContentLoaded', () => {

  // ===== MODAL FUNCTIONS (global) =====
  window.openModal = function(id) {
    const overlay = document.getElementById(id);
    if (overlay) {
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
      // Focus first input
      setTimeout(() => {
        const firstInput = overlay.querySelector('input:not([type="hidden"]), textarea, select');
        firstInput?.focus();
      }, 100);
    }
  };

  window.closeModal = function(id) {
    const overlay = document.getElementById(id);
    if (overlay) {
      overlay.classList.remove('open');
      document.body.style.overflow = '';
    }
  };

  // Close modal on overlay click
  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) {
        overlay.classList.remove('open');
        document.body.style.overflow = '';
      }
    });
  });

  // Close modal on ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal-overlay.open').forEach(overlay => {
        overlay.classList.remove('open');
        document.body.style.overflow = '';
      });
    }
  });

  // ===== AUTO DISMISS ALERTS =====
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.5s, transform 0.5s';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-10px)';
      setTimeout(() => alert.remove(), 500);
    }, 4000);
  });

  // ===== ACTIVE SIDEBAR LINK - highlight current page =====
  const currentPath = window.location.pathname;
  document.querySelectorAll('.sidebar-link').forEach(link => {
    if (link.href && link.href.includes(currentPath.split('/').pop())) {
      link.classList.add('active');
    }
  });

});
