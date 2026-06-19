{{-- Page Loader & Transition Overlay --}}
<div id="pageLoader" class="fixed inset-0 z-[100] bg-emerald-900 flex flex-col items-center justify-center transition-opacity duration-500 opacity-0 pointer-events-none">
    <div class="relative">
        <div class="w-16 h-16 rounded-full border-4 border-emerald-700"></div>
        <div class="absolute inset-0 w-16 h-16 rounded-full border-4 border-gold-400 border-t-transparent animate-spin"></div>
    </div>
    <div class="mt-6 text-center">
        <img src="{{ asset('salamapaylogo.png') }}" alt="SalamaPay" class="h-8 mx-auto mb-2 opacity-80">
        <p class="text-emerald-200 text-sm animate-pulse">Loading...</p>
    </div>
</div>

{{-- Smooth Page Transition Script --}}
<script>
(function() {
    const loader = document.getElementById('pageLoader');

    function showLoader() {
        if (loader) {
            loader.classList.remove('opacity-0', 'pointer-events-none');
            loader.classList.add('opacity-100');
        }
    }

    function hideLoader() {
        if (loader) {
            loader.classList.add('opacity-0', 'pointer-events-none');
            loader.classList.remove('opacity-100');
        }
    }

    // Show loader when leaving page
    document.querySelectorAll('a[href]:not([href^="#"]):not([href^="javascript"]):not([target="_blank"]):not([href^="mailto"]):not([href^="tel"])').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('javascript') && this.hostname === location.hostname) {
                showLoader();
            }
        });
    });

    // Show loader on form submit
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function() {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';
            }
            showLoader();
        });
    });

    // Hide loader when page fully loaded
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) hideLoader();
    });

    window.addEventListener('load', hideLoader);

    // Fallback: hide after max 5 seconds
    setTimeout(hideLoader, 5000);
})();
</script>
