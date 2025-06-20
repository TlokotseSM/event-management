<script>
  window.axiosDefaults = {
    baseURL: '/api',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    }
  };

  // For CSRF token in forms
  window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
</script>
