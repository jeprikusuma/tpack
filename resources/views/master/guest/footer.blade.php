    <footer>
      <div class="container d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-5">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo"  height="70" class="d-inline-block align-text-top object-fit-contain">
         <div class="text-center text-md-start mt-4 mt-md-0">
          <h5 class="fw-bold">TPACK-IPA Inclusif</h5>
          <p class="fs-6 mb-1">© 2025 TPACK-IPA Inclusif. All rights reserved.</p>
          <p class="text-primary fs-6">Privacy Policy | Terms of Service | Contact Us</p>
         </div>
      </div>
    </footer>
    
    <script src="{{asset('assets/plugin/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugin/jquery/jquery-migrate.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script>
    // Toggle manual
    document.querySelectorAll('.item').forEach(item => {
      item.querySelector('.item-header').addEventListener('click', () => {
        item.classList.toggle('open');
        const content = item.querySelector('.content');
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    });
  </script>
  <script src="{{asset('assets/plugin/owl/owl.js')}}"></script>
  <script src="{{asset('assets/scripts/carousel.js')}}"></script>
  </body>
</html>